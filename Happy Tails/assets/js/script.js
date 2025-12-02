/* ========================================
   HAPPY TAILS - PUPPY ADOPTION WEBSITE
   Main JavaScript File
   ======================================== */

// ========================================
// WAIT FOR DOM TO LOAD
// ========================================

document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize all functions when page loads
    initNavbar();
    initScrollToTop();
    initFormValidation();
    initAdoptButtons();
    initMobileMenu();
    
    console.log('Happy Tails website loaded successfully! 🐾');
});

// ========================================
// NAVBAR SCROLL EFFECT
// ========================================

function initNavbar() {
    const navbar = document.querySelector('.navbar');
    
    // Add 'scrolled' class to navbar when user scrolls down
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
    
    // Highlight active navigation link based on current page
    const currentPage = window.location.pathname.split('/').pop() || 'index.html';
    const navLinks = document.querySelectorAll('.navbar-menu a');
    
    navLinks.forEach(link => {
        const linkPage = link.getAttribute('href');
        if (linkPage === currentPage) {
            link.classList.add('active');
        }
    });
}

// ========================================
// MOBILE MENU TOGGLE
// ========================================

function initMobileMenu() {
    const navbarToggle = document.querySelector('.navbar-toggle');
    const navbarMenu = document.querySelector('.navbar-menu');
    
    // Only add event listener if toggle button exists (mobile view)
    if (navbarToggle) {
        navbarToggle.addEventListener('click', function() {
            navbarMenu.classList.toggle('active');
            
            // Animate hamburger icon
            this.classList.toggle('active');
        });
        
        // Close menu when clicking on a link
        const navLinks = document.querySelectorAll('.navbar-menu a');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                navbarMenu.classList.remove('active');
                navbarToggle.classList.remove('active');
            });
        });
    }
}

// ========================================
// SCROLL TO TOP BUTTON
// ========================================

function initScrollToTop() {
    // Create scroll to top button if it doesn't exist
    let scrollBtn = document.querySelector('.scroll-top');
    
    if (!scrollBtn) {
        scrollBtn = document.createElement('button');
        scrollBtn.className = 'scroll-top';
        scrollBtn.innerHTML = '↑';
        scrollBtn.setAttribute('aria-label', 'Scroll to top');
        document.body.appendChild(scrollBtn);
    }
    
    // Show/hide button based on scroll position
    window.addEventListener('scroll', function() {
        if (window.scrollY > 300) {
            scrollBtn.classList.add('visible');
        } else {
            scrollBtn.classList.remove('visible');
        }
    });
    
    // Smooth scroll to top when clicked
    scrollBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

// ========================================
// FORM VALIDATION
// ========================================

function initFormValidation() {
    // Get all forms on the page
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const formId = form.id || '';
            
            // For signin/signup forms, do basic validation but let PHP handle everything
            if (formId.includes('signin') || formId.includes('sign-in') || 
                formId.includes('signup') || formId.includes('sign-up')) {
                
                // Only check if fields are filled
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;
                
                requiredFields.forEach(field => {
                    field.style.borderColor = '';
                    if (!field.value.trim()) {
                        isValid = false;
                        field.style.borderColor = '#ff4444';
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    alert('⚠️ Please fill in all required fields.');
                    return;
                }
                
                // Password matching for signup
                if (formId.includes('signup') || formId.includes('sign-up')) {
                    const password = form.querySelector('input[name="password"]');
                    const confirmPassword = form.querySelector('input[name="confirm-password"]');
                    
                    if (password && confirmPassword && password.value !== confirmPassword.value) {
                        e.preventDefault();
                        password.style.borderColor = '#ff4444';
                        confirmPassword.style.borderColor = '#ff4444';
                        alert('⚠️ Passwords do not match.');
                        return;
                    }
                }
                
                // Let form submit naturally to PHP - no preventDefault, no alert
                return;
            }
            
            // For all other forms, prevent default and validate
            e.preventDefault();
            
            // Get all required fields in this form
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            let emptyFields = [];
            
            // Check each required field
            requiredFields.forEach(field => {
                // Remove any previous error styling
                field.style.borderColor = '';
                
                // Check if field is empty
                if (!field.value.trim()) {
                    isValid = false;
                    emptyFields.push(field.previousElementSibling.textContent);
                    // Add error styling
                    field.style.borderColor = '#ff4444';
                }
            });
            
            // Validate email format if email field exists
            const emailField = form.querySelector('input[type="email"]');
            if (emailField && emailField.value.trim()) {
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(emailField.value)) {
                    isValid = false;
                    emailField.style.borderColor = '#ff4444';
                    alert('⚠️ Please enter a valid email address.');
                    return;
                }
            }
            
            // If validation fails, show error message
            if (!isValid) {
                alert('⚠️ Please fill in all required fields:\n\n' + emptyFields.join('\n'));
                return;
            }
            
            // If validation passes, show success message
            showSuccessMessage(form);
        });
    });
}

