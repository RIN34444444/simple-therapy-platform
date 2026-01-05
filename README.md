# simple-therapy-platform
Project Overview

The Online Therapy Platform is a web application that allows individuals to book and attend therapy sessions online. The platform connects users with therapists and includes role-based access for administrators and therapists.

User Roles & Features

Users (Clients)

-Register and log in

-View therapist profiles

-Book therapy sessions with therapists

-View their booked sessions and upcoming appointments

-(Planning to add) Edit personal profile information


Therapists

-(Planned feature) Dashboard to view clients who have booked sessions

-View upcoming and past sessions

-Manage session availability

Admin's features

-Add new therapists

-Edit therapist profiles

-Delete therapists

-Manage user accounts

PROJECT STRUCTURE
Online Therapy/
├── images/                 (folder for images used in the project)
├── vendor/                
├── .env                    
├── .gitignore
├── therapist.php
├── admin.php
├── book-session.php
├── composer.json
├── composer.lock
├── dashboard.php
├── db_connection.php
├── delete_therapists.php
├── detailed_reports.php
├── edit_therapists.php
├── find_therapists.php
├── index.php
├── login.php
├── logout.php
├── profile.php
├── questionnaire.php
├── register.php
├── script.js
├── style.css
└── README.md

DATABASE
Database used: MySQL, managed locally using XAMPP

The database credentials are stored securely using environment variables (.env)

Main tables include:

-Users

-Therapists

-Sessions

Environment Variables

Sensitive information like database credentials is stored in a .env file and not committed to GitHub.

Getting Started (Local Setup)

What You need:

XAMPP (Apache & MySQL)

-PHP 8+

-Composer

Steps

-Clone the repository

-Place the project inside the htdocs folder

-Create a .env file with your database credentials

-Import the database into phpMyAdmin

-Start Apache and MySQL in XAMPP

-Open the project in your browser

Planned Improvements

-User profile edit functionality

-Therapist dashboard to manage clients and sessions

-Improved UI/UX

-Session status tracking (upcoming, completed, cancelled)

License

This project is for demonstration purposes.
