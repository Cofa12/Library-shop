# Library-shop API

This is the backend API for the Library-shop application, built with Laravel. It provides endpoints for managing libraries, books, and user authentication.

## Current Features

### 🔐 Authentication System
- **JWT Authentication**: Secure API endpoints using JSON Web Tokens (JWT via PHPOpenSourceSaver).
- **Endpoints**: User Registration, Login, Logout, Profile Retrieval (`/me`), and Token Refresh.
- Protected routes using `auth:api` middleware.

### 🏢 Library Management
- **Full CRUD API**: Endpoints to list, create, view, update, and delete libraries.
- **Repository Pattern**: Implements `LibraryRepositoryInterface` for clean data access and abstraction.
- **Data Transfer Objects (DTOs)**: Ensures structured data flow between requests and repositories.
- **API Resources**: Consistent JSON serialization using `LibraryResource` and `LibrariesResource`.

### 📚 Book Management
- **Full CRUD API**: Endpoints to list, create, view, and delete books.
- **API Resources**: Standardized JSON responses using `BookResource`.

### 🛠 Architecture & Technical Highlights
- **Hybrid Database System**: Integration with both MySQL and MongoDB to leverage the strengths of relational and NoSQL databases.
- **Clean Architecture**: Separation of concerns using Controllers, Form Requests, Services, Repositories, and Resources.

---

## 🚀 Coming Features
*(Insert upcoming features below)*

- [ ] 
- [ ] 
- [ ] 
