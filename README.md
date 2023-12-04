# Task Application 

User register and generate token and this token is used in bearer authetication header when making request or accessing (login) the api endpoints.

Blade Templating (React Inertia)
Initial thought was to build an api that communicate with a separate react frontend. After sometimes figured out its an SPA with React Inertia inside Laravel project and vite template. 
So i build this App in Repoistory pattern
I have both controller (API and Blade)
I Didn't get it 100% right was the React Inertia Blade as i use normal blade
but continuing to read more about it.

Using postman you can test my api enpoints on routes below:

1.http://127.0.0.1:8000/api/auth/register
2.http://127.0.0.1:8000/api/auth/login
3.http://127.0.0.1:8000/api/user-tasks
4.http://127.0.0.1:8000/api/task/100
5.http://127.0.0.1:8000/api/task/create
6.http://127.0.0.1:8000/api/task/update/103
7.http://127.0.0.1:8000/api/task/delete/99


## Prerequisites
LARAVEL v10.34.2  plugin v0.8.1
PHP 8.1.26
Sanctum
Node v16.20.2
NPM 8.19.4
Mysql
Composer
Docker
Docker Compose

Before you begin, ensure you have the following installed:

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [Composer](https://getcomposer.org/download/)

## Getting Started

### Installation

1. Clone the repository:

   git clone https://github.com/TaylorLok/TaskApplication.git

2. Navigate to the project directory::

    cd https://github.com/TaylorLok/TaskApplication.git

3. Install composer packages:
    - Run: composer install 
    - Run: npm install
    - Setup your .env
    - Run: php artisan key:generate
    - Run: php artisan migrate
    - Run: php artisan seed:db #migration seeder
    - check your database you will have 100 tasks and 25 users

4. Via docker using Laravel Sail:
    - Run: composer require laravel/sail --dev
    - Run: php artisan sail:install
    - Setup your .env
    - Run: ./vendor/bin/sail artisan migrate #migration
    - Run: ./vendor/bin/sail artisan migrate --seed #migration seeder
    - Run: ./vendor/bin/sail up #run project 

5. Add Sanctum configuration in .env
    - php artisan ziggy:generate
    - APP_URL=http://localhost:8000
    - SESSION_DOMAIN=localhost
    - SANCTUM_STATEFUL_DOMAINS=localhost:3000
    - Run: npm run dev #for frontend scaffolding

6. Testing
    - run php artisan test
    - ./vendor/bin/phpunit #using docker

