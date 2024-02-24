
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

#### User authentication
![image](https://github.com/julabrego/giphy-challenge/assets/39074716/352cb8df-75e8-41ad-83aa-9ad5cab6d1e4)

#### Use cases with gifs
![image](https://github.com/julabrego/giphy-challenge/assets/39074716/7025fbf2-e7f1-49e3-8070-1f501e016546)

### Sequence diagrams

#### Register user
![Register](https://github.com/julabrego/giphy-challenge/assets/39074716/c46397a7-be0e-417a-a46f-05f29990713e)

#### Login user
![Login](https://github.com/julabrego/giphy-challenge/assets/39074716/83ce4bb9-8904-4f14-9bd2-fe1e33387d1d)

#### Search gifs
![Search](https://github.com/julabrego/giphy-challenge/assets/39074716/a00217dc-0e6c-4427-b888-83f19534d4dc)

#### Search gif by id
![SearchGifById](https://github.com/julabrego/giphy-challenge/assets/39074716/013136d7-f6aa-4d63-8fb5-5f31a94ea3a6)

#### Save favorite gif
![SaveFavoriteGif](https://github.com/julabrego/giphy-challenge/assets/39074716/d5e34b2f-c742-44b2-8467-4482e9b26573)

### ERD
![DER](https://github.com/julabrego/giphy-challenge/assets/39074716/1de5c505-5349-4d7b-9824-c67a2b9a1d9f)

## Postman collection
You can import [this collection](https://github.com/julabrego/giphy-challenge/blob/main/giphy_api_integration_challenge.postman_collection.json) to your Postman and start playing with the services directly in your computer.

