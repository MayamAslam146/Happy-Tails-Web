<?php 
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Happy Tails - Puppy Adoption & Rescue. Find your perfect furry companion and help save lives. From Streets to Smiles!">
    <meta name="keywords" content="puppy adoption, dog rescue, pet adoption, happy tails, rescue dogs">
    <meta name="author" content="Happy Tails">
    
    <!-- Page Title -->
    <title>Happy Tails - From Streets to Smiles 🐾</title>
    
    <!-- External Stylesheet -->
    <link rel="stylesheet" href="assets/css/style.css">
    
    <!-- Favicon (optional) -->
    <link rel="icon" type="image/png" href="assets/images/logo.png">
</head>

<body>
    <!-- Skip to Main Content (Accessibility) -->
    <a href="#main-content" class="skip-to-main">Skip to main content</a>

    <!-- ========================================
         NAVIGATION BAR
         ======================================== -->
    <nav class="navbar">
        <div class="container">
            <!-- Logo -->
            <div class="navbar-logo">
                <img src="assets/images/logo.png" alt="Happy Tails Logo">
                <span>Happy Tails</span>
            </div>
            
            <!-- Navigation Menu -->
            <ul class="navbar-menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="available-puppies.html">Puppies</a></li>
                <li><a href="rescue-stories.html">Rescue Stories</a></li>
                <li><a href="submit-stray.php">Submit Stray</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if (isAdmin()): ?>
                        <li><a href="admin.php" style="color: var(--primary-orange);">Admin Panel</a></li>
                    <?php endif; ?>
                    <li><a href="logout.php" style="color: var(--secondary-lavender);">Logout (<?php echo htmlspecialchars($_SESSION['user_name']); ?>)</a></li>
                <?php else: ?>
                    <li><a href="signin.php" style="color: var(--primary-orange);">Sign In</a></li>
                <?php endif; ?>
            </ul>
            
            <!-- Mobile Menu Toggle Button -->
            <div class="navbar-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- Display Success Message -->
    <?php if (isset($_SESSION['success_message'])): ?>
    <div style="background: linear-gradient(135deg, #4CAF50, #45a049); color: white; padding: 1.5rem; text-align: center; font-weight: 500; box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);">
        <strong style="font-size: 1.1rem;">✅ <?php echo htmlspecialchars($_SESSION['success_message']); ?></strong>
    </div>
    <?php unset($_SESSION['success_message']); endif; ?>

    <!-- ========================================
         MAIN CONTENT
         ======================================== -->
    <main id="main-content">
        
        <!-- ========================================
             HERO SECTION
             ======================================== -->
        <section class="hero">
            <div class="container">
                <h1>🐾 Welcome to Happy Tails<?php if (isset($_SESSION['user_name'])): ?>, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!<?php endif; ?></h1>
                <p class="tagline">From Streets to Smiles - Every Puppy Deserves a Loving Home</p>
                <div class="hero-buttons">
                    <a href="available-puppies.html" class="btn btn-primary">Meet Our Puppies</a>
                    <a href="submit-stray.php" class="btn btn-secondary">Report a Stray</a>
                </div>
            </div>
        </section>

        <!-- ========================================
             ABOUT SECTION
             ======================================== -->
        <section class="about section">
            <div class="container">
                <div class="about-content">
                    <h2>About Happy Tails</h2>
                    <p>
                        At <strong>Happy Tails</strong>, we believe every puppy deserves a second chance at life. 
                        Our mission is to rescue abandoned and stray puppies from the streets, provide them with 
                        medical care, love, and find them forever homes where they can thrive.
                    </p>
                    <p>
                        Since our founding, we've rescued hundreds of puppies and connected them with loving families. 
                        Each adoption story warms our hearts and motivates us to continue this life-changing work.
                    </p>
                    <p>
                        <strong>Join us in making a difference - one paw at a time! 🐶❤️</strong>
                    </p>
                </div>
            </div>
        </section>

        <!-- ========================================
             STATS SECTION
             ======================================== -->
        <section class="stats section">
            <div class="container">
                <h2 class="text-center">Our Impact</h2>
                <div class="stats-grid">
                    <!-- Stat Card 1 -->
                    <div class="stat-card">
                        <h3>250+</h3>
                        <p>Puppies Rescued</p>
                    </div>
                    
                    <!-- Stat Card 2 -->
                    <div class="stat-card">
                        <h3>200+</h3>
                        <p>Happy Families</p>
                    </div>
                    
                    <!-- Stat Card 3 -->
                    <div class="stat-card">
                        <h3>98%</h3>
                        <p>Adoption Success Rate</p>
                    </div>
                    
                    <!-- Stat Card 4 -->
                    <div class="stat-card">
                        <h3>5 Years</h3>
                        <p>Saving Lives</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================
             FEATURED PUPPIES SECTION
             ======================================== -->
        <section class="puppies-section section">
            <div class="container">
                <h2 class="text-center">Meet Some of Our Adorable Puppies</h2>
                <p class="text-center mb-2">These loving companions are waiting for their forever homes!</p>
                
                <div class="puppies-grid">
                    <!-- Puppy Card 1 -->
                    <div class="puppy-card">
                        <img src="images/Images/Happy puppy.jpeg.jpg" alt="Happy golden puppy" class="puppy-card-image">
                        <div class="puppy-card-content">
                            <h3>Max</h3>
                            <div class="puppy-info">
                                <span>🐕 3 months</span>
                                <span>Golden Retriever</span>
                            </div>
                            <p>
                                Max is a playful and energetic pup who loves to run around! 
                                He's great with kids and would be perfect for an active family.
                            </p>
                            <a href="adopt-puppy.php?name=Max&age=3 months&breed=Golden Retriever&image=images/Images/Happy puppy.jpeg.jpg&description=Max is a playful and energetic pup who loves to run around! He's great with kids and would be perfect for an active family." class="btn btn-primary">Adopt Me! ❤️</a>
                        </div>
                    </div>
                    
                    <!-- Puppy Card 2 -->
                    <div class="puppy-card">
                        <img src="images/Images/Bath puppy.jpeg.jpg" alt="Cute puppy in bath" class="puppy-card-image">
                        <div class="puppy-card-content">
                            <h3>Bella</h3>
                            <div class="puppy-info">
                                <span>🐕 2 months</span>
                                <span>Labrador Mix</span>
                            </div>
                            <p>
                                Bella is a sweet and gentle soul who loves cuddles and bath time! 
                                She's calm and would be great for first-time dog owners.
                            </p>
                            <a href="adopt-puppy.php?name=Bella&age=2 months&breed=Labrador Mix&image=images/Images/Bath puppy.jpeg.jpg&description=Bella is a sweet and gentle soul who loves cuddles and bath time! She's calm and would be great for first-time dog owners." class="btn btn-primary">Adopt Me! ❤️</a>
                        </div>
                    </div>
                    
                    <!-- Puppy Card 3 -->
                    <div class="puppy-card">
                        <img src="images/Images/resting puppies.jpeg.jpg" alt="Charlie, Luna, Max & Daisy - Four adorable puppies" class="puppy-card-image">
                        <div class="puppy-card-content">
                            <h3>Charlie, Luna, Max & Daisy</h3>
                            <div class="puppy-info">
                                <span>🐕 3-4 months</span>
                                <span>Bonded Littermates</span>
                            </div>
                            <p>
                                These four inseparable siblings love to cuddle and nap together! They're looking 
                                for a loving home that can keep them together. Adopting all four means quadruple 
                                the love, joy, and adorable puppy moments! 🐶🐶🐶🐶
                            </p>
                            <a href="adopt-puppy.php?name=Charlie, Luna, Max %26 Daisy&age=3-4 months&breed=Bonded Littermates&image=images/Images/resting puppies.jpeg.jpg&description=These four inseparable siblings love to cuddle and nap together! They're looking for a loving home that can keep them together. Adopting all four means quadruple the love, joy, and adorable puppy moments!" class="btn btn-primary">Adopt Us! ❤️</a>
                        </div>
                    </div>
                </div>
                
                <!-- View All Puppies Button -->
                <div class="text-center mt-2">
                    <a href="available-puppies.html" class="btn btn-outline">View All Available Puppies</a>
                </div>
            </div>
        </section>

        <!-- ========================================
             CALL TO ACTION SECTION
             ======================================== -->
        <section class="cta-section">
            <div class="container">
                <h2>Help Us Save More Lives! 🐾</h2>
                <p>Every contribution makes a difference in a puppy's life</p>
                <div class="cta-buttons">
                    <a href="available-puppies.html" class="btn btn-white">Adopt a Puppy</a>
                    <a href="submit-stray.php" class="btn btn-white">Report a Stray</a>
                    <a href="contact.php" class="btn btn-outline">Get Involved</a>
                </div>
            </div>
        </section>

    </main>

    <!-- ========================================
         FOOTER
         ======================================== -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">Happy Tails</div>
                <p class="footer-tagline">From Streets to Smiles 🐾</p>
                
                <!-- Footer Navigation Links -->
                <ul class="footer-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="available-puppies.html">Adopt</a></li>
                    <li><a href="rescue-stories.html">Stories</a></li>
                    <li><a href="submit-stray.php">Report</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
                
                <!-- Social Media Icons (Placeholder) -->
                <div class="footer-social">
                    <a href="#" class="social-icon" aria-label="Facebook">f</a>
                    <a href="#" class="social-icon" aria-label="Instagram">📷</a>
                    <a href="#" class="social-icon" aria-label="Twitter">🐦</a>
                </div>
            </div>
            
            <!-- Copyright -->
            <div class="footer-copyright">
                <p>&copy; 2025 Happy Tails. All Rights Reserved. Made with ❤️ for puppies everywhere.</p>
            </div>
        </div>
    </footer>

    <!-- ========================================
         EXTERNAL JAVASCRIPT
         ======================================== -->
    <script src="assets/js/script.js"></script>
    
</body>
</html>

