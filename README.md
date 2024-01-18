# Simple E-Commerce Website

## Overview

This is a simple E-Commerce website built with Laravel with the following features:

## Features

- **User registration and login:** Users can register and login to the website.
- **Admin dashboard:** Admins can login to the admin dashboard to manage the website.
- **Product management:** Admins can add, edit, and delete products.
- **Order management:** Admins can view and manage orders.
- **User management:** Admins can view and manage users.
- **Cart:** Users can add products to their cart and checkout.
- **Pagination:** Products are paginated.
- **Email notifications:** Users receive email notifications when they register place an order, and when their order is shipped.
- **Payment:** Users can pay for their orders using Stripe.


## Installation

1. Clone the repository

    ```bash
    git clone https://github.com/ahmedmoha2050/ecommerce.git
    ```
2. Navigate to the project directory:

    ```bash
    cd ecommerce
    ```

3. Install the dependencies:

    ```bash
    composer install
    npm install
    ```

4. Create a copy of the `.env.example` file and rename it to `.env`:

    ```bash
    cp .env.example .env
    ```

5. Generate an application key:

    ```bash
    php artisan key:generate
    ```

6. Migrate the database:

    ```bash
    php artisan migrate
    ```

7. Seed the database:

    ```bash
    php artisan db:seed
    ```

8. Start the development server:

    ```bash
    php artisan serve
    ```



## Usage

- Visit the application and log in as a admin to manage the ecommerce.
- Dashboard link is [http://localhost:8000/dashboard/login](http://localhost:8000/dashboard/login).
- Login credentials for a admin are :
  - Email: `admin@example.com`
  - Password: `password`

- Visit the application and log in as a user to manage the ecommerce.
- Dashboard link is [http://localhost:8000/login](http://localhost:8000/dashboard/login).

- Login credentials for a user are :
    - Email: `user@example.com`
    - Password: `password`

## Contributing

Feel free to contribute to the development of this project by submitting issues or pull requests.
