
# Giphy Challenge with PHP

Laravel application which provides an API REST of services that integrates with [Giphy](https://developers.giphy.com/docs/api/#quick-start-guide).

## Table of Contents

- [Installation](#installation)
- [Running Tests](#running-tests)
- [Use Cases](#use-cases)
  - [User Authentication](#user-authentication)
  - [Gifs Interactions](#gifs-interactions)
- [Sequence Diagrams](#sequence-diagrams)
  - [Login User](#login-user)
  - [Register User](#register-user)
  - [Search Gifs](#search-gifs)
  - [Search Gif by ID](#search-gif-by-id)
  - [Save Favorite Gif](#save-favorite-gif)
- [Entity Relationship Diagram](#entity-relationship-diagram)
- [API Reference](#api-reference)

## Installation

1) Clone this repository and enter to its directory.
2) Create a `.env` file from `.env.example` file.
```bash
cp .env.example .env
```
3) Edit the `.env` file and fill the `DB_USERNAME` and `DB_PASSWORD` with your desired values. Also, you'll have to fill the `GIPHY_API_KEY` with a valid one.
4) Create the Docker image for the project.
```bash
docker-compose build
```
5) Once the image is created, you'll be able to run the project from Docker. This is the command you'll have to use to run the application from now on.
```bash
docker-compose up -d
```
6) The first time you run the application, you'll have to do some initial setup: install the project's dependencies, generate the application key, run the database migrations and generate the Passport's encryption keys to properly generate the access tokens:
```bash
docker exec prex_challenge_app composer install
docker exec prex_challenge_app php artisan key:generate
docker exec prex_challenge_app php artisan migrate
docker exec prex_challenge_app php artisan passport:install
```
7) At this time, your application should be fully operational. You can check the [API Reference](#api-reference) or import [this collection](https://github.com/julabrego/giphy-challenge/blob/main/giphy_api_integration_challenge.postman_collection.json) to your Postman (or your favorite HTTP client) and begin playing with the services directly in your computer.

## Running tests
To run test, run the following command
```bash
docker exec prex_challenge_app php artisan test
```

## Use cases
There are two main blocks of use cases in this application: two for the user registration and authentication, and three for the gif interactions.

### User authentication
![image](https://github.com/julabrego/giphy-challenge/assets/39074716/352cb8df-75e8-41ad-83aa-9ad5cab6d1e4)

### Gifs interactions
![image](https://github.com/julabrego/giphy-challenge/assets/39074716/7025fbf2-e7f1-49e3-8070-1f501e016546)

## Sequence diagrams

In the following images you can check with more details how the system handles the previously mentioned use cases.

### Login user*
*This diagram includes the details of the User Interaction Logging middleware. All the remaining diagrams just hide it. 

![Login](https://github.com/julabrego/giphy-challenge/assets/39074716/83ce4bb9-8904-4f14-9bd2-fe1e33387d1d)

### Register user
![Register](https://github.com/julabrego/giphy-challenge/assets/39074716/c46397a7-be0e-417a-a46f-05f29990713e)

### Search gifs
![Search](https://github.com/julabrego/giphy-challenge/assets/39074716/a00217dc-0e6c-4427-b888-83f19534d4dc)

### Search gif by id
![SearchGifById](https://github.com/julabrego/giphy-challenge/assets/39074716/013136d7-f6aa-4d63-8fb5-5f31a94ea3a6)

### Save favorite gif
![SaveFavoriteGif](https://github.com/julabrego/giphy-challenge/assets/39074716/d5e34b2f-c742-44b2-8467-4482e9b26573)

## Entity Relationship Diagram
Here is a tiny diagram showing the relationships between the domain entities.

![DER](https://github.com/julabrego/giphy-challenge/assets/39074716/1de5c505-5349-4d7b-9824-c67a2b9a1d9f)

## API Reference

The API endpoints are structured as follows:

- `/auth/register`: Register a new user
- `/auth/login`: Authenticate a user and retrieve a token
- `/gifs/search`: Search for gifs with a query term
- `/gifs/{id}`: Retrieve a specific gif by its ID
- `/favorites`: Get all favorite gifs for the authenticated user
- `/favorites`: (POST) Save a gif as favorite
- `/favorites/{gif_id}`: (DELETE) Remove a gif from favorites

For more details on request and response formats, please import [this collection](https://github.com/julabrego/giphy-challenge/blob/main/giphy_api_integration_challenge.postman_collection.json) to Postman or your favorite HTTP Client software.
