# BriBooks Mini Book Writing Platform API

## Overview

This project is a simplified backend implementation of the BriBooks Book Writing and Publishing Platform built using Laravel 13.

The system allows authors to create books, manage chapters and pages, upload manuscripts, create book versions, submit books for review, and publish approved books through a role-based workflow.

---

## Tech Stack

* PHP 8.3+
* Laravel 13
* MySQL 8+
* JWT Authentication (tymon/jwt-auth)
* PhpOffice/PhpWord
* PHPUnit

---

## Features

### Authentication

* User Registration
* User Login
* User Profile
* User Logout
* JWT Token Authentication

### Role-Based Access Control

Supported Roles:

* Author
* Reviewer
* Admin

### Book Management

* Create Book
* List Books
* View Book Details
* Update Book
* Delete Book

### Book Version Control

* Create Version Snapshots
* View Version History
* View Specific Version

Version snapshots store:

* Book Metadata
* Chapters
* Pages

### Chapter Management

* Create Chapter
* Update Chapter
* Delete Chapter
* List Chapters

### Page Management

* Create Page
* Update Page
* Delete Page
* List Pages

### Review & Publishing Workflow

Workflow:

Draft → Submitted → Under Review → Approved → Published

Actions:

* Submit Book
* Approve Book
* Reject Book
* Publish Book

### Moderation System

When a book is submitted:

* Restricted Words Detection
* Moderation Logging
* Automatic transition to Under Review when moderation passes

### Document Upload & Conversion

Supported Formats:

* .doc
* .docx

Features:

* Upload manuscript
* Extract document content
* Create chapter automatically
* Convert content into HTML pages

### Dashboard

Provides:

* Total Books
* Draft Books
* Published Books
* Pending Reviews

### Events & Listeners

Implemented Events:

* BookCreated
* BookVersionCreated
* BookSubmitted
* ModerationPassed
* BookApproved
* BookPublished

Implemented Listeners:

* AnalyticsListener
* ModerationListener
* NotificationListener
* BookApprovedListener
* BookPublishedListener

---

## Project Architecture

The project follows a layered architecture:

* Controllers
* Services
* Models
* Policies
* Events
* Listeners
* Form Validation
* Enums

Example:

Controller → Service → Model

This approach improves maintainability, testability, and separation of concerns.

---

## Installation

Clone repository:

```bash
git clone <repository-url>
cd bribooks-api
```

Install dependencies:

```bash
composer install
```

Copy environment file:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Generate JWT secret:

```bash
php artisan jwt:secret
```

Configure database credentials in `.env`.

Run migrations:

```bash
php artisan migrate
```

Start development server:

```bash
php artisan serve
```

---

## Running Tests

Run all tests:

```bash
php artisan test
```

Run a specific test:

```bash
php artisan test --filter=AuthTest
```

---

## API Endpoints

### Authentication

| Method | Endpoint      |
| ------ | ------------- |
| POST   | /api/register |
| POST   | /api/login    |
| GET    | /api/profile  |
| POST   | /api/logout   |

### Books

| Method | Endpoint        |
| ------ | --------------- |
| POST   | /api/books      |
| GET    | /api/books      |
| GET    | /api/books/{id} |
| PUT    | /api/books/{id} |
| DELETE | /api/books/{id} |

### Chapters

| Method | Endpoint                 |
| ------ | ------------------------ |
| POST   | /api/books/{id}/chapters |
| GET    | /api/books/{id}/chapters |
| PUT    | /api/chapters/{id}       |
| DELETE | /api/chapters/{id}       |

### Pages

| Method | Endpoint                 |
| ------ | ------------------------ |
| POST   | /api/chapters/{id}/pages |
| GET    | /api/chapters/{id}/pages |
| PUT    | /api/pages/{id}          |
| DELETE | /api/pages/{id}          |

### Versions

| Method | Endpoint                             |
| ------ | ------------------------------------ |
| POST   | /api/books/{id}/versions             |
| GET    | /api/books/{id}/versions             |
| GET    | /api/books/{id}/versions/{versionId} |

### Workflow

| Method | Endpoint                |
| ------ | ----------------------- |
| POST   | /api/books/{id}/submit  |
| POST   | /api/books/{id}/approve |
| POST   | /api/books/{id}/reject  |
| POST   | /api/books/{id}/publish |

### Upload

| Method | Endpoint               |
| ------ | ---------------------- |
| POST   | /api/books/{id}/upload |

### Dashboard

| Method | Endpoint       |
| ------ | -------------- |
| GET    | /api/dashboard |

---

## Assumptions & Trade-offs

* Document conversion is implemented using PhpWord.
* Uploaded documents are converted into HTML page content using text chunking.
* Moderation is implemented using restricted word matching.
* A single imported chapter is created for uploaded manuscripts.
* Focus was placed on clean architecture and maintainable code rather than production-level optimization.

---

## Future Improvements

* Queue-based document processing
* Redis caching
* Email notifications
* OpenAI-generated summaries
* Advanced profanity detection
* Full-text search
* Background moderation jobs
