# Promoter API

The **Promoter API** is a robust Laravel-based backend application designed to simplify the management and deployment of promoters for event management companies. It provides complete CRUD functionality for promoters, their skills, and promoter groups while also offering additional routes for specialized features.

This API is ideal for organizing promoters based on shared skills, streamlining deployment, and dynamically updating profiles when new skills are acquired. With Swagger-generated OpenAPI specifications, it ensures clean documentation and ease of integration.

---

## Key Features
- **API-Only Backend:** Built exclusively for backend operations.
- **Clean and Maintainable Code:** Developed with best practices for readability and maintainability.
- **CRUD Functionality:** Full create, read, update, and delete capabilities for:
   - `Promoter`: Represents an individual working as a promoter.
   - `Skill`: Defines specific skills a promoter can possess.
   - `PromoterGroup`: Groups promoters with similar skills.
- **Event Management:** Enables event companies to allocate promoters to suitable groups based on their skills.
- **Dynamic Skill Updates:** Automatically updates promoter profiles when new skills are acquired via learning platforms.
- **Swagger API Documentation:** Integrated with OpenAPI specifications for seamless integration and usability.
- **Semantic Commit Convention:** Ensures a clear and consistent commit history.

---

## Getting Started

### Pre-requisites
- [PHP 8.3 from Laravel Herd](https://herd.laravel.com/)

### Installation

1. **Clone the repository:**
   ```bash
   git clone git@github.com:escapist-berlin/promoter-api.git
   ```
2. **Navigate to the project directory:**
   ```bash
   cd promoter-api
   ```
3. **Isolate the PHP version:**
   ```bash
   herd isolate php@8.3
   ```
4. **Secure the application:**
   ```bash
   herd secure
   ```
5. **Install dependencies:**
   ```bash
   herd composer install
   ```
6. **Set up the SQLite database:**
   ```bash
   touch database/database.sqlite
   ```
7. **Configure environment variables:**
   ```bash
   cp .env.example .env
   ```
   Update the `.env` file with the absolute path to the SQLite database:
   ```bash
   DB_DATABASE=/full/path/to/database/database.sqlite
   ```
8. **Generate the application key:**
   ```bash
   herd php artisan key:generate
   ```
9. **Run database migrations:**
   ```bash
   herd php artisan migrate
   ```
10. **Seed the database:**
    ```bash
    herd php artisan db:seed
    ```
11. **Generate API documentation:**
    ```bash
    herd php artisan l5-swagger:generate
    ```
12. **Access the API documentation:**
    Open your browser and visit:
    ```
    https://promoter-api.test/api/documentation/
    ```
13. **Start using the application!**

---

## Usage Scenario
The Promoter API is designed to support event management companies by:
- Grouping promoters based on shared skills to match them with specific tasks.
- Dynamically managing and updating promoter profiles as they acquire new skills.
- Simplifying deployment planning with well-organized promoter groups.

---

## Development Notes
This project was implemented as a personal learning initiative. It follows modern development practices and is documented to ensure smooth collaboration and scalability.

### Helpful Tools
- [TablePlus](https://tableplus.com/) for SQLite debugging.

---