// ========================================
// SHOW SUCCESS MESSAGE AFTER FORM SUBMISSION
// ========================================

function showSuccessMessage(form) {
    // Determine which form was submitted
    const formId = form.id || 'form';
    let message = '';
    let redirectToHome = false;
    
    if (formId.includes('signin') || formId.includes('sign-in')) {
        // Don't show alert for signin - PHP will handle redirect with message
        redirectToHome = true;
    } else if (formId.includes('signup') || formId.includes('sign-up')) {
        // Don't show alert for signup - PHP will handle redirect with message
        redirectToHome = true;
    } else if (formId.includes('contact') || form.action.includes('contact')) {
        message = '✅ Thank you for contacting us!\n\nWe\'ll get back to you within 24 hours. 🐾';
    } else if (formId.includes('stray') || form.action.includes('stray')) {
        message = '✅ Thank you for reporting!\n\nOur rescue team will investigate this case immediately. Every report helps save a life! 🐶❤️';
    } else if (formId.includes('adopt') || form.action.includes('adopt')) {
        message = '✅ Adoption request submitted!\n\nWe\'re so excited! Our team will contact you soon to discuss the next steps. 🐾';
    } else {
        message = '✅ Form submitted successfully!\n\nThank you for your interest in Happy Tails! 🐾';
    }
    
    // Only show alert for non-auth forms
    if (message && !redirectToHome) {
        alert(message);
    }
    
    // For auth forms, form will submit to PHP naturally
    if (redirectToHome) {
        return; // Let PHP handle the redirect
    }
    
    // Reset the form after successful submission
    form.reset();
    
    // Reset any error styling
    const fields = form.querySelectorAll('input, textarea, select');
    fields.forEach(field => {
        field.style.borderColor = '';
    });
}

// ========================================
// "ADOPT ME" BUTTON INTERACTION
// ========================================

function initAdoptButtons() {
    // Get all "Adopt Me" buttons
    const adoptButtons = document.querySelectorAll('.btn-adopt, .adopt-btn');
    
    adoptButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            // If button is inside a link, prevent default
            if (this.tagName === 'A') {
                e.preventDefault();
            }
            
            // Get puppy name from the card (if available)
            const card = this.closest('.puppy-card');
            let puppyName = 'this adorable puppy';
            
            if (card) {
                const nameElement = card.querySelector('h3');
                if (nameElement) {
                    puppyName = nameElement.textContent;
                }
            }
            
            // Show confirmation dialog
            const confirmed = confirm(
                `🐾 Are you interested in adopting ${puppyName}?\n\n` +
                `Click OK to proceed with the adoption process.\n` +
                `Our team will contact you with more information!`
            );
            
            if (confirmed) {
                alert(
                    `❤️ Wonderful!\n\n` +
                    `Thank you for choosing to adopt ${puppyName}!\n\n` +
                    `Our adoption coordinator will reach out to you shortly.\n\n` +
                    `In the meantime, you can prepare:\n` +
                    `• A safe space for your new friend\n` +
                    `• Food and water bowls\n` +
                    `• Toys and treats\n` +
                    `• Lots of love! 🐶❤️`
                );
            }
        });
    });
}

// ========================================
// FADE-IN ANIMATION ON SCROLL (Optional)
// ========================================

function initScrollAnimations() {
    // Get all elements that should animate
    const animatedElements = document.querySelectorAll('.puppy-card, .story-card, .stat-card');
    
    // Intersection Observer for scroll animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });
    
    // Observe each element
    animatedElements.forEach(element => {
        observer.observe(element);
    });
}

