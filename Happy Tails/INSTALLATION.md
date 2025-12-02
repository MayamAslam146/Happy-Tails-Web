# 🐾 Happy Tails - Backend Installation Guide

## Prerequisites
- XAMPP installed (with Apache & MySQL)
- Web browser
- Text editor (optional)

---

## 📋 Step-by-Step Installation

### 1️⃣ **Copy Files to XAMPP**

Copy the entire `Happy Tails` folder to your XAMPP `htdocs` directory:

```
C:\xampp\htdocs\Happy-Tails-Web\Happy Tails\
```

Or on Mac:
```
/Applications/XAMPP/htdocs/Happy-Tails-Web/Happy Tails/
```

---

### 2️⃣ **Start XAMPP Services**

1. Open XAMPP Control Panel
2. Start **Apache**
3. Start **MySQL**

Both should show green "Running" status.

---

### 3️⃣ **Create Database**

#### Option A: Using phpMyAdmin (Recommended)

1. Open your browser and go to: `http://localhost/phpmyadmin`
2. Click on **"Import"** tab
3. Click **"Choose File"** button
4. Select `happytails.sql` from your Happy Tails folder
5. Click **"Go"** button at the bottom

✅ Database `happytails` will be created with all tables!

#### Option B: Manual SQL Execution

1. Go to: `http://localhost/phpmyadmin`
2. Click **"SQL"** tab
3. Open `happytails.sql` in a text editor
4. Copy all content and paste into the SQL query box
5. Click **"Go"**

---

### 4️⃣ **Verify Installation**

Open your browser and navigate to:
```
http://localhost/Happy-Tails-Web/Happy Tails/index.php
```

You should see the Happy Tails homepage!

---

## 🔐 Test Login Credentials

A test account has been created for you:

**Email:** `test@happytails.org`  
**Password:** `password123`

You can also create a new account using the Sign Up page.

---

## 📁 Project Structure

```
Happy Tails/
├── config.php                  # Database configuration
├── index.php                   # Homepage with session management
├── signin.html                 # Sign in page
├── signup.html                 # Sign up page
├── logout.php                  # Logout handler
├── process_login.php           # Login processor
├── process_signup.php          # Sign up processor
├── process_contact.php         # Contact form processor
├── process_adopt.php           # Adoption form processor
├── process_stray.php           # Stray report processor
├── process_puppy_inquiry.php   # Puppy inquiry processor
├── happytails.sql             # Database schema
├── sitemap.xml                # SEO sitemap
├── assets/
│   ├── css/style.css          # All styles
│   ├── js/script.js           # JavaScript
│   └── images/                # Images
├── contact.html
├── adopt-puppy.html
├── available-puppies.html
├── rescue-stories.html
└── submit-stray.html
```

---

## 🗄️ Database Tables

The database includes these tables:

1. **users** - User accounts
2. **contact_messages** - Contact form submissions
3. **stray_reports** - Stray puppy reports
4. **adoption_requests** - Adoption applications
5. **puppy_inquiries** - Puppy inquiry submissions

---

## ✅ Features Implemented

### Authentication System
- ✅ User registration with password hashing
- ✅ Secure login with password verification
- ✅ Session management
- ✅ Remember me functionality
- ✅ Logout functionality
- ✅ Dynamic navbar (shows Logout when logged in)
- ✅ Personalized welcome message

### Form Processing
- ✅ Contact form with database storage
- ✅ Stray puppy reports
- ✅ Adoption requests
- ✅ Puppy inquiries
- ✅ Server-side validation
- ✅ SQL injection protection (prepared statements)
- ✅ XSS protection (sanitization)

### Security Features
- ✅ Password hashing with bcrypt
- ✅ Prepared statements for all queries
- ✅ Input sanitization
- ✅ Session security
- ✅ CSRF protection ready
- ✅ Error handling

---

## 🎨 Design

All forms maintain the existing theme colors:
- **Primary Orange:** `#F49B42`
- **Secondary Lavender:** `#CBA4E5`
- **Light Purple:** `#E8D5F2`
- **Cream Background:** `#FFF9F3`
- **Brown Text:** `#5A3E2B`

No layout changes were made - all styling matches `style.css`.

---

## 🧪 Testing Checklist

### Sign Up
- [ ] Go to `signup.html`
- [ ] Fill form and submit
- [ ] Check if redirected to `index.php`
- [ ] Verify welcome message appears

### Sign In
- [ ] Go to `signin.html`
- [ ] Use test credentials or your new account
- [ ] Check if redirected to `index.php`
- [ ] Verify "Logout" appears in navbar

### Contact Form
- [ ] Go to `contact.html`
- [ ] Fill and submit form
- [ ] Check `contact_messages` table in phpMyAdmin

### Adoption Form
- [ ] Go to `adopt-puppy.html`
- [ ] Fill and submit form
- [ ] Check `adoption_requests` table

### Stray Report
- [ ] Go to `submit-stray.html`
- [ ] Fill and submit form
- [ ] Check `stray_reports` table

---

## 🔧 Configuration

### Database Settings
Edit `config.php` if needed:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'happytails');
```

---

## 🐛 Troubleshooting

### "Database connection failed"
- ✅ Make sure MySQL is running in XAMPP
- ✅ Check if database `happytails` exists
- ✅ Verify credentials in `config.php`

### "Page not found"
- ✅ Check if files are in correct XAMPP htdocs folder
- ✅ Use correct URL with folder name
- ✅ Verify Apache is running

### Forms not submitting
- ✅ Check browser console for JavaScript errors
- ✅ Verify form action points to correct PHP file
- ✅ Check Apache error logs

### Session not working
- ✅ Verify `session.save_path` is writable
- ✅ Check PHP session configuration
- ✅ Clear browser cookies

---

## 📧 Admin Access

To view submitted data, use phpMyAdmin:
```
http://localhost/phpmyadmin
```

Select `happytails` database and browse tables.

---

## 🚀 Next Steps

Future enhancements you can add:
- Admin dashboard to view all submissions
- Email notifications
- File upload for stray reports
- Advanced search and filtering
- User profile management
- Password reset functionality
- Email verification

---

## 📝 Support

If you encounter any issues:
1. Check Apache and MySQL are running
2. Verify database is imported correctly
3. Check browser console for errors
4. Review Apache error logs
5. Ensure all file permissions are correct

---

## 🎉 You're All Set!

Your Happy Tails website with complete backend functionality is ready!

**Happy Coding! 🐾**

