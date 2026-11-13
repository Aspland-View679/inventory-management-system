# inventory-management-system
PHP and SQLite inventory management application

# Inventory Management System

A web-based inventory management application built using PHP, SQLite, HTML, and CSS.

## Overview

This project provides a simple inventory management system for tracking stock, managing quantities, and monitoring product expiry dates.

The application uses PHP for server-side functionality, SQLite for database storage, and CSS for styling.

## Features

- **User Authentication:** Login system using PHP sessions and password verification.
- **Inventory Management:** View stored inventory items in a table.
- **Add Items:** Add new products with names, quantities, expiry dates, and storage locations.
- **Quantity Updates:** Automatically increase the quantity when adding an existing item.
- **Search Functionality:** Search inventory items by name.
- **Delete Items:** Remove items from the inventory.
- **Expiry Notifications:** Display warnings for items approaching their expiry date within seven days.

## Technologies Used

- PHP
- SQLite3
- HTML
- CSS

## Project Structure

```text
inventory-management-system/
├── additem.php
├── inventory.php
├── login.php
├── style.css
├── database.db
└── README.md
```

The SQLite database is required to run the application but is not included in the public repository.

## Getting Started

### Requirements

- PHP with SQLite3 support
- A local PHP development environment
- An SQLite database containing the required tables

### Running the Application

1. Clone the repository.
2. Configure a local SQLite database named `database.db`.
3. Create the required `users` and `ingredients` tables.
4. Start a PHP development server from the project directory:

   ```bash
   php -S localhost:8000
   ```

5. Open `http://localhost:8000/login.php` in your browser.

A valid user account must exist in the database to log in.

## Future Improvements

- Improve form validation and error handling.
- Add inventory editing functionality.
- Introduce role-based access controls.
- Improve responsive design.
- Add automated testing.

## Project Status

Academic portfolio project demonstrating server-side web development, database integration, and inventory management functionality.
