# Intercity Express

Welcome to the Intercity Express project! This project manages account and booking services for different types of users, including passengers, travel agents, employees, and admins. The project features a robust set of functionalities tailored to each user type, enhancing the overall travel booking experience.

## Table of Contents

- [Technologies Used](#technologies-used)
- [Features](#features)
  - [Passenger](#passenger)
  - [Employee](#employee)
  - [Travel Agent](#travel-agent)
  - [Admin](#admin)
- [Admin Management](#admin-management)
- [Website Structure](#website-structure)
- [Installation](#installation)
- [Usage](#usage)
- [Contact](#contact)

## Technologies Used

- **Frontend:** HTML, CSS, JavaScript
- **Backend:** PHP
- **Database:** PostgreSQL
- **PDF Generation:** Python

## Features

### Passenger

- Register and enjoy services immediately
- Book tickets, view upcoming and past tickets
- Download upcoming tickets as PDFs
- Cancel upcoming tickets
- View and update profile
- Change password
- Submit feedback to the admin

### Employee

- Enjoy all passenger services (except self-registration)
- Get discounts on ticket bookings as set by the admin

### Travel Agent

- Register and await admin approval
- Enjoy all passenger services
- Receive commission on bookings as defined by the admin

### Admin

- Manage passengers: block, unblock, view profiles and booking details
- Manage travel agents: approve registration, block, unblock, view profiles and booking history, set commissions, access net earned commission
- Manage employees: add users, block, unblock, view profiles and booking history, set booking concessions
- Add, update, view, activate, and deactivate stations, routes, and trains
- View blocked and unblocked users separately
- View train charts for specific trains, dates, and coach types
- View user-submitted feedback
- Set advance booking limits for passengers, travel agents, and employees
- Update contact details (reflected on the website's contact page)
- View total earned money for Intercity Express
- Blocked users are restricted from using services until unblocked

## Admin Management

Admins have extensive control over the system, including managing users, routes, stations, trains, and financial aspects. They can also view detailed reports and feedback to improve service quality.

## Website Structure

- **Home Page:** Book tickets by selecting the journey details.
- **Login Page:** Separate login pages for each user type.
- **Schedule Check:** Check the schedule of specific trains between stations.
- **Contact Page:** Contact details for the Intercity Express regarding Queries.
- **About Page:** Contains a description of the Intercity Express.

### Booking Process

1. Visit the home page and select journey details (from, to, date of journey, and class of coach).
2. View available trains and seats.
3. Proceed to the common login page and specify the user type.
4. Enter traveler's details and verify them.
5. Complete payment information.
6. Ticket is generated and the user is redirected to their specific dashboard.

## Installation

To run this project locally (IN UBUNTU), follow these steps:

1. Install Python libraries like Flask, reportlab for the Generation of Ticket as PDF:
   ```bash
   pip install Flask reportlab

2. Install Postgresql ('Congfigure it by yourself'):
   ```bash
   sudo apt install postgresql

3. Install apache2 for hosting the Project:
   ```bash
   sudo apt install apache2

4. Install PHP along with all other utilities:
   ```bash
   sudo apt install php libapache2-mod-php
   sudo apt install php-cli
   sudo apt install php-cgi
   sudo apt install php-pgsql
   sudo apt-get install php-curl
   sudo apt install net-tools

5. Restart the Apache2
   ```bash
   sudo systemctl restart apache2.service 

6. Start Your Postgresql and create all tables:
   ```bash
   \i psql.sql

7. Clone the repository in the Apache2 Directory:
   ```bash
   cd /var/www/html/
   git clone https://github.com/vickspanda/intercityexpress.git

8. Edit the connect.php and connectcheck.php and Edit the Credentials as per your PostgresQL for connecting the project with PostgresQL.

## Usage

Once the server is running, open your web browser and navigate to http://localhost/intercityexpress. From here, you can register as a passenger, travel agent, or login as an admin or employee. Follow the on-screen instructions to explore the features.


## Contact

For any questions or feedback, please contact me at vickspanda1@gmail.com.


Thank you for using Intercity Express! We hope you have a smooth and enjoyable travel booking experience.


Feel free to customize any sections further based on your project's specific details and requirements. This README.md should provide a comprehensive overview of your project, making it easier for users and contributors to understand and use.
