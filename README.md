Laravel-Login
=============

A basic membership system made with Laravel. Functionalities include Sign In, Sign Out, Forgot password, Sign Up, and Email activation. The design is responsive and made with Bootstrap v3.1.1.

I use this everytime I start a project that requires a login system.

<img src="https://raw.github.com/parinparikh/Laravel-Login/master/public/assets/img/screenshot.png" width="350px" alt=" Screenshot" />

Configure
=========

To configure you need to open:

- app/config/database.php
  - You will need to change your default driver and its info: host, database, username, and password.
- app/config/mail.php
  - You will need to change host, port, from, username, and password


You can run the migration the usual way

```
php artisan migrate
```

And you will be good to go.

More information about Laravel
==============================

## Laravel PHP Framework

[![Latest Stable Version](https://poser.pugx.org/laravel/framework/version.png)](https://packagist.org/packages/laravel/framework) [![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.png)](https://packagist.org/packages/laravel/framework) [![Build Status](https://travis-ci.org/laravel/framework.png)](https://travis-ci.org/laravel/framework)

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, and caching.

Laravel aims to make the development process a pleasing one for the developer without sacrificing application functionality. Happy developers make the best code. To this end, we've attempted to combine the very best of what we have seen in other web frameworks, including frameworks implemented in other languages, such as Ruby on Rails, ASP.NET MVC, and Sinatra.

Laravel is accessible, yet powerful, providing powerful tools needed for large, robust applications. A superb inversion of control container, expressive migration system, and tightly integrated unit testing support give you the tools you need to build any application with which you are tasked.

## Official Documentation

Documentation for the entire framework can be found on the [Laravel website](http://laravel.com/docs).

### Contributing To Laravel

**All issues and pull requests should be filed on the [laravel/framework](http://github.com/laravel/framework) repository.**

### License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
