# Dating/Chat Application - Laravel Project

## Overview

This project implements a dating/chat application with the following key features:
- **Database schema design**: Includes tables for users, conversations, and messages.
- **RESTful API**: Built using PHP and Laravel for handling account creation, login, profile retrieval, message sending/receiving, and conversation management.
- **Query optimization**: Implements efficient queries for retrieving data such as profiles with the most conversations.
- **Caching**: Uses Redis to improve the performance of frequently accessed API endpoints.

## Technologies Used

- **Backend**: Laravel 11
- **Database**: MySQL for relational data storage
- **Caching**: Redis for caching frequently accessed data
- **Authentication**: Laravel Sanctum for secure API token-based authentication
- **PHP**: PHP 8.2
- **Testing**: PHPUnit for unit and feature tests

## Sections

### 1. **Database Design and Implementation**

- **Users Table**: Stores user data such as name, email, and password.
- **Conversations Table**: Stores conversation metadata between users.
- **Messages Table**: Stores messages within a conversation, including sender, receiver, and message content.
- **ConversationParticipant Table**: Stores the association between users and the conversations they are part of.
- **Indexes & Constraints**: Optimized for performance with appropriate indexes and constraints to ensure data integrity.

### 2. **API Development**

- **Account Creation + Login Endpoint**: Handles user registration and authentication.
- **Profile Retrieval/Search Endpoint**: Allows for searching users by profile information.
- **Message Sending/Receiving Endpoint**: Supports sending and retrieving messages, as well as fetching conversations.

### 3. **Setup and Installation**
- Clone the repository:
    ```
    git clone https://github.com/jannytechservice/dating-app.git
    cd dating-app
    ```
- Install dependencies:
    ```
    composer install
    ```
- Set up the `.env` file:
    ```
    cp .env.development .env
    ```
- Generate application key:
    ```
    php artisan key:generate
    ```
- Configure database settings in .env:
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```
- Migrate the database:
    ```
    php artisan migrate
    ```
- Run the Laravel development server:
    ```
    php artisan serve
    ```
### 4. **Testing**
To run the tests, execute:
```
composer test
```
### 5. **API Endpoints**

Below are the available API endpoints for interacting with the dating/chat application.

1. `/user`**
- **Method**: `GET`
- **Description**: Retrieves the authenticated user's details.
- **Authentication**: true

2. `/register`**
- **Method**: `POST`
- **Description**: Registers a new user by submitting necessary details like name, email, and password.
- **Authentication**: false

3. `/login`**
- **Method**: `POST`
- **Description**: Logs in a user and returns an authentication token to use in subsequent requests.
- **Authentication**: false

4. `/profile/search`**
- **Method**: `GET`
- **Description**: Searches for user profiles based on query parameters. This allows filtering of profiles based on criteria like name, age, or location.
- **Authentication**: true

5. `/profile/{id}`**
- **Method**: `GET`
- **Description**: Retrieves a specific user’s profile by ID.
- **Authentication**: true

6. `/profiles/popular/{count}`**
- **Method**: `GET`
- **Description**: Retrieves the most popular profiles based on the number of conversations.
- **Authentication**: true

7. `/conversations`**
- **Method**: `GET`
- **Description**: Retrieves all conversations for the authenticated user.
- **Authentication**: true

8. `/conversations`**
- **Method**: `POST`
- **Description**: Creates a new conversation.
- **Authentication**: true

9. `/conversations/{conversationId}/participants`**
- **Method**: `GET`
- **Description**: Retrieves the participants of a specific conversation.
- **Authentication**: true

10. `/messages/{conversationId}`**
- **Method**: `GET`
- **Description**: Retrieves all messages for a specific conversation.
- **Authentication**: true

11. `/messages`**
- **Method**: `POST`
- **Description**: Sends a new message in a conversation.
- **Authentication**: true

12. `/conversations/{conversationId}/participants`**
- **Method**: `POST`
- **Description**: Adds a participant to a specific conversation.
- **Authentication**: true

13. `/conversations/{conversationId}/participants`**
- **Method**: `DELETE`
- **Description**: Removes a participant from a specific conversation.
- **Authentication**: true

### 6. **Docker Environment Setup**
```
docker-compose up -d
```