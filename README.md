# Projet Symfony - Hackathon

## Overview
This project is a Symfony application configured with Tailwind CSS. It provides a ready-to-use setup for rapid development, perfect for hackathons. Follow the instructions below to initialize and launch the application.

## Prerequisites

Before starting, ensure your system has the following installed:

- **PHP** >= 8.1  
- **Composer** >= 2.0  
- **Symfony CLI** 
- **Docker** (optional, for PostgreSQL or MySQL containers)  
- **Node.jsµµ and npm/yarn (to manage front-end assets).

---
## Installation Steps

### 1. Clone the Repository
Clone this repository to your local machine:
   ```bash
   git clone https://github.com/votre-utilisateur/votre-repo.git
   cd votre-repo
```
### 2. Install PHP Dependencies
Install the necessary PHP dependencies using Composer:
```bash
composer install
```
### 3. Configure Environment Variables
Create a .env.local file (or update the existing .env file) with your database information:
```php
DATABASE_URL="postgresql://user:password@127.0.0.1:5432/nom_de_la_base"
```

### 4. Initialize the Database
Create the database and run migrations:
```bash
symfony console doctrine:database:create
symfony console doctrine:migrations:migrate
```
### 5. Start the Application
**Start the Symfony Server**

Run the Symfony server in the background:
```bash
symfony server:start -d
```
**Compile Tailwind CSS**
```bash
symfony console tailwind:build --watch
```
