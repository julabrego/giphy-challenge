
# Giphy Challenge with PHP

Laravel application which provides an API REST of services that integrates with [Giphy](https://developers.giphy.com/docs/api/#quick-start-guide).

## Installation

1) Clone this repository
2) Create a `.env` file from `.env.example` file
```bash
cp .env.example .env
```
3) Most of the environment variables default values defined in the `.env` will work well for development, but for this example you'll need a valid `GIPHY_API_KEY`.
4) Install dependencies
```bash
composer install
```
5) Run migrations
```bash
php artisan migrate
```
6) Create the encryption keys required to generate secure access tokens
```bash
php artisan passport:install
```
7) Run the server and have fun
```
php artisan serve
```

## Documentation

### Use cases

#### Register user
![Register user](relative%20path/to/img.jpg?raw=true "Register User Use case")

#### Login user
![Login user](relative%20path/to/img.jpg?raw=true "Login User Use case")

#### Search gifs
![Search gifs](relative%20path/to/img.jpg?raw=true "Search gifs Use case")

#### Search gif by id
![Search gif by id](relative%20path/to/img.jpg?raw=true "Search gif by id Use case")

#### Save favorite gif
![Save favorite gif](relative%20path/to/img.jpg?raw=true "Save favorite gif Use case")

### Sequence diagrams

#### Register user
![Register user](relative%20path/to/img.jpg?raw=true "Register User sequence diagram")

#### Login user
![Login user](relative%20path/to/img.jpg?raw=true "Login User sequence diagram")

#### Search gifs
![Search gifs](relative%20path/to/img.jpg?raw=true "Search gifs sequence diagram")

#### Search gif by id
![Search gif by id](relative%20path/to/img.jpg?raw=true "Search gif by id sequence diagram")

#### Save favorite gif
![Save favorite gif](relative%20path/to/img.jpg?raw=true "Save favorite gif sequence diagram")

### ERD

![ERD](relative%20path/to/img.jpg?raw=true "Entity relationships diagram")
## Postman collection

You can import this [Postman collection](https://github.com/matiassingers/awesome-readme) to play with the services directly in your computer.

