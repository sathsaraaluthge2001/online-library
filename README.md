# online-library

# Overview

This project is an online library system with a frontend and backend implementation. Users can register, log in, and view available books. They can add books to their sessions and return them as needed. The system ensures that users cannot access certain pages without logging in.

# Start the Laravel development server: php artisan serve
# Start the Vue.js development server: npm run dev

# Usage

    User Registration and Login
        Users can register and log in to access the application.
        Pages cannot be accessed without logging in.

# Pages

    Home Page (Books Page)
        Displays available books using a table.
        Supports search by title, description, type, and using a "like" query.

    User Profile Page
        Displays the user's borrowed books.
        Navigation bar includes an icon that, when clicked, directs to the user profile.

    Login Page
        Allows users to log in.

    Register Page
        Allows users to register.

# Book Management

    Users can add books to their sessions.
    Users can return books whenever they want.
    Books can be added using Postman: http://127.0.0.1:8000/api/book
                                     {
                                        "title": "Book Title 4",
                                        "description": "Description for Book Title 4",
                                        "type": "Science",
                                        "price": 29.99
                                     }

# Database Tables

    olusers
        Stores user information.

    books
        Stores book information.

    borrowing
        Tracks which books have been borrowed by which users.

# Known Issues

    The search bar dropdown does not display the selected value after clicking, but the functionality works correctly. For example, if a user inputs a title, selects "title" from the dropdown, and clicks the search button, the correct results are displayed.

# Notes

    Passwords must be at least 8 characters long and include at least one special character.
    There is no admin panel; books can be added using Postman.