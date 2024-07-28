# Intercity Express

Welcome to the Intercity Express project! This project manages account and booking services for different types of users, including passengers, travel agents, employees, and admins. The project features a robust set of functionalities tailored to each user type, enhancing the overall travel booking experience.

## Table of Contents

- [Features](#features)
  - [Passenger](#passenger)
  - [Employee](#employee)
  - [Travel Agent](#travel-agent)
  - [Admin](#admin)
- [Admin Management](#admin-management)
- [Website Structure](#website-structure)
- [Installation](#installation)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)
- [Contact](#contact)

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
- **Login Page:** Separate login pages for each user type, with a common login page that identifies the user type before proceeding.
- **Schedule Check:** Check the schedule of specific trains between stations.
- **Contact Page:** Admin can update contact details.
- **About Page:** Contains a description of the Intercity Express.

### Booking Process

1. Visit the home page and select journey details (from, to, date of journey, and class of coach).
2. View available trains and seats.
3. Proceed to the common login page and specify the user type.
4. Enter traveler's details and verify them.
5. Complete payment information.
6. Ticket is generated and the user is redirected to their specific dashboard.

## Installation

To run this project locally, follow these steps:
