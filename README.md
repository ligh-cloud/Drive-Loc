# Car Rental Management Platform

## Project Overview

The "Car Rental Management Platform" aims to enhance its website by integrating a **car rental system**. This addition will enable clients to explore and book vehicles that suit their needs while offering a creative and seamless user experience.

The system will be developed using **PHP (OOP)** and **SQL** to ensure robust functionality and scalability.

---

## User Stories

### Features

1. **Authentication**  
   - As a client, I must log in to access the car rental platform.

2. **Exploration**  
   - As a client, I can explore the different categories of available vehicles.

3. **Vehicle Details**  
   - As a client, I can click on a vehicle to view its details (model, price, availability, etc.).

4. **Booking**  
   - As a client, I can book a vehicle by specifying the dates and pick-up/drop-off locations.

5. **Search**  
   - As a client, I can search for a specific vehicle by its model or features.

6. **Filtering**  
   - As a client, I can filter available vehicles by category without refreshing the page.

7. **Feedback**  
   - As a client, I can leave a review or rating for a vehicle I rented.

8. **Pagination**  
   - As a client, I can list the available vehicles by pages (pagination).  
     - **Version 1**: Pagination using PHP.  
     - **Version 2**: Interactive and dynamic pagination using DataTables.

9. **Review Management**  
   - As a client, I can modify or delete my own reviews (soft delete).

### Admin Features

1. **Bulk Operations**  
   - As an administrator, I can add multiple vehicles or categories at once (bulk insertion).

2. **Management Dashboard**  
   - As an administrator, I can manage reservations, vehicles, reviews, and categories.  
   - Includes **statistics and insights** for better decision-making.

---

## Tech Stack

- **Backend**: PHP (OOP)
- **Database**: SQL (MySQL preferred)
- **Frontend**: HTML, CSS, JavaScript

---

## Key Functionalities to Implement

### Core Features

1. **Authentication System**  
   - Secure login and logout functionalities.

2. **Browsing**  
   - Vehicle categorization and filtering.

3. **Pagination**  
   - Enhance user experience using PHP or DataTables.

4. **Booking System**  
   - Enable clients to manage bookings with dates and locations.

5. **Review System**  
   - Allow clients to leave feedback for vehicles.

6. **Admin Dashboard**  
   - Provide tools for administrators to manage the platform.

---

## Installation Instructions

1. Clone the repository:
   ```bash
   git clone <repository-url>
   ```

2. Set up the database:
   - Import the provided SQL file into your MySQL database.
   - Update the database credentials in the `config.php` file.

3. Start the server:
   ```bash
   php -S localhost:8000
   ```

4. Access the platform at `http://localhost:8000`.

---

## Future Enhancements

- **Notifications**: Notify users of booking confirmations or updates.
- **Mobile Optimization**: Ensure a responsive design for mobile devices.
- **Analytics**: Provide administrators with detailed insights and statistics.

---

## License

This project is licensed under the MIT License.

---

## Contributing

We welcome contributions! Please fork the repository and submit a pull request for review.

---

## Contact

For questions or feedback, please contact the project team.

