# MyTimes Project Documentation

## Overview

The **MyTimes Project** is a comprehensive learning management system designed to provide both users and administrators with a seamless experience for managing and accessing educational content. The project incorporates user registration, login, profile management, and dashboard functionalities, alongside administrative controls for managing users, news, notices, and courses. The system is built with a focus on simplicity, security, and responsiveness, utilizing modern web technologies such as PHP, MySQL, and Tailwind CSS.

---

## Features

### User Features

1. **User Registration**
    
    - Users can register by providing their full name, email, phone number, and password.
        
    - Passwords are securely hashed using PHP's `password_hash` function.
        
2. **User Login**
    
    - Registered users can log in using their email and password.
        
    - Authentication is handled securely with password verification.
        
3. **User Dashboard**
    
    - Users can view the latest news, important notices, and available courses.
        
    - The dashboard provides a centralized location for accessing all relevant information.
        
4. **User Profile**
    
    - Users can update their profile information, including their first name, last name, email address, and phone number.
        
    - Profile pictures can be uploaded and managed using an image upload function.
        
5. **Logout**
    
    - Users can securely log out of their accounts.
        

---

### Admin Features

6. **Admin Dashboard**
    
    - Admins can view the total count of users, news articles, notices, and courses.
        
    - Provides an overview of the system's current state.
        
7. **Manage Users**
    
    - Admins can view all registered users and their details.
        
8. **Manage News**
    
    - Admins can add, view, and manage news articles.
        
    - News articles are displayed on the user dashboard.
        
9. **Manage Notices**
    
    - Admins can add, view, and manage notices.
        
    - Notices are displayed on the user dashboard.
        
10. **Manage Courses**
    
    - Admins can add, view, and manage courses.
        
    - Courses are displayed on the user dashboard.
        

---

### CRUD Operations

#### Users

- **Create**: Users can register via the `register.php` file.
    
- **Read**: Admins can view all users via the `manage-users.php` file.
    
- **Update**: Users can update their profile via the `profile.php` file.
    
- **Delete**: Users can delete their account via the `profile.php` file.
    

#### News

- **Create**: Admins can add news via the `manage-news.php` file.
    
- **Read**: Users can view the latest news on their dashboard via the `dashboard.php` file.
    

#### Notices

- **Create**: Admins can add notices via the `manage-notices.php` file.
    
- **Read**: Users can view the latest notices on their dashboard via the `dashboard.php` file.
    

#### Courses

- **Create**: Admins can add courses via the `manage-courses.php` file.
    
- **Read**: Users can view all courses on their dashboard via the `dashboard.php` file.
    

---

### Special Functions

11. **Password Hashing**
    
    - Passwords are securely hashed using PHP's `password_hash` function.
        
    - Implemented in the `register.php` and `login.php` files.
        
12. **Image Handling and Uploads**
    
    - Profile pictures are handled and uploaded using the `uploadImage` function in the `functions.php` file.
        
    - The function checks file type, size, and moves the uploaded file to the target directory.
        
13. **CSS and Tailwind**
    
    - The project uses **Tailwind CSS** for styling, ensuring a responsive and modern design.
        
    - Tailwind is included via a CDN link in the `<head>` section of each HTML file.
        

---

## Starting Guide

### 1. Create the Database

- Open **phpMyAdmin** and create a new database named `mytimes`.
    
- Import the SQL file `create_db.sql` to create the necessary tables.
    

### 2. Configure XAMPP

- Ensure **XAMPP** is installed and running.
    
- Place the project folder in the `htdocs` directory of your XAMPP installation.
    

### 3. Run the Project Locally

- Open your web browser and navigate to `http://localhost/myTimes`.
    
- You will be redirected to the login page. You can register a new user or log in with the default admin credentials:
    
    - **Email**: `admin@admin.com`
        
    - **Password**: `password`
        

### 4. Admin Access

- After logging in as an admin, you can access the admin dashboard and manage users, news, notices, and courses.
    

### 5. User Access

- After logging in as a user, you can access the user dashboard, view the latest news, notices, and courses, and update your profile.
    

---

## File Structure

The project follows a structured file organization for easy navigation and maintenance:


```
myTimes/
├── assets/            # Contains CSS, JS, and images
├── includes/          # PHP files for database connections and functions
├── pages/             # Contains user and admin pages (e.g., dashboard.php, profile.php)
├── register.php       # User registration page
├── login.php          # User login page
├── functions.php      # Contains helper functions (e.g., image upload)
├── create_db.sql      # SQL file for database setup
```
---

## Conclusion

The **MyTimes Project** is a robust learning management system that combines user-friendly features with powerful administrative controls. It supports CRUD operations, secure password handling, and responsive design using Tailwind CSS. By following the starting guide, you can easily set up and run the project locally using XAMPP. This project serves as a comprehensive solution for managing educational content and user data effectively.