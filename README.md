# Invoice Management System

## Overview

Invoice Management System is a web application built with **Laravel 13**, **Inertia.js**, **Vue 3**, and **Tailwind CSS**. The application enables businesses to manage clients, products, invoices, reports, and user accounts from a modern, responsive interface.

The project follows Laravel best practices, including Resource Controllers, Form Requests, Eloquent ORM, Soft Deletes, and authentication with Laravel Fortify.

---

# Features

## Authentication

* User registration
* Secure login/logout
* Password reset
* Email verification
* User profile management
* Role-ready architecture

---


# Instalation
Requirements:
php
copmposer

Clone repo
On Linux install php-sqlite 
Change in  php.ini ;extension=pdo_sqlite to extension=pdo_sqlite

composer install
copy .env.example .env
php artisan key:generate
php artisan migrate
php artisen db:seed
npm install
npm run build
composer run dev

login email addres:
admin@local.com
password:
aaaaaaaa
