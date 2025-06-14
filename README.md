# HOLTEC Project Management System

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](LICENSE)
[![PHP Version](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://www.php.net/)

The **HOLTEC Project Management System** is a lightweight, MVC-based PHP application that allows you to manage, display, and interact with projects. Built with a modern, responsive design and powered by PostgreSQL, this project includes features such as:

- **Project Management:** Add new projects with details including name, category, author, location, description, and file uploads.
- **Dynamic Sorting:** Sort projects by ID, Project Name, Category, Author, Location, Description, Creation Date, Rating, Upvotes, and Downvotes.
- **Responsive Design:** A fully responsive user interface with attractive styling.
- **Robust Voting System:** Users can upvote or downvote projects. A weighted rating system ensures that a project with few votes (even 100% upvote) is rated lower than a project with many votes that might have a slightly lower upvote percentage. Users can also change their vote.
- **Dynamic File Handling:** Supports multiple file uploads per project with neat "View File" buttons.
- **Custom Category Field:** If "Other" is selected as the category, a custom input field appears for user-defined categories.
- **User Vote Management:** A single user (tracked via session) can vote on a project and change their vote if desired.

---

## Table of Contents

- [Features](#features)
- [Demo](#demo)
- [Technologies Used](#technologies-used)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Screenshots](#screenshots)
- [Contributing](#contributing)
- [License](#license)
- [Resources](#resources)

---

## Features

- **MVC Architecture:** Clean separation of concerns for easier maintenance and scalability.
- **Project Management:** Add new projects with detailed information and file uploads.
- **Dynamic Sorting:** Sort projects by various columns (e.g., ID, Project Name, Category, etc.).
- **Responsive Design:** Modern, attractive, and fully responsive UI.
- **Weighted Voting System:** Uses a Bayesian-style formula to calculate a weighted rating.  
  _Example:_ A project with one vote (100%) receives a lower rating than a project with 500 votes at 74%.
- **Dynamic File Handling:** Supports multiple file uploads per project and displays them as clickable "View File" buttons.
- **Custom Category Option:** A custom category input appears when "Other" is selected.
- **User Vote Management:** Each user (tracked via session) can vote on a project and change their vote if desired.

---

## Demo

*Coming soon!*  
_If you deploy this project online, add your live demo link here._

---

## Technologies Used

- **PHP 8.2+**
- **PostgreSQL**
- **HTML5, CSS3, and JavaScript**
- **MVC Architecture**
- **Git & GitHub**
- **XAMPP** (or your local development environment)

---

## Installation

1. **Clone the Repository**

   ```bash
   git clone https://github.com/your-username/HOLTEC.git
   cd HOLTEC
2. **Set Up Your Database

Create a PostgreSQL database (e.g., via pgAdmin) and run the following SQL to create the projects table:
