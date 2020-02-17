# SMS Sender

A PHP microservice with the purpose to send text messages based on the Busines Rules of takeaway.com.


# Installation

## Prerequisites

- Docker
- Docker Compose

## Set up

1. Clone the repository to your local machine.
2. Set the environment variables in the .env file. For twilios variables read [its API reference](https://www.twilio.com/docs/usage/api).
3. Build the images with:
	>docker-compose build
4. Run the migrations to create the database and fill it with some data:
	>docker-compose run --rm app php artisan migrate:fresh --seed
5. Finally run the containers with:
	>docker-compose up
6. You can check http://localhost:8080/view to see the messages log.

# Running Tests

Before run the tests its always good idea to run the migrations, just to make sure the DB is consistent. So start with:
>docker-compose run --rm app php artisan migrate:fresh --seed

## Running Cron

If it's necessary for the tests you can run the cron function with:
>docker exec -it sms_sender_cron_1 php artisan schedule:run

## Backend

To run the backend tests with phpunit run:
>docker-compose run --rm app vendor/bin/phpunit

## Frontend

I didn't have time to implement the frontend tests. :(


# API

There is a postman collection with all available endpoints in the repository. Here I will only explain the send SMS one, since it's the one that has most of the business rules.

		Method: POST
		URL: http://localhost:8080/sms/send
		Body: 
		     - restaurant_id: Integer that links the message to a restaurant
			 - phone_number: Phone that the message will be send to (Must be registered on twilios console since its a trial version of the service)
			 - type: A flag to informe if the message was sent after or before the food was delivered.

# Development Process

In the following sections I will talk a bit about the development process.

## Technologies and tools

Here I will explain why I picked the main technologies in this project

- Docker: It was required in the challenge, later I will talk a bit more about my decisions a made for Docker.
- PHP: It was also required. Although I have a long history with PHP that was the first time in a while a worked with it, it was good to have contact with again.
- Lumen: I picked Lumen instead of Laravel because the microservice was a away to simple to use a full framework.
- MySQL: Here I had to use MySQL 5.7 because it's the last version that Lumen gives support.
- Vue: My experience with frontend it's not as great as my backend experience, but luckily  I have some experience with Vue, so it was an easy decision.
- PHPUnit: When it comes to tests for PHP that is the best option, besides Lumen comes with it.
- Jest: Most of my experience with tests is with Jest, so that's why I picked it. Unfortunately I had no time to implement frontend tests.

### Other Tools
- Gitmoji: It makes easier to identify what was done in each commit associating the messages with emojis.
- Gitflow: A git extesion to make easier to work with branches. It's not really necessary in a single person project but it helps with organization.
- Bootstrap Vue: I know that a simple project and there was not need for such a powerful tool, but as my time was short I decided to use it and don't waste time by doing my own components.

# Docker Containers
I created four containers:

- view: Deals with Vue.
- app: Deals with Lumen.
- db: Deals with MySQL.
- cron: Deals with the cron that is responsible for send a message 90 minutes later the delivery time.

# Patterns and Architecture
Here I tried to stick with DDD and Lumen native architecture. At the begging I thought  I could be a little flexible about the patterns because the project was simple and I wanted save some time. It was not a good idea and eventually I had to refactor a few things. In the end most of the code is following the MVC Pattern plus Service and Repository Patterns to take care of the complex business rules.

Each layer is well defined and separated:

- View: Vue project with the logs of the messages.
- Model: There are two models: Restaurant and Message. I decided keep then both in the root of the app folder since that's the standard location on Lumen and as a microservice the project tend to not get much bigger than that.
- Controller: Works basically like a proxy, does not implement complex business rules, only validations. The only endpoints that have some logic are the ones for restaurant. That is because they were not really necessary or important in the project, I only did them to warm up my PHP at the begging of the project.
- Service: Implements the complex business rules. In this case it has the logic to send SMS.
- Repository: Have the business rules related to Database. Here it has the logic to manipulate message model.

# Conclusion

Although the requisites were implemented, including the extra ones, as in any other project there are room for improvement. There should be a away more tests in the backend to cover the exceptions and error code returns, the frontend doesn't have test at all and it really ugly and other other little details that are bugging me.
In general the challenge was not difficult, it was good to catch up with PHP after almost an year doing just basic maintenance of legacy systems. The main challenge was to find time to focus on the project.

Looking forward to hear the results.

Thank you for the opportunity!
