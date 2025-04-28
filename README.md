# Task Management System

A complete PHP-based Task Management System with REST API following MVC architecture, designed for intermediate PHP developer positions.

## Features 

### Core Functionality
- ✅ Create, read, update, and delete tasks
- ✅ Task prioritization (Low/Medium/High)
- ✅ Due date tracking with future-date validation
- ✅ Status management (Pending/Completed)
- ✅ Created/updated timestamps

### Technical Features
- 🚀 RESTful API endpoints
- 📊 Paginated task listing (10 items per page)
- 🔍 Basic frontend interface with AJAX capabilities
- 🔒 Secure database operations using prepared statements
- 📱 Responsive design with Bootstrap 5
- 📁 Proper MVC architecture separation

## System Requirements

- Web Server: Apache/Nginx with mod_rewrite enabled
- PHP: 7.4 or higher
- MySQL: 5.7 or higher
- Extensions: PDO, MySQLi, JSON
- Browser: Chrome/Firefox/Edge (latest versions)

## Installation

### 1. Clone the Repository
```bash
git clone https://github.com/yourusername/task-manager.git
cd task-manager


2. Install Dependencies
No external dependencies required (pure PHP solution)

3. Set Up Environment
bash
cp .env.example .env
Configuration
Edit the .env file with your database credentials:

**ENV**
DB_HOST=localhost
DB_USERNAME=your_db_username
DB_PASSWORD=your_db_password
DB_NAME=task_manager


Database Setup
1. Create Database
sql
CREATE DATABASE task_manager;


2. Import Schema
Execute this SQL in your MySQL client:

sql
CREATE TABLE `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `priority` enum('Low','Medium','High') NOT NULL DEFAULT 'Medium',
  `due_date` date NOT NULL,
  `status` enum('Pending','Completed') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


File Structure
task-manager/
├── .env.example       → Environment variables template
├── .gitignore        → Specifies untracked files
├── README.md         → This documentation file
├── api/
│   └── index.php     → API endpoint router
├── assets/
│   ├── css/
│   │   └── style.css → Custom styles
│   └── js/
│       └── script.js → Frontend JavaScript
├── config/
│   └── database.php  → Database connection setup
├── controllers/
│   ├── ApiController.php → Handles API requests
│   └── TaskController.php → Manages task logic
├── models/
│   └── Task.php      → Task data operations
├── views/
│   ├── tasks/
│   │   ├── create.php → Task creation form
│   │   ├── edit.php   → Task editing form
│   │   └── index.php  → Task listing view
│   └── layout.php    → Main HTML template
├── .htaccess         → URL rewriting rules
└── index.php         → Main application entry


API Documentation
Base URL
http://yourdomain.com/api/tasks

###Endpoints
1. List All Tasks (Paginated)
GET /api/tasks
Parameters:

page (optional) - Page number (default: 1)

Example Response:

json
{
  "data": [
    {
      "id": 1,
      "title": "Complete assignment",
      "description": "Finish the PHP task manager",
      "priority": "High",
      "due_date": "2023-12-31",
      "status": "Pending",
      "created_at": "2023-06-15 10:00:00",
      "updated_at": "2023-06-15 10:00:00"
    }
  ],
  "meta": {
    "page": 1,
    "per_page": 10,
    "total": 15
  }
}


##2. Get Single Task
GET /api/tasks/{id}
##3. Create Task
POST /api/tasks
Required Fields:

title (string)

due_date (date in YYYY-MM-DD format)

Optional Fields:

description (string)

priority (enum: Low/Medium/High)

##4. Update Task
PUT /api/tasks/{id}
Updatable Fields:

All fields except id, created_at

##5. Delete Task
DELETE /api/tasks/{id}
Frontend Usage
Task Listing
Displays all tasks in a paginated table

Color-coded priority badges

Status indicators

Action buttons for edit/delete

Creating a Task
Click "Create New Task" button

Fill in the form:

Title (required)

Description (optional)

Priority (dropdown)

Due date (date picker)

Submit the form

Editing a Task
Click "Edit" button on any task

Modify the fields

Update status if completed

Click "Update Task"

Development
Coding Standards
Follows PSR-12 coding style

Proper PHPDoc comments

Separation of concerns (MVC)

Security Considerations
Uses prepared statements to prevent SQL injection

Input validation on all endpoints

Environment variables for sensitive data

Potential Improvements
Add user authentication

Implement task categories/tags

Add file attachments

Enable task sharing/collaboration

Testing
Manual Testing
Test all CRUD operations via frontend

Verify API endpoints with Postman/cURL

Check validation rules:

Empty title should fail

Past due dates should fail

Example API Tests
bash
# Create task
curl -X POST http://localhost/api/tasks \
  -H "Content-Type: application/json" \
  -d '{"title":"Test Task","due_date":"2023-12-31"}'

# List tasks
curl -X GET http://localhost/api/tasks

# Update task
curl -X PUT http://localhost/api/tasks/1 \
  -H "Content-Type: application/json" \
  -d '{"status":"Completed"}'
Deployment
For Production
Set proper file permissions:

bash
chmod 644 .env
chmod 755 assets/ uploads/
Configure web server:

Apache: Enable mod_rewrite

Nginx: Set up proper rewrite rules

Disable error display in production:

ini
display_errors = Off
log_errors = On
Hosting Options
Shared hosting with PHP/MySQL support

VPS with LAMP stack

Platform-as-a-Service (Heroku, Render, etc.)

Contributing
Fork the repository

Create your feature branch (git checkout -b feature/AmazingFeature)

Commit your changes (git commit -m 'Add some AmazingFeature')

Push to the branch (git push origin feature/AmazingFeature)

Open a Pull Request

Permission is hereby granted...


This README includes:
1. Comprehensive feature list
2. Detailed installation instructions
3. Complete API documentation
4. File structure explanation
5. Development guidelines
6. Testing procedures
7. Deployment instructions
8. Contribution guidelines
9. License information