// Initialize scroll animations if elements exist
if (document.querySelector('.puppy-card, .story-card, .stat-card')) {
    initScrollAnimations();
}

// ========================================
// IMAGE SLIDER/CAROUSEL (Optional - for Hero Section)
// ========================================

function initHeroSlider() {
    const sliderImages = document.querySelectorAll('.hero-slider img');
    
    if (sliderImages.length > 1) {
        let currentSlide = 0;
        
        // Auto-advance slides every 5 seconds
        setInterval(() => {
            sliderImages[currentSlide].classList.remove('active');
            currentSlide = (currentSlide + 1) % sliderImages.length;
            sliderImages[currentSlide].classList.add('active');
        }, 5000);
    }
}

// ========================================
// SMOOTH SCROLL FOR ANCHOR LINKS
// ========================================

// Add smooth scrolling to all anchor links with hash
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        
        // Only apply if href is not just "#"
        if (href !== '#' && href.length > 1) {
            e.preventDefault();
            const target = document.querySelector(href);
            
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }
    });
});

// ========================================
// BUTTON HOVER SOUND EFFECT (Optional)
// ========================================

// Uncomment the following function if you want to add sound effects
/*
function addButtonSounds() {
    const buttons = document.querySelectorAll('.btn');
    const hoverSound = new Audio('assets/sounds/hover.mp3');
    const clickSound = new Audio('assets/sounds/click.mp3');
    
    buttons.forEach(button => {
        button.addEventListener('mouseenter', () => {
            hoverSound.currentTime = 0;
            hoverSound.play();
        });
        
        button.addEventListener('click', () => {
            clickSound.currentTime = 0;
            clickSound.play();
        });
    });
}
*/

// ========================================
// UTILITY FUNCTIONS
// ========================================

// Check if element is in viewport
function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

// Format date to readable string
function formatDate(date) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(date).toLocaleDateString('en-US', options);
}

// ========================================
// ADOPTION FORM VALIDATION & SUBMISSION
// ========================================

function initAdoptionForm() {
    // Get the adoption form (if it exists on the page)
    const adoptionForm = document.getElementById('adoption-form');
    
    // Only add event listener if the form exists on this page
    if (adoptionForm) {
        adoptionForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission
            
            // Get all form fields
            const fullName = document.getElementById('full-name');
            const email = document.getElementById('email');
            const phone = document.getElementById('phone');
            const address = document.getElementById('address');
            const livingSituation = document.getElementById('living-situation');
            const reason = document.getElementById('reason');
            const agreement = document.getElementById('agreement');
            
            // Validation flags
            let isValid = true;
            let errorMessages = [];
            
            // Reset any previous error styling
            const allInputs = adoptionForm.querySelectorAll('input, select, textarea');
            allInputs.forEach(input => {
                input.style.borderColor = '';
            });
            
            // Validate Full Name
            if (!fullName.value.trim()) {
                isValid = false;
                errorMessages.push('Full Name');
                fullName.style.borderColor = '#ff4444';
            }
            
            // Validate Email
            if (!email.value.trim()) {
                isValid = false;
                errorMessages.push('Email Address');
                email.style.borderColor = '#ff4444';
            } else {
                // Check email format
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(email.value)) {
                    isValid = false;
                    alert('⚠️ Please enter a valid email address.');
                    email.style.borderColor = '#ff4444';
                    return;
                }
            }
            
            // Validate Phone
            if (!phone.value.trim()) {
                isValid = false;
                errorMessages.push('Phone Number');
                phone.style.borderColor = '#ff4444';
            }
            
            // Validate Address
            if (!address.value.trim()) {
                isValid = false;
                errorMessages.push('City / Address');
                address.style.borderColor = '#ff4444';
            }
            
            // Validate Living Situation
            if (!livingSituation.value) {
                isValid = false;
                errorMessages.push('Living Situation');
                livingSituation.style.borderColor = '#ff4444';
            }
            
            // Validate Reason for Adoption
            if (!reason.value.trim()) {
                isValid = false;
                errorMessages.push('Reason for Adoption');
                reason.style.borderColor = '#ff4444';
            } else if (reason.value.trim().length < 20) {
                isValid = false;
                alert('⚠️ Please provide a more detailed reason for adoption (at least 20 characters).');
                reason.style.borderColor = '#ff4444';
                return;
            }
            
            // Validate Agreement Checkbox
            if (!agreement.checked) {
                isValid = false;
                alert('⚠️ You must agree to provide love and care to your adopted puppy.');
                return;
            }
            
            // If validation fails, show error message
            if (!isValid) {
                alert('⚠️ Please fill in all required fields:\n\n' + errorMessages.join('\n'));
                return;
            }
            
            // If validation passes, show success message
            showAdoptionSuccessMessage(fullName.value);
            
            // Reset the form
            adoptionForm.reset();
        });
    }
}

