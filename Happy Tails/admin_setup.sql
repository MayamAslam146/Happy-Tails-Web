-- ========================================
-- ADMIN PANEL SETUP
-- Run this SQL in phpMyAdmin
-- ========================================

USE happytails;

-- Add role column to users table
ALTER TABLE users ADD COLUMN role ENUM('user', 'admin') DEFAULT 'user' AFTER password;

-- Make test user an admin
UPDATE users SET role = 'admin' WHERE email = 'test@happytails.org';

-- You can also make your account admin
-- UPDATE users SET role = 'admin' WHERE email = 'your-email@example.com';

-- ========================================
-- DONE - Admin setup complete!
-- ========================================

