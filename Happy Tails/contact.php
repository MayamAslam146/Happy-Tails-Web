<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Contact Happy Tails for adoption inquiries, volunteering, or general questions.">
    <title>Contact Us - Happy Tails 🐾</title>
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
                <h1>📧 Get In Touch With Us</h1>
                <p style="font-size: 1.125rem; color: var(--text-light); max-width: 800px; margin: 0 auto;">
                    Have questions about adoption, volunteering, or how you can help? 
                    We'd love to hear from you! Fill out the form below and we'll get back to you soon.
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
                    <h2 style="text-align: center; margin-bottom: var(--spacing-md);">Send Us a Message</h2>
                    
                    <form id="contact-form" action="process_contact.php" method="post">
                        <div class="form-group">
                            <label for="name">Your Name <span class="required">*</span></label>
                            <input type="text" id="name" name="name" placeholder="Enter your full name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email Address <span class="required">*</span></label>
                            <input type="email" id="email" name="email" placeholder="your.email@example.com" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Phone Number (Optional)</label>
                            <input type="tel" id="phone" name="phone" placeholder="e.g., +92 (333) 123-4567">
                        </div>
                        
                        <div class="form-group">
                            <label for="subject">Subject <span class="required">*</span></label>
                            <select id="subject" name="subject" required>
                                <option value="">-- Select a Subject --</option>
                                <option value="adoption">Adoption Inquiry</option>
                                <option value="volunteer">Volunteer Opportunities</option>
                                <option value="donation">Donation Information</option>
                                <option value="partnership">Partnership/Collaboration</option>
                                <option value="feedback">Feedback or Suggestions</option>
                                <option value="general">General Question</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Your Message <span class="required">*</span></label>
                            <textarea id="message" name="message" placeholder="Tell us what's on your mind..." required></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary form-submit">Send Message ✉️</button>
                        
                        <p style="text-align: center; margin-top: var(--spacing-sm); color: var(--text-light); font-size: 0.9rem;">
                            <span class="required">*</span> Required fields
                        </p>
                    </form>
                </div>
                
                <div class="contact-info">
                    <h3>Other Ways to Reach Us</h3>
                    <p><strong>📍 Address:</strong><br>123 Puppy Love Lane, Rahim Yar Khan City, Pakistan</p>
                    <p><strong>📞 Phone:</strong><br>+92 (333) 123-4567</p>
                    <p><strong>📧 Email:</strong><br>info@happytails.org</p>
                    <p><strong>🕒 Office Hours:</strong><br>Monday - Friday: 9:00 AM - 6:00 PM<br>Saturday: 10:00 AM - 4:00 PM<br>Sunday: Closed</p>
                    <p style="margin-top: var(--spacing-sm); font-weight: 500;">
                        💡 <strong>For emergencies:</strong> Call our 24/7 hotline at +92 (333) 911-7297
                    </p>
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

    <script>
        // Disable JavaScript validation for contact form - let PHP handle it
        document.getElementById('contact-form').addEventListener('submit', function(e) {
            // Just submit - no preventDefault, no alerts
            return true;
        });
    </script>
    
</body>
</html>

