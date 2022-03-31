# Mini CRM - API
This is a [RESTful API](https://en.wikipedia.org/wiki/Representational_state_transfer)

This project was made with: [Laravel](https://laravel.com/)

For api authentication: [Sanctum](https://laravel.com/docs/8.x/sanctum)

## Installation

Clone the repository

Configure database on .env file

Run migrations with:
~~~bash
php artisan migrate
~~~

Run seeder with:
~~~bash
php artisan db:seed --class=PropertySeeder
~~~

Run the project with:
~~~bash
php artisan serve
~~~

## Testing
Tests are located in the tests folder in the root of the project.

Run:
~~~bash
php artisan test
~~~

## Project structure
The project structure is the Laravel default structure

The code is located in the app folder

## API Documentation
Base Uri: http://localhost:8000/api

### Auth

#### Login
 
POST to __/auth/logout__

Body params:
~~~json
{
    "email": "string",
    "password": "string"
}
~~~

Example response
~~~json
{
    "user": {
        "id": 2,
        "name": "Clara",
        "email": "clara@gmail.com",
        "email_verified_at": null,
        "created_at": "2022-03-30T15:50:34.000000Z",
        "updated_at": "2022-03-30T15:50:34.000000Z"
    },
    "auth_token": "4|AXW4rRx123OQWQxXdiEbWXJDPJpmRuaucHjSvtS3Awf"
}
~~~

#### Register

POST to __/auth/register__

Body params:
~~~json
{
    "name": "string",
    "email": "string",
    "password": "string",
    "password_confirmation": "string"
    
}
~~~

Example response
~~~json
{
    "user": {
        "name": "Clara",
        "email": "clara12@gmail.com",
        "updated_at": "2022-03-30T16:54:20.000000Z",
        "created_at": "2022-03-30T16:54:20.000000Z",
        "id": 4
    },
    "auth_token": "6|wAQoinfasdamK9PsXeJeCZT0fu0vb02utVz0M6vrcYl"
}
~~~

#### Logout

POST to __/auth/logout__

Pass the "auth_token" obteined on login throw Bearer Token

Example response
~~~json
{
    "message": "Logged out successfully!"
}
~~~

## Items

In every item method is necesesary to pass the "auth_token" obteined on login throw Bearer Token

### GET to __/items__ to list all the items

Example response
~~~json
{
  "data": [
    {
      "id": 1,
      "name": "Pizza Española",
      "created_at": "2022-03-30T13:40:06.000000Z",
      "updated_at": "2022-03-30T13:40:06.000000Z",
      "properties": [
          {
              "id": 2,
              "name": "vegetarian"
          },
          {
              "id": 3,
              "name": "sweet"
          }
      ]
    },
    {
      "id": 2,
      "name": "Burger",
      "created_at": "2022-03-30T13:40:17.000000Z",
      "updated_at": "2022-03-30T13:40:17.000000Z",
      "properties": []
    }
  ]
}
~~~

### POST to __/items__ to create a new item

Body params:
~~~json
{
    "name": "Burger", //string
    "properties": [1,2] //array of properties ids, could be an empty array
}
~~~

Example response

~~~json
{
    "data": {
        "id": 53,
        "name": "Burger",
        "created_at": "2022-03-30T21:42:39.000000Z",
        "updated_at": "2022-03-30T21:42:39.000000Z",
        "properties": [
            {
                "id": 1,
                "name": "vegan"
            },
            {
                "id": 2,
                "name": "vegetarian"
            }
        ]
    }
}
~~~

### PUT to __/items/{itemId}__ to update a new item
~~~json
{
    "name": "Burger", //string
    "properties": [1,3] //array of properties ids, could be an empty array
}
~~~

The properties must be send everytime. If you don't send any property
nothings going to be save in the items_properties (the intermediate table between items and properties).

Example response
~~~json
{
    "data": {
        "id": 53,
        "name": "Burger",
        "created_at": "2022-03-30T21:42:39.000000Z",
        "updated_at": "2022-03-30T21:42:39.000000Z",
        "properties": [
            {
                "id": 1,
                "name": "vegan"
            },
            {
                "id": 3,
                "name": "sweet"
            }
        ]
    }
}
~~~

### DELETE to __/items/{itemId}__
Status code: 204 No content



