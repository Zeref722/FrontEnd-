<?php
include 'head.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in first!'); window.location.href = 'login.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch the latest package details from membership_selection
$packages_query = $con->query("
    SELECT package_name, package_price, add_ons 
    FROM membership_selection 
    WHERE package_name IN ('1 Month Plan', '3 Months Plan', '6 Months Plan', '1 Year Plan')
    GROUP BY package_name 
    ORDER BY selected_at DESC
");
$packages = [];
while ($row = $packages_query->fetch_assoc()) {
    $packages[$row['package_name']] = [
        'price' => $row['package_price'],
        'add_ons' => $row['add_ons'] ? explode(',', $row['add_ons']) : []
    ];
}

// Define default packages
$default_packages = [
    '1 Month Plan' => ['min_price' => 1500, 'max_price' => 3000],
    '3 Months Plan' => ['min_price' => 4000, 'max_price' => 7000],
    '6 Months Plan' => ['min_price' => 7500, 'max_price' => 12000],
    '1 Year Plan' => ['min_price' => 12000, 'max_price' => 20000]
];

// Default add-ons with prices if not updated by admin
$default_add_ons = [
    'Personal Training' => 1000,
    'Cardio' => 500,
    'Diet Plan' => 800
];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['select_plan'])) {
    $package_name = mysqli_real_escape_string($con, $_POST['package_name']);
    $package_price = floatval($_POST['package_price']);
    $add_ons = isset($_POST['add_ons']) ? implode(',', array_map('mysqli_real_escape_string', array_fill(0, count($_POST['add_ons']), $con), $_POST['add_ons'])) : 'None';

    $stmt = $con->prepare("INSERT INTO membership_selection (user_id, package_name, package_price, add_ons) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isds", $user_id, $package_name, $package_price, $add_ons);

    if ($stmt->execute()) {
        echo "<script>alert('Package selected successfully!'); window.location.href = 'dashboard.php';</script>";
    } else {
        echo "<script>alert('Error selecting package: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gym Membership Plans</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        html, body { height: 100%; margin: 0; padding: 0; }
        body { background-image: url('css/GG.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; }
        .navbar { background-color: rgba(0, 0, 0, 0.83); }
        .navbar-brand, .navbar-text, .btn-login a { color: white !important; }
        .container { background: rgba(85, 84, 84, 0.9); padding: 20px; border-radius: 10px; min-height: 100%; }
        .card { height: 100%; background: black; transition: all 0.3s ease; position: relative; overflow: hidden; z-index: 0; }
        .card:hover { transform: scale(1.05); }
        .card:hover::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(240, 160, 10, 0.86); backdrop-filter: blur(5px); z-index: 1; }
        .card-body { display: flex; flex-direction: column; position: relative; z-index: 2; }
        .card-text { flex-grow: 1; display: flex; flex-direction: column; justify-content: space-around; }
        .card-title, .card-subtitle, .card-text, .card-text p { color: white !important; }
        h2 { color: white; }
        .btn-primary { background-color: #f0a00a; border-color: #f0a00a; z-index: 2; position: relative; }
        .btn-primary:hover { background-color: #d89000; border-color: #d89000; }
        .slider-tab { position: fixed; top: 0; right: -400px; width: 400px; height: 100%; background: white; box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1); transition: right 0.3s ease; padding: 20px; z-index: 1000; overflow-y: auto; }
        .slider-tab.open { right: 0; }
        .slider-tab h3 { margin-bottom: 20px; }
        .slider-tab .form-check { margin-bottom: 15px; }
        .slider-tab .total-price { font-size: 1.2em; font-weight: bold; margin-top: 20px; }
        .overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 999; }
        .overlay.active { display: block; }
        .close-btn { position: absolute; top: 10px; right: 10px; }
    </style>
</head>
<body class="d-flex flex-column">
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="temp.php">PRO-FITT</a>
            <div class="d-flex">
                <span class="navbar-text me-2">Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</span>
                <button class="btn btn-login"><a href="logout.php">LOGOUT</a></button>
            </div>
        </div>
    </nav>

    <div class="container my-5 flex-grow-1 d-flex flex-column">
        <h2 class="text-center mb-4">Choose Your Gym Membership Plan</h2>
        <div class="row flex-grow-1">
            <?php
            $plan_details = [
                '1 Month Plan' => ['desc' => ['Best for trial & beginners', 'Short-term commitment', 'Basic gym access', 'Flexible scheduling', 'Access to basic equipment']],
                '3 Months Plan' => ['desc' => ['Cost-effective option', 'Helps build consistency', 'Group classes included', 'Personal trainer consultation', 'Access to advanced equipment']],
                '6 Months Plan' => ['desc' => ['Long-term commitment', 'Better results guaranteed', 'Exclusive discount offers', 'Nutrition consultation', 'Access to all gym amenities']],
                '1 Year Plan' => ['desc' => ['Best value for money', 'Extra perks and benefits', 'Sauna & spa access', 'Personalized fitness plan', 'Bring-a-friend passes']]
            ];

            foreach ($default_packages as $plan_name => $price_range) {
                $min_price = isset($packages[$plan_name]) ? $packages[$plan_name]['price'] : $price_range['min_price'];
                $max_price = $price_range['max_price'];
            ?>
                <div class="col-md-3 mb-4">
                    <div class="card text-center h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fs-4 mb-3"><?php echo htmlspecialchars($plan_name); ?></h5>
                            <h6 class="card-subtitle mb-4 text-muted fs-5">₹<?php echo number_format($min_price, 0); ?> - ₹<?php echo number_format($max_price, 0); ?></h6>
                            <div class="card-text flex-grow-1 d-flex flex-column justify-content-around">
                                <?php foreach ($plan_details[$plan_name]['desc'] as $desc) { ?>
                                    <p class="mb-3"><?php echo htmlspecialchars($desc); ?></p>
                                <?php } ?>
                            </div>
                            <a href="#" class="btn btn-primary mt-4" onclick="openSliderTab('<?php echo htmlspecialchars($plan_name); ?>', <?php echo $min_price; ?>, <?php echo $max_price; ?>)">Choose Plan</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="slider-tab" id="sliderTab">
        <button class="btn btn-danger close-btn" onclick="closeSliderTab()">X</button>
        <form method="POST" id="planForm">
            <input type="hidden" name="select_plan" value="1">
            <input type="hidden" name="package_name" id="packageName">
            <input type="hidden" name="package_price" id="packagePrice">
            <h3 id="planName">Plan Details</h3>
            <p><strong>Price Range:</strong> <span id="planPriceRange"></span></p>
            <p>Select add-ons:</p>
            <?php
            // Dynamically generate add-ons based on the latest admin update or defaults
            $available_add_ons = $default_add_ons;
            foreach ($packages as $pkg) {
                if (!empty($pkg['add_ons'])) {
                    $available_add_ons = array_merge($available_add_ons, array_fill_keys($pkg['add_ons'], 0));
                }
            }
            foreach ($available_add_ons as $add_on => $price) {
                $add_on_id = str_replace(' ', '', strtolower($add_on)); // e.g., "PersonalTraining"
                $display_price = isset($default_add_ons[$add_on]) ? $default_add_ons[$add_on] : 0; // Default price or 0 if custom
            ?>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="add_ons[]" id="<?php echo $add_on_id; ?>" value="<?php echo htmlspecialchars($add_on); ?>">
                    <label class="form-check-label" for="<?php echo $add_on_id; ?>">
                        <?php echo htmlspecialchars($add_on) . " (+₹" . number_format($display_price, 0) . ")"; ?>
                    </label>
                </div>
            <?php } ?>
            <div class="total-price"><strong>Total Price:</strong> ₹<span id="totalPrice">0</span></div>
            <button type="submit" class="btn btn-primary mt-3">PAY NOW</button>
        </form>
    </div>

    <div class="overlay" id="overlay" onclick="closeSliderTab()"></div>

    <script>
        function openSliderTab(planName, minPrice, maxPrice) {
            const sliderTab = document.getElementById('sliderTab');
            const overlay = document.getElementById('overlay');
            const planNameElement = document.getElementById('planName');
            const planPriceRangeElement = document.getElementById('planPriceRange');
            const packageNameInput = document.getElementById('packageName');
            const packagePriceInput = document.getElementById('packagePrice');

            planNameElement.textContent = planName;
            planPriceRangeElement.textContent = `₹${minPrice} - ₹${maxPrice}`;
            packageNameInput.value = planName;
            packagePriceInput.value = minPrice;

            sliderTab.classList.add('open');
            overlay.classList.add('active');

            document.querySelectorAll('.form-check-input').forEach(checkbox => checkbox.checked = false);
            updateTotalPrice(minPrice);
        }

        function closeSliderTab() {
            const sliderTab = document.getElementById('sliderTab');
            const overlay = document.getElementById('overlay');
            sliderTab.classList.remove('open');
            overlay.classList.remove('active');
        }

        function updateTotalPrice(basePrice) {
            const checkboxes = document.querySelectorAll('.form-check-input');
            let totalPrice = basePrice;
            const addOnValues = {
                <?php
                foreach ($available_add_ons as $add_on => $price) {
                    $add_on_id = str_replace(' ', '', strtolower($add_on));
                    echo "'$add_on_id': $price,";
                }
                ?>
            };

            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    totalPrice += addOnValues[checkbox.id] || 0;
                }
            });

            document.getElementById('totalPrice').textContent = totalPrice;
            document.getElementById('packagePrice').value = totalPrice;
        }

        document.querySelectorAll('.form-check-input').forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                const minPrice = parseInt(document.getElementById('planPriceRange').textContent.split(' - ')[0].replace('₹', ''));
                updateTotalPrice(minPrice);
            });
        });

        document.getElementById('planForm').addEventListener('submit', function(e) {
            const totalPrice = parseInt(document.getElementById('totalPrice').textContent);
            if (!confirm(`Confirm payment of ₹${totalPrice}?`)) {
                e.preventDefault();
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>