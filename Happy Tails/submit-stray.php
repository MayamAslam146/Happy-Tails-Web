<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Report a stray puppy to Happy Tails. Help us rescue and save lives!">
    <title>Submit Stray Puppy - Happy Tails 🐾</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" type="image/png" href="assets/images/logo.png">
</head>

<body>
    <a href="#main-content" class="skip-to-main">Skip to main content</a>

    <nav class="navbar">
        <div class="container">
            <div class="navbar-logo">
                <img src="assets/images/logo.png" alt="Happy Tails Logo">
                <span>Happy Tails</span>
            </div>
            
            <ul class="navbar-menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="available-puppies.html">Puppies</a></li>
                <li><a href="rescue-stories.html">Rescue Stories</a></li>
                <li><a href="submit-stray.php">Submit Stray</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="logout.php" style="color: var(--secondary-lavender);">Logout</a></li>
                <?php else: ?>
                    <li><a href="signin.php" style="color: var(--primary-orange);">Sign In</a></li>
                <?php endif; ?>
            </ul>
            
            <div class="navbar-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <main id="main-content">
        
        <section class="section" style="background: linear-gradient(135deg, var(--light-purple) 0%, var(--bg-cream) 100%); padding: 3rem 0;">
            <div class="container text-center">
                <h1>🐕 Report a Stray Puppy</h1>
                <p style="font-size: 1.125rem; color: var(--text-light); max-width: 800px; margin: 0 auto;">
                    Found a stray puppy? Your quick action can save a life! Report the puppy's location and condition so our rescue team can help immediately.
                </p>
            </div>
        </section>

        <!-- Success/Error Messages -->
        <?php if (isset($_SESSION['success_message'])): ?>
        <div style="background: linear-gradient(135deg, #4CAF50, #45a049); color: white; padding: 1.5rem; text-align: center; font-weight: 500; box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);">
            <strong style="font-size: 1.1rem;">✅ <?php echo htmlspecialchars($_SESSION['success_message']); ?></strong>
        </div>
        <?php unset($_SESSION['success_message']); endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
        <div style="background: linear-gradient(135deg, #ff6b6b, #ff4444); color: white; padding: 1.2rem; text-align: center; box-shadow: 0 4px 15px rgba(255, 68, 68, 0.3);">
            <strong>⚠️ <?php echo htmlspecialchars($_SESSION['error_message']); ?></strong>
        </div>
        <?php unset($_SESSION['error_message']); endif; ?>

        <section class="form-section">
            <div class="container">
                <div class="form-container">
                    <h2 style="text-align: center; margin-bottom: var(--spacing-md); color: var(--primary-orange);">Stray Puppy Report Form</h2>
                    
                    <form id="stray-form" action="process_stray.php" method="post" novalidate>
                        <div class="form-group">
                            <label for="reporter-name">Your Name <span class="required">*</span></label>
                            <input type="text" id="reporter-name" name="reporter-name" placeholder="Enter your name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email Address <span class="required">*</span></label>
                            <input type="email" id="email" name="email" placeholder="your.email@example.com" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="contact-number">Phone Number <span class="required">*</span></label>
                            <input type="tel" id="contact-number" name="contact-number" placeholder="+92 (333) 123-4567" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="location">Location of Puppy <span class="required">*</span></label>
                            <input type="text" id="location" name="location" placeholder="Street address, area, city" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="condition">Puppy Condition <span class="required">*</span></label>
                            <textarea id="condition" name="condition" placeholder="Describe the puppy's condition (health, age estimate, injuries, etc.)" required></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Additional Details</label>
                            <textarea id="message" name="message" placeholder="Any other important information..."></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary form-submit">Submit Report 🐾</button>
                        
                        <p style="text-align: center; margin-top: var(--spacing-sm); color: var(--text-light); font-size: 0.9rem;">
                            <span class="required">*</span> Required fields
                        </p>
                    </form>
                </div>
            </div>
        </section>

    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">Happy Tails</div>
                <p class="footer-tagline">From Streets to Smiles 🐾</p>
                <ul class="footer-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="available-puppies.html">Adopt</a></li>
                    <li><a href="rescue-stories.html">Stories</a></li>
                    <li><a href="submit-stray.php">Report</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
                <div class="footer-social">
                    <a href="#" class="social-icon">f</a>
                    <a href="#" class="social-icon">📷</a>
                    <a href="#" class="social-icon">🐦</a>
                </div>
            </div>
            <div class="footer-copyright">
                <p>&copy; 2025 Happy Tails. All Rights Reserved. Made with ❤️ for puppies everywhere.</p>
            </div>
        </div>
    </footer>

    <script src="assets/js/script.js"></script>
    
</body>
</html>

