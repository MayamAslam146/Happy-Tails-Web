<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Adopt a puppy from Happy Tails.">
    <title>Adopt a Puppy - Happy Tails 🐾</title>
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
                <h1>🐾 Adopt Your New Best Friend</h1>
                <p style="font-size: 1.125rem; color: var(--text-light); max-width: 800px; margin: 0 auto;">
                    Fill out the form below to start your adoption journey with Happy Tails. 
                    We're so excited to help you find your perfect companion!
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

        <section class="adoption-form-section section">
            <div class="container">
                <div class="adoption-layout">
                    <div class="adoption-form-container">
                        <h2 style="text-align: center; margin-bottom: var(--spacing-md); color: var(--primary-orange);">
                            Adoption Application Form
                        </h2>
                        
                        <form id="adoption-form" action="process_adopt.php" method="post" novalidate>
                            <!-- Hidden field for puppy name from URL -->
                            <input type="hidden" id="puppy-name" name="puppy-name" value="<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : 'Not specified'; ?>">
                            
                            <div class="form-group">
                                <label for="full-name">Full Name <span class="required">*</span></label>
                                <input type="text" id="full-name" name="full-name" placeholder="Enter your full name" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email Address <span class="required">*</span></label>
                                <input type="email" id="email" name="email" placeholder="your.email@example.com" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="phone">Phone Number <span class="required">*</span></label>
                                <input type="tel" id="phone" name="phone" placeholder="+92 (333) 123-4567" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="address">City / Address <span class="required">*</span></label>
                                <input type="text" id="address" name="address" placeholder="Your city and address" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="living-situation">Living Situation <span class="required">*</span></label>
                                <select id="living-situation" name="living-situation" required>
                                    <option value="">-- Select --</option>
                                    <option value="house">House with Yard</option>
                                    <option value="apartment">Apartment</option>
                                    <option value="condo">Condo/Townhouse</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="experience">Experience with Dogs</label>
                                <select id="experience" name="experience">
                                    <option value="">-- Select --</option>
                                    <option value="first-time">First time dog owner</option>
                                    <option value="some">Some experience</option>
                                    <option value="very-experienced">Very experienced</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="reason">Why do you want to adopt this puppy? <span class="required">*</span></label>
                                <textarea id="reason" name="reason" placeholder="Tell us about your motivation to adopt..." required></textarea>
                            </div>
                            
                            <div class="form-group checkbox-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" id="agreement" name="agreement" required>
                                    <span>I agree to provide love, care, and a safe home to my adopted puppy ❤️ <span class="required">*</span></span>
                                </label>
                            </div>
                            
                            <button type="submit" class="btn btn-primary form-submit">Submit Adoption Request 🐾</button>
                            
                            <p style="text-align: center; margin-top: var(--spacing-sm); color: var(--text-light); font-size: 0.9rem;">
                                <span class="required">*</span> Required fields
                            </p>
                        </form>
                    </div>
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

