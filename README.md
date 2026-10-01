# Library Management System – Laravel REST API + Postman

A complete backend API project designed for demonstrating REST API development and testing with Postman. It manages books, categories, library members and borrowing/returning of books.

## Features
- Laravel 12 REST API
- MySQL database
- Laravel Sanctum token authentication
- Category CRUD
- Book CRUD and search
- Member CRUD
- Borrow and return workflow
- Validation and meaningful HTTP status codes
- Database transactions for borrowing/returning
- Seeded demo records
- Postman collection with positive and negative tests
- Automated Postman assertions for status codes, JSON fields, response time and business rules

## Requirements
- PHP 8.2+
- Composer
- MySQL 8+ / XAMPP
- Postman

## Installation
1. Extract the ZIP.
2. Open the project folder in VS Code.
3. Run `composer install`.
4. Copy `.env.example` to `.env`.
5. Create a MySQL database named `library_management`.
6. Set DB username/password in `.env`.
7. Run `php artisan key:generate`.
8. Run `php artisan migrate --seed`.
9. Start the server with `php artisan serve`.
10. Base URL: `http://127.0.0.1:8000/api`

## Demo account
Email: `admin@library.test`
Password: `password`

## Postman
Import both files from `postman/`:
- `Library-Management-System.postman_collection.json`
- `Library-Management-System.postman_environment.json`

Select the environment and run **Authentication > Login** first. The login test automatically saves the token to `{{token}}`.

Recommended sequence:
1. Health Check
2. Authentication / Login
3. Categories / Create Category
4. Books / Create Book
5. Members / Create Member
6. Loans / Borrow Book
7. Loans / Return Book
8. Negative Tests

## Main endpoints
### Authentication
POST `/api/auth/register`
POST `/api/auth/login`
GET `/api/auth/user`
POST `/api/auth/logout`

### Categories
GET `/api/categories`
POST `/api/categories`
GET `/api/categories/{id}`
PUT `/api/categories/{id}`
DELETE `/api/categories/{id}`

### Books
GET `/api/books`
POST `/api/books`
GET `/api/books/{id}`
PUT `/api/books/{id}`
DELETE `/api/books/{id}`
GET `/api/books/search?q=laravel`

### Members
GET `/api/members`
POST `/api/members`
GET `/api/members/{id}`
PUT `/api/members/{id}`
DELETE `/api/members/{id}`

### Loans
GET `/api/loans`
POST `/api/loans`
GET `/api/loans/{id}`
PUT `/api/loans/{id}`
DELETE `/api/loans/{id}`
POST `/api/loans/{id}/return`

## Postman testing demonstrated
The collection contains tests for:
- HTTP 200, 201, 401, 404, 409 and 422 responses
- JSON response structure
- Authentication token extraction
- Response time
- Required validation fields
- Duplicate ISBN/category/member email
- Invalid IDs
- Unauthorized requests
- Book availability
- Duplicate active loans
- Return-book business logic

## Report-ready testing areas
This project can be used in a QA/API testing demonstration to explain functional testing, positive testing, negative testing, boundary/validation testing, authentication/authorization testing, CRUD testing, integration testing and database/business-rule verification.
