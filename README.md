# Car Rental Scaffolding Website/Application with Laravel 5.2 & AngularJS

## Index
* [Introduction](#introduction)
* [Building Docker Image](#building-docker-image)
* [Setting up Vagrant Enviroment (Optional)](#setting-up-dev-enviroment)
* [Backend - Laravel](#backend---laravel)
  * [Routes](#routes)
  * [Controllers](#controllers)
  * [Views](#views)
  * [Auth](#authentication)
  * [Localization](#localization)
* [DB Schema](#database)
* [FrontEnd](#frontend)
  * [AngularJS](#angular)
  * [Bootstrap](#bootstrap)
  * [Application Interface](#user-interface)
    * [Home](#home)
    * [Fleet](#fleet)
    * [Branches](#branches)
    * [Cars](#cars)
    * [Classes](#classes)
    * [Extras](#extras)
    * [Fuels](#fuels)
    * [Makes](#makes)
    * [Reservations](#reservations)
    * [My Reservations](#my-reservations)
* [References](#references)
* [Authors](#authors)


# Introduction
The purpose of the application is to allow Car Rental businesses to make reservation process for their customers both intuitive and easier. This application is based on REST API architecture which was realized with Laravel, AngularJS and MySQL. UI is powered by Bootstrap.

# Building Docker Image

```
docker build -t rentacar_laravel .

docker image tag rentacar_laravel registry.example.com/rentacar_laravel

docker push registry.example.com/rentacar_laravel
```

# Setting up Dev Enviroment (optional)
After forking this project create database.sqlite file from project directory.
#### 
```sh
touch database/database.sqlite

composer install

npm install
```

<br />Run migration
```sh
#Navigate to project directory

php artisan migrate --seed
or
php artisan migrate:refresh --seed
```
<br>These commands will seed databse with dummy data. Now run
```
php artisan serve
```

<br>Test Login
```
email: test@mail.com
pass: 85200258
```

# Backend - Laravel
## Routes
List of routes used by this application with limited access and grants. Routes are defined inside `app\Http\routes.php`

- User Group: Administrator
  - /admin
  - /admin/cars - View for managing cars within the fleet
  - /admin/makes - View for managing car makes
  - /admin/branches - View for managing company branches
  - /admin/fuels - View for managing fuels
  - /admin/extras - View for managing extra buying options
  - /admin/classes - View for managing car classes
  - /admin/reservations - View for managing reservations
  - /admin/api/reservations - API to retrieve all reservations
  - /admin/api/reservations/confirm - API to confirm reservation was received
  - /admin/api/reservations/deliver - API to confirm that car was delivered to customer
  - /admin/api/reservations/returned - API to confirm that car was returned and set reservation as completed
  - [POST] /api/makes - API to add makes
  - [POST] /api/fuels - API to add fuels
  - [POST] /api/extras - API to add extras
  - [POST] /api/cities - API to add cities
  - [POST] /api/classes - APi to classes
  - [POST] /api/colors - API to add colors
  - [POST] /api/branches - API to add branches
  - [POST] /api/models - API to models under available make
  - [POST] /api/cars - API to add cars
  
- Access: Authenticated users
  - /api/reservation/save - API to confirm reservation by user
  - /api/users/reservations - API to retrieve reservation for user
  - /reservations - View to display user's reservations

- Access: Public
  - / - View home page
  - /fleet - View to display fleet
  - /contact - View to display contact form
  - /register - View to display registration form
  - /login - View to display login form
  - /reset - View for password reset
  - /settings/lang/{id} - Route to change the current locale
  - /api/authenticated - Route to check whether an user is authenticated
  - /api/makes - API to retrieve makes
  - /api/fuels - API to retrieve fuels
  - /api/extras - API to retrieve extras
  - /api/cities - API to retrieve cities
  - /api/classes - API to retrieve car classes
  - /api/colors - API to retrieve colors
  - /api/branches - API to retrieve branches
  - /api/models - API to retrieve models
  - /api/cars - API to retrieve cars
  - /api/email/send - API to send an email
 
## Controllers
Controllers used by this application are located inside `App\Http\Controllers`
- HomeController - returns public Views
- Admin Controller - returns Views accessible only by Administrator 
- ApiController - All API endpoints
- AuthController - Auth Controller
- PasswordController - Password Recovery Controller

## Views
Views used by this application are located inside `resources\views`
- /admin 
  - branches - view, edit, add branches
  - cars - view, edit, add cars
  - classes - view, edit, add car classes
  - extras - view, edit, add extras
  - fuels - view, edit, add fuel
  - makes - view, edit, add makes
  - reservations - view and manage reservations
- /auth
  - /email
    - password - recover password template
  - /passwords
    - email - reset password template
    - reset - reset password
- /layouts
  - app - parent view
- /user
  - reservations - display user's reservations
- contact - Contact View
- fleet - Fleet View
- home - Home Page View

## Authentication
Laravel Default Auth. More details can be found at:

[Laravel Authentication](https://laravel.com/docs/5.2/authentication "Laravel Authentication")


Auth Controllers were overridden inside `App\Http\Controllers\Auth\AuthController.php`

```php
protected function validator(array $data)
{
    return Validator::make($data, [
        'name' => 'required|max:255',
        'email' => 'required|email|max:255|unique:users',
        'password' => 'required|min:6|confirmed',
        'address' => 'required',
        'city' => 'required',
        'phone' => 'required',
    ]);
}

protected function create(array $data)
{
    return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => bcrypt($data['password']),
        'address' => $data['address'],
        'city' => $data['city'],
        'phone' => $data['phone'],
    ]);
}
```

## Localization

Built-in localization [Laravel Localization](https://laravel.com/docs/5.2/localization "Laravel Localization")

Translation files can be found within `resources\lang` directory.
The application currently supports English and Croatian languages.

# Database
Database management system used by this app is MySQL. DB Schema, i.e. Model Structure can be seen here.

![alt text](https://raw.githubusercontent.com/parisian/RentACar/master/db.jpg "RentACar Model baze")


# FrontEnd
## AngularJS
This app uses AngularJS as the frontend JS framework. Everything Angular related can be found withing `public\js\app` directory.
- app.js - Initialize AngularJS app
- /controllers/RentACarController.js - Defines app controllers
- /services/RentACarService.js - Defines calls to API endpoints

## Bootstrap
For the better UI, this app uses Bootstrap CSS framework

# User Interface
### Početna
4-step reservations form is displayed on the Home Page
1. Pickup and return place and time selection as well as renting duration
2. Vehicle selection
3. Extras selection
4. Reservation confirmation

A user can navigate through the reservation form if these rules are met
1. A User is logged in
2. Both pickup and return place and time are selected (Step 1.)
3. Vehicle is selected (Step 2.)

If at least one rule is not met, a user will not be able to go to the next step.

If all the rules are met, a user will be able to complete the reservation process.

### Fleet
This page displays every car within the fleet.

### Branches
This page allows administrators to manage branches.

### Cars
This page allows administrators to manage cars.

### Classes
This page allows administrators to manage car classes.

### Extras
This page allows administrators to manage extras.

### Fuels
This page allows administrators to manage fuel.

### Makes
This page allows administrators to manage makes and models.

### Reservations
This page allows administrators to manage reservation. Each reservation has 4 states. First state, `Reservation submitted by user`. Second state, `Reservation confirmed`. Third state, `Car delivered to a user`. Fourth state, `Car returned by user; Reservation Completed`.

### My Reservations
This page displays reservations made by a user.

# References
- Laravel - https://laravel.com
- AngularJS - angularjs.org
- angular-file-model - https://github.com/ghostbar/angular-file-model
- Bootstrap - https://getbootstrap.com/getting-started/
- Bootstrap DateTime Picker (Jonathan Peterson) - https://github.com/Eonasdan/bootstrap-datetimepicker
- jQuery - https://jquery.com
- MomentJS - http://momentjs.com

# Authors
- Anton Krizmanić @ https://github.com/cupko55
- Antonio Šamuga @ https://github.com/thebasix




