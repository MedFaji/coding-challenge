# Coding Challenge: Junior Software Engineer - Laravel/vueJs

## Table of Contents
1. [Introduction](#introduction)
2. [Project Context](#project-context)
3. [Features](#features)
4. [Testing](#testing)
5. [Technologies Used](#technologies-used)
6. [Getting Started](#getting-started)

---

## Introduction

This repository is my submission for the Junior Software Engineer coding challenge. The challenge was to create a system for managing products and categories via a Command Line Interface and a web interface.

---

## Project Context

### Product Definition

A product is defined by the following attributes:
- **Name**: A string representing the name of the product.
- **Description**: A string describing the product.
- **Price**: A floating-point number representing the price of the product.
- **Image**: A file that serves as an image for the product.
- **Categories**: A product can belong to 0 or more categories.

### Category Definition

A category is defined by:
- **Name**: A string representing the name of the category.
- **Parent Category**: An optional reference to another category, indicating the parent category.

---

## Features

### CLI

- [x] Create a category from the command line with the commande : php artisan category:create "nameOfCategory"
- [x] Delete a category from the command line with the commande : php artisan category:delete {idOfCategory}
- [x] Create a product from the command line with the commande : php artisan product:create  "nameOfProduct" "descriptionOfProduct" "priceOfProduct"
- [x] Delete a product from the command line with the commande : php artisan product:delete {idOfProduct}

### Web

- [x] Create a product through a web interface.
- [x] Browse products through a paginated product listing with the ability to:
    - [x] Sort products by name or price.
    - [x] Filter products by category.

---

## Testing

- [x] Ensure product creation is covered by automated tests using PHPUnit.

---

## Technologies Used

- Laravel / Vue.js

---

## Getting Started
- [x] Configure your database in DotEnv file first.
- [x] Run the migration to create the tables in the database.
- [x] Make sure you run the command : **npm i**, in order to install all the required dependecies then you can run the project using the command **php artisan serve** and **npm run dev**.

---
