# **Royal Class**

🚀  Code Assessment.

---

## **Table of Contents**

- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Running the Application](#running-the-application)
- [Troubleshooting](#troubleshooting)
- [Contributing](#contributing)
- [License](#license)

---

## **Prerequisites**

Make sure you have the following installed on your system:

| Tool         | Version   | Installation Guide                                             |
|--------------|-----------|----------------------------------------------------------------|
| **PHP**      | 8.2+      | [Install PHP](https://www.php.net/manual/en/install.php)       |
| **Composer** | Latest    | [Install Composer](https://getcomposer.org/)                  |
| **Node.js**  | v16+      | [Install Node.js](https://nodejs.org/)                        |
| **npm**      | Latest    | [Install npm](https://www.npmjs.com/)                         |
| **MySQL**    | Latest    | [Install MySQL](https://dev.mysql.com/downloads/mysql/)       |
| **Laravel**  | Pre-bundled | Comes pre-installed with the project repository.            |

---

## **Installation**

```bash
git clone https://github.com/ahmedmfz/royal_class.git
cd royal_class

```install composer
composer install

```install npm 
npm install

```copy env.example 
cp .env.example .env

```generate app key
php artisan key:generate

```migration
# for global migration and this default in laravel
php artisan migrate

# for special module migration and system can check for depends_on 
php artisan migrate:module {module}

# for all global and modules migration with careful about depends_on
php artisan db:run-chained-migrations

```run server
php artisan serve

#####################
**Api Collection Link **

#Import this "royal_class.postman_collection.json" in postman , then run server , start test by call every endpoint
