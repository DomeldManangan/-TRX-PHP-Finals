<a name="readme-top">

<br/>

<br />
<div align="center">
  <a href="https://github.com/DomeldManangan">
  <!-- TODO: If you want to add logo or banner you can add it here -->
    <img src="./assets/img/LibraX_Logo_Black-removebg.png" alt="LibraX" width="auto" height="auto">
  </a>
<!-- TODO: Change Title to the name of the title of your Project -->
  <h3 align="center">Library Management System</h3>
</div>
<!-- TODO: Make a short description -->
<div align="center">
  Files for final project in PHP, We are Team RocketX (TRX) consists of Domeld Manangan,John Arvin Tumbagahon, Mike Acosta, Sean Mojica. Book borrowing system using PHP, MySQL, and HTML/CSS. This system allows users to borrow and return books. The system also tracks the status of the books and the users who borrowed them. The system is designed to be user-friendly and easy to use. A complete PHP-based library management system with user authentication, book borrowing, and fine calculation.
</div>

<br />

<!-- TODO: Change the zyx-0314 into your github username  -->
<!-- TODO: Change the WD-Template-Project into the same name of your folder -->
![](https://visit-counter.vercel.app/counter.png?page=-TRX-PHP-Finals)

---

<br />
<br />

---
## Link to the website


### Technology
<!-- TODO: List of Technology Used -->
![HTML](https://img.shields.io/badge/HTML-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS](https://img.shields.io/badge/CSS-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=white)

## Features

- **User Authentication**: Admin (Librarian) and Student accounts
- **Book Management**: Add, edit, archive books (no deletion allowed)
- **Custom Book IDs**: Generated based on title, date, and genre
- **Borrowing System**: Max 2 books per student, 7-day loan period
- **Fine Calculation**: ₱10.00 per day for overdue books
- **Book Status**: Available, Borrowed, Archived
- **Minimum 50 Books**: System enforces minimum book count


## Database Setup

### 1. Create Database Tables

Run these SQL commands in your database:

```sql
-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'student') NOT NULL
);

-- Books table (if not exists)
CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    book_id VARCHAR(30) UNIQUE,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    published_year INT NOT NULL,
    genre VARCHAR(100),
    status ENUM('Available', 'Borrowed', 'Archived') DEFAULT 'Available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Borrowed books table
CREATE TABLE borrowed_books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    borrow_date DATE NOT NULL,
    due_date DATE NOT NULL,
    return_date DATE,
    fine DECIMAL(10,2) DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (book_id) REFERENCES books(id)
);
```

### 2. Create Admin User

After setting up the database, run the `create_admin.php` script once:
- Visit: `http://your-domain.com/create_admin.php`
- Default credentials: `admin` / `admin123`
- **Delete** `create_admin.php` after use for security

## File Structure

```
Library/
├── config/
│   └── db.php              # Database connection
├── includes/
│   ├── header.php          # Common header with navigation
│   └── footer.php          # Common footer
├── public/
│   ├── index.php           # Main page (book list)
│   ├── login.php           # User login
│   ├── logout.php          # User logout
│   ├── register.php        # Student registration
│   ├── add.php             # Add new book (admin only)
│   ├── edit.php            # Edit book (admin only)
│   ├── borrow.php          # Borrow book (student only)
│   ├── return.php          # Return book (student only)
│   ├── mybooks.php         # Student's borrowed books
│   ├── manage_users.php    # Manage users (admin only)
│   └── assets/
│       └── style.css       # Styling
├── create_admin.php        # Create admin user (delete after use)
└── README.md               # This file
```

## Deployment Instructions

### For Free Hosting (000webhost)

1. **Sign up** at https://000webhost.com
2. **Create a new website**
3. **Upload files**:
   - Upload the entire `Library` folder to your hosting
   - Make sure the file structure is preserved
4. **Create MySQL database**:
   - Go to your hosting control panel
   - Create a new MySQL database
   - Note down: hostname, database name, username, password
5. **Update database connection**:
   - Edit `config/db.php`
   - Update the database credentials
6. **Run SQL commands**:
   - Go to phpMyAdmin in your hosting control panel
   - Run the SQL commands above
7. **Create admin user**:
   - Visit: `http://your-domain.com/create_admin.php`
   - Delete the file after use
8. **Test the system**:
   - Login as admin
   - Add books (minimum 50)
   - Register as student
   - Test borrowing/returning

### For Paid Hosting

1. **Purchase hosting** (HostGator, Bluehost, etc.)
2. **Upload files** via FTP or file manager
3. **Create database** in hosting control panel
4. **Update database credentials** in `config/db.php`
5. **Run SQL commands** in phpMyAdmin
6. **Create admin user** and delete `create_admin.php`
7. **Test all functionality**

## Security Notes

- **Change default admin password** after first login
- **Delete** `create_admin.php` after creating admin user
- **Enable HTTPS** if available
- **Regular backups** of your database
- **Update file permissions** (644 for files, 755 for directories)

## Default Accounts

- **Admin**: `admin` / `admin123`
- **Students**: Register through the registration page

## Support

For issues or questions:
1. Check database connection in `config/db.php`
2. Verify all SQL tables are created
3. Ensure file permissions are correct
4. Check error logs in your hosting control panel

## License

This project is open source and available under the MIT License. 
