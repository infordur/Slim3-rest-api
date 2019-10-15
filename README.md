# Simple REST API in Slim Framework 3

<p align="center">
	<img src="extras/img/slim-logo.png">
</p>

Example of REST API with [Slim PHP micro framework](http://www.slimframework.com).


Use this skeleton application to quickly setup and start working on a new Slim Framework 3 application. This application uses the latest Slim 3. It also uses the Monolog logger.

This skeleton application was built for Composer. This makes setting up a new Slim Framework application quick and easy.

## Pre Requisites
    - Git
    - Composer
    - MySQL
    - PHP 7 or above

## Install the Application

### Git

You can download the project with a terminal.
Execute this commands in your terminal:

```bash
$ git clone https://github.com/infordur/Slim3-rest-api.git && cd [app-dir-name]
$ composer install
```

## Configuration

#### 1 - Create a new MySQL Database

You need to create a new MySQL database, you can do following the next instructions

From the command line:

```bash
$ mysql 'CREATE DATABASE <database_name>'
```

It can also be done with a db manager like [phpmyadmin](#https://www.phpmyadmin.net/)

#### 2 - Change database data

Once you have been create the database you need to change the database data from `app/settings.php`

```
'db' => [
	'host' => 'localhost',
	'dbname' => '<database_name>',
	'user' => '<database_user>',
	'pass' => '<database_user_password>',
	'charset' => 'utf8',
	'port' => 3306,
],
```

## Run the server

### Local Server

```bash
$ composer start
```
This run the server on address ```http://localhost:8080```


## Routes

### Tasks

- `GET /api/tasks`
- `GET /api/task/{id}`
- `POST /api/tasks`
- `PUT /api/tasks/{id}`
- `DELETE /api/tasks/{id}`

### Categories

- `GET /api/categories`
- `GET /api/categories/{id}`
- `POST /api/categories`
- `PUT /api/categories/{id}`
- `DELETE /api/tasks/{id}`