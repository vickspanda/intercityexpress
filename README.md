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


!!! --- YOU CAN HAVE LOOK IN THE SCREENSHOTS FOLDER FOR THE PREVIEW OF THE PROJECT --- !!!  

## Installation

To run this project locally (IN UBUNTU), follow these steps:

1. Install Python libraries Flask and reportlab for the Generation of Ticket as PDF (Assumption is taken that python3 is already installed, if not, install it):
   ```bash
   sudo apt install python3-flask python3-reportlab

2. Install Postgresql ('congfigure it by yourself') and Apache2:
   ```bash
   sudo apt install postgresql apache2

3. Install PHP along with all other Utilities:
   ```bash
   sudo apt install php libapache2-mod-php php-cli php-cgi php-pgsql php-curl net-tools

4. Restart the Apache2
   ```bash
   sudo systemctl restart apache2.service 

5. Clone the repository in the Apache2 Directory via Normal Terminal:
   ```bash
   cd /var/www/html/
   sudo git clone https://github.com/vickspanda/intercityexpress.git
   
6. Start your Postgresql and create all tables:
   ```bash
   \i /var/www/html/intercityexpress/psql.sql
   
7. Also for keeping the Feature to Download Ticket as PDF Live, you need to keep generatePDF.py in running state:
   ```bash
   cd intercityexpress/process/
   sudo python3 generatePDF.py
   ```

8. Edit the process/connect.php and process/connect_check.php and update the credentials as per your PostgresQL user and password in which you have created the database of name "intercityexpress" by running installation step no. 5, for connecting the website with PostgresQL Database.
   ```bash
   // connect.php
   $servername = 'localhost';
   $dbuser = 'your_user';
   $dbpass = 'password';
   $db = 'intercityexpress';

   // connect_check.php
   $DB_SERVER = 'localhost';
   $DB_USERNAME = 'your_user';
   $DB_PASSWORD = 'password';
   $DB_DATABASE = 'intercityexpress';
   
9. Copy the URL and load it on browser so that, Admin Registration can be done by default (Or you can set credentials as per you by editing the "admin/add_admin.php" file):  
   
   ```bash
   http://localhost/intercityexpress/admin/add_admin.php
   ```
    Default credentials will be as follows:
    ```bash
    username: admin
    password: admin@123
    ```

## Usage

Once the server is running, open your web browser and navigate to the website given below. From here, you can register as a passenger, travel agent, or login as an admin or employee. Follow the on-screen instructions to explore the features.
  ```bash
  http://localhost/intercityexpress
  ```

And Also keep in mind that as an Admin You have to set some of settings from the Admin's Account as initially Some of the things are not defined.

Some of the Settings are like:

1. Addition of Stations.
2. Addition of Routes.
3. Addition of Trains.
4. Setting of Advance Limit for Booking for each type of Users.
5. Setting of Travel Agent's Commission and Employee's Concession.
6. Addition of Employees.
7. Adding Contact Details for the Contact Us page.

## Contact

For any questions or feedback, please contact me at vickspanda1@gmail.com.


Thank you for using Intercity Express! We hope you have a smooth and enjoyable travel booking experience.


Feel free to customize any sections further based on your project's specific details and requirements. This README.md should provide a comprehensive overview of your project, making it easier for users and contributors to understand and use.
