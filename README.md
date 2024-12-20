#  Hackathon DCW2024 - Projet Symfony

Welcome to **Hackathon-DCW2024**, an application developed with the Symfony framework. This document provides an overview of the project, installation instructions, and usage information.

## Prerequisites

Before you start, make sure your system meets the following requirements:

- PHP 8.1 or higher
- Composer
- Symfony CLI (optional but recommended)
- A database server (MySQL, PostgreSQL, etc.)
- Node.js and npm or yarn (if using Webpack Encore)

## Installation

### **1. **Clone the repository:**

   ```bash
   git clone https://github.com/TomCoulais/Hackathon-DCW2024.git
   cd project-name
   ```
### **2. Install PHP dependencies**:
  ```bash
  composer install
  ```
### **3. Configure environment variables:**
- Duplicate the .env file and rename it to .env.local.
- Update the values to match your setup (database, email, etc.):
  ```php
  DATABASE_URL="mysql://user:password@127.0.0.1:3306/database_name"
  ```
### **4. Create the database:**
  ```bash
  symfony console make:migration
  php bin/console d:m:m
  ```

### **5. For start server**
  ```bash
  symfony server:start -d
  symfony console tailwind:build --watch 
  ```
