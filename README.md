# Sports Warehouse E-Commerce Website

A dynamic full-stack e-commerce website developed for a Sports Warehouse business using HTML, CSS, JavaScript, PHP and MySQL.

The project was initially developed from a Figma design prototype and later extended with backend functionality including product management, category browsing, search functionality, shopping cart, checkout system and staff authentication.

---

##  Project Overview

This project was designed to simulate a real-world online sports warehouse store where customers can browse and purchase sports products.

The website allows users to:
- Browse featured products
- Browse products by category
- Search products
- View detailed product information
- Add products to a shopping cart
- Checkout products
- Staff login and management
- Manage categories and items

The project combines front-end development with backend database integration using PHP and MySQL.

---

##  Technologies Used

### Frontend
- HTML5
- CSS3
- JavaScript
- Responsive Web Design

### Backend
- PHP
- MySQL

### Design & Tools
- Figma
- XAMPP / WAMP
- phpMyAdmin

---

##  UI/UX Design

The website interface was developed by converting a Figma design into a fully functional responsive website.

Key UI features:
- Responsive layout
- Navigation menu
- Product cards
- Search interface
- Shopping cart interface
- Admin management pages

---

##  Features Implemented

###  Home Page
- Display featured products retrieved from MySQL database
- Display:
  - Product image
  - Product name
  - Price
  - Sale price (if applicable)

###  Categories
- Categories dynamically retrieved using SQL queries
- Products grouped by categories
- Each item belongs to one category

###  Product Browsing
- Browse products by selecting categories
- Display:
  - Product name
  - Product image
  - Price
  - Sale price

###  Product Search
- Search products using full or partial product names
- SQL-based search functionality implemented
- Dynamic search result display

###  Product Details Page
- View detailed product information:
  - Product image
  - Product name
  - Description
  - Price
  - Sale price

###  Shopping Cart
- Add products to cart
- Manage selected items
- Store multiple products for checkout

###  Checkout System
Customer checkout form includes:
- First name
- Last name
- Delivery address
- Contact number
- Email address

Payment details:
- Credit card number
- Expiry date
- Name on credit card

###  Authentication System
Staff login system implemented using:
- Username
- Password

###  Password Management
- Staff members can update their passwords securely

###  Admin Management Features

#### Maintain Categories
Staff can:
- Add categories
- Edit categories
- Delete categories

#### Maintain Items
Staff can:
- Add products
- Edit products
- Delete products

---

##  Database Structure

### Categories Table
| Field | Type |
|---|---|
| category_id | Integer |
| category_name | String |

### Products Table
| Field | Type |
|---|---|
| product_id | Integer |
| name | String |
| description | Text |
| price | Float |
| sale_price | Float |
| image | String |
| category_id | Integer |
| featured | Boolean |

### Staff Table
| Field | Type |
|---|---|
| staff_id | Integer |
| username | String |
| password | String |

### Orders Table
| Field | Type |
|---|---|
| order_id | Integer |
| customer_details | Text |
| payment_details | Text |

---

##  Testing

The following functionality was tested:
- Product display
- SQL queries
- Category filtering
- Product search
- Product details page
- Shopping cart functionality
- Checkout form validation
- Staff login authentication
- CRUD operations for products and categories
- Database connectivity

---

##  Learning Outcomes

Through this project, I gained practical experience in:
- Full-stack web development
- Converting Figma designs into responsive websites
- PHP and MySQL integration
- SQL queries and database relationships
- CRUD operations
- User authentication systems
- Shopping cart implementation
- E-commerce website development
- Responsive UI/UX development
- Dynamic content rendering

---

##  Author

Paromita Sarkar
