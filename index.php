<?php include 'head.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRO-FITT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            color: white;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .navbar {
            background-color: rgba(0, 0, 0, 0.83);
            z-index: 1030;
            width: 100%;
        }
        .navbar-brand, .navbar-nav .nav-link, .navbar-text { color: white !important; }
        .content-wrapper {
            flex-grow: 1;
            background-image: url('css/3d-gym-equipment (1).jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .content {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            flex-grow: 1;
            width: 100%;
        }
        .main-content { padding-top: 2rem; }
        .section { margin-bottom: 4rem; width: 100%; }
        .intro-section { text-align: center; padding: 4rem 0; }
        .card {
            background-color: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            color: #333;
            height: 100%;
        }
        .card h5 { color: #f06c00; margin-bottom: 1rem; }
        .card-container { margin-top: 2rem; }
        .intro-section h1 { font-size: 3.5rem; margin-bottom: 1.5rem; }
        .intro-section p { font-size: 1.4rem; margin-bottom: 2.5rem; }
        .btn-start-quiz {
            background-color: #f06c00;
            color: white;
            padding: 12px 24px;
            font-size: 1.2rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-transform: uppercase;
        }
        .btn-start-quiz:hover { background-color: #e55a00; }
        .testimonial-section { background-color: transparent; padding: 4rem 0; border-radius: 10px; }
        .testimonial {
            font-size: 1.1rem;
            line-height: 1.8;
            color: white;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 2rem;
            border-radius: 10px;
            margin-bottom: 2rem;
        }
        .testimonial strong { font-size: 1rem; color: #f06c00; }
        .testimonial-section h2 { color: #f06c00; font-size: 2.5rem; margin-bottom: 1.5rem; }
        ul { padding-left: 1.5rem; }
        ul li { margin-bottom: 1rem; color: white; font-size: 1.1rem; }
        .footer { background-color: #343a40; color: white; padding: 4rem 0; }
        .footer h5 { color: #ffc107; font-size: 1.3rem; margin-bottom: 1.5rem; }
        .footer a { color: white; text-decoration: none; }
        .footer a:hover { color: #ffc107; }
        .social-icons a { font-size: 1.8rem; margin-right: 1.5rem; }
        .btn-login { background-color: transparent; border: 1px solid white; color: white; }
        .btn-login:hover { background-color: white; color: black; }
        .btn-become-member { background-color: #28a745; border: 1px solid #28a745; color: white; }
        .btn-become-member:hover { background-color: #218838; border-color: #1e7e34; }
        .btn-start-quiz:disabled { background-color: #6c757d; cursor: not-allowed; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img class="d-inline-block align-text-top" width="100px" src="css/PRO-Photoroom.png" alt="PRO-FITT"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                </ul>
                <div class="d-flex">
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <button class="btn btn-login me-2"><a href="login.php">LOGIN</a></button>
                        <button class="btn btn-become-member ms-2"><a href="register.php">BECOME A MEMBER</a></button>
                    <?php else: ?>
                        <span class="navbar-text me-2">Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</span>
                        <button class="btn btn-login"><a href="logout.php">LOGOUT</a></button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="content-wrapper">
        <div class="main-content">
            <div class="content">
                <section class="intro-section section">
                    <h1 style="color: orange;">PRO-FITT</h1>
                    <p>Welcome to your fitness journey!</p>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <button class="btn-start-quiz" disabled title="Become a member first to start the quiz"><a href="register.php">Enroll NOW !!</a></button>
                    <?php else: ?>
                        <button class="btn-start-quiz"><a href="PKG.php">BROWSE PLANS</a></button>
                    <?php endif; ?>
                </section>

                <section class="card-container section">
                    <div class="container">
                        <div class="row g-4">
                            <div class="col-md-4"><div class="card"><h5>Take the Quiz</h5><p>Answer a few simple questions about your lifestyle, preferences, and goals.</p></div></div>
                            <div class="col-md-4"><div class="card"><h5>Get Your Plan</h5><p>Receive a personalized diet plan based on your unique profile and needs.</p></div></div>
                            <div class="col-md-4"><div class="card"><h5>Start Your Journey</h5><p>Begin your path to a healthier lifestyle with our guided approach.</p></div></div>
                        </div>
                    </div>
                </section>

                <section class="testimonial-section section">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="testimonial p-4 rounded shadow-sm">
                                    <p class="mb-4">"I've lost 10 pounds following the diet plan from this quiz! It's been a game-changer for my health journey."</p>
                                    <p class="text-end mb-0"><strong>Renam K., PRO-FITT AI User</strong></p>
                                </div>
                            </div>
                            <div class="col-md-6 text-white">
                                <h2 class="mb-3">Personalized Nutrition at Your Fingertips</h2>
                                <p>Our advanced quiz algorithm takes into account your unique lifestyle, preferences, and health goals to create a tailored diet plan that works for you.</p>
                                <ul>
                                    <li>Customized meal suggestions</li>
                                    <li>Nutritional guidance</li>
                                    <li>Exercise recommendations</li>
                                    <li>Tips for long-term success</li>
                                </ul>
                                <?php if (!isset($_SESSION['user_id'])): ?>
                                    <button class="btn-start-quiz" disabled>Get Your Personalized Plan</button>
                                <?php else: ?>
                                    <button class="btn-start-quiz"><a href="Quiz.html" style="color: white; text-decoration: none;">Get Your Personalized Plan</a></button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-3"><h5>Contact Us</h5><p>Have questions? Reach out to us by calling</p><p class="mb-0"><i class="bi bi-telephone-fill text-warning"></i> <span>+91 8925177899</span></p></div>
                <div class="col-md-3"><h5>Stay Updated</h5><p>Subscribe to our newsletter for the latest updates and news.</p><div class="newsletter"><input type="email" class="form-control mb-2" placeholder="Enter your email"><button class="btn btn-warning w-100">Subscribe</button></div></div>
                <div class="col-md-3"><h5>Quick Links</h5><ul class="list-unstyled"><li><a href="#">Home</a></li><li><a href="#">About Us</a></li><li><a href="#">Terms of Service & Disclaimer</a></li><li><a href="#">Privacy Policy</a></li><li><a href="#">Learn More</a></li></ul></div>
                <div class="col-md-3"><h5>Connect With Us</h5><p><i class="bi bi-envelope-fill text-warning"></i> <a href="mailto:support@pro-fitt.net">support@pro-fitt.net</a></p><p>Business Hours: Mon-Fri, 9AM-6PM IST</p><div class="social-icons"><a href="#"><i class="bi bi-facebook"></i></a><a href="#"><i class="bi bi-twitter"></i></a><a href="#"><i class="bi bi-instagram"></i></a><a href="#"><i class="bi bi-youtube"></i></a></div></div>
            </div>
            <div class="text-center mt-4"><p class="mb-0">&copy; 2025 All rights reserved by PRO-FITT.net</p></div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>