// ========================================
// SHOW ADOPTION SUCCESS MESSAGE
// ========================================

function showAdoptionSuccessMessage(applicantName) {
    const firstName = applicantName.split(' ')[0]; // Get first name only
    
    const successMessage = `
🎉 Congratulations, ${firstName}!

Your adoption request has been submitted successfully! 🐶❤️

Our adoption team will review your application and contact you within 24-48 hours.

Thank you for choosing to give a rescued puppy a loving home!

What happens next:
✅ Application review (1-2 days)
📞 Phone interview with our team
🏠 Home visit (if applicable)
🐾 Meet your new best friend!

We're so excited for you! 🎊

- The Happy Tails Team 🐾
    `;
    
    alert(successMessage);
    
    // Scroll to top of page
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

// Initialize adoption form when page loads
if (document.getElementById('adoption-form')) {
    initAdoptionForm();
    loadPuppyDataFromURL();
}

// ========================================
// LOAD PUPPY DATA FROM URL PARAMETERS
// ========================================

function loadPuppyDataFromURL() {
    // Get URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    
    // Check if puppy data exists in URL
    if (urlParams.has('name')) {
        const puppyName = urlParams.get('name');
        const puppyAge = urlParams.get('age');
        const puppyBreed = urlParams.get('breed');
        const puppyImage = urlParams.get('image');
        const puppyDescription = urlParams.get('description');
        
        // Update the puppy preview card
        updatePuppyPreview(puppyName, puppyAge, puppyBreed, puppyImage, puppyDescription);
    }
}

// ========================================
// UPDATE PUPPY PREVIEW CARD
// ========================================

function updatePuppyPreview(name, age, breed, image, description) {
    // Find the puppy preview elements
    const puppyCard = document.querySelector('.adoption-puppy-preview .puppy-card');
    
    if (puppyCard) {
        // Update puppy image
        const puppyImg = puppyCard.querySelector('.puppy-card-image');
        if (puppyImg && image) {
            puppyImg.src = image;
            puppyImg.alt = `${name} - Puppy for adoption`;
        }
        
        // Update puppy name
        const puppyNameEl = puppyCard.querySelector('h3');
        if (puppyNameEl && name) {
            puppyNameEl.textContent = name;
        }
        
        // Update puppy age and breed
        const puppyInfo = puppyCard.querySelectorAll('.puppy-info span');
        if (puppyInfo.length >= 2) {
            if (age) puppyInfo[0].textContent = `🐕 ${age}`;
            if (breed) puppyInfo[1].textContent = breed;
        }
        
        // Update puppy description
        const puppyDesc = puppyCard.querySelector('p');
        if (puppyDesc && description) {
            puppyDesc.textContent = description;
        }
        
        // Update the "You're Adopting:" heading if it exists
        const adoptingHeading = document.getElementById('adopting-heading');
        if (adoptingHeading && name) {
            adoptingHeading.innerHTML = `You're Adopting: <span style="color: var(--text-brown); font-weight: 700;">${name}</span>`;
        }
    }
}

// ========================================
// CONSOLE EASTER EGG (Fun!)
// ========================================

console.log(
    '%c🐾 Happy Tails 🐾',
    'font-size: 24px; font-weight: bold; color: #F49B42; text-shadow: 2px 2px 4px rgba(0,0,0,0.2);'
);
console.log(
    '%cFrom Streets to Smiles! 🐶❤️',
    'font-size: 16px; color: #CBA4E5;'
);
console.log(
    '%cThank you for visiting our website and supporting puppy rescue!',
    'font-size: 12px; color: #5A3E2B;'
);

// ========================================
// END OF JAVASCRIPT
// ========================================

