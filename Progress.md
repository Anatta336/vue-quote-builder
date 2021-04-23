# Progress

## Brief
The aim is to build a quote builder - a builder goes on-site builds up a quote for the customer at the end this is emailed to them and the quote stored for follow up or acceptance at a later date.

Use a vue interface to make this reactive, the page shouldn't reload between adding and removing items, the total should automatically update on item adding/removal/quantity change.

Build a quote wizard builder with the following functionality
    ability to create products
    ability to create and edit a quote
    ability to assign and remove products on a quote
    ability to increase and decrease line item quantity
    sub-total, vat total and total to automatically update on the quote when adding/removing/editing line items
    ability to send a quote to the customer (send this to mailtrap)
    cron that runs at the end of the day to give an overview of the quotes created that day with totals via email

## Plan
Product:
    Name
    Price

Quote:
    Customer name
    Customer email

ProductInQuote:
    Product (ref)
    Quote (ref)
    Count

## Done
I researched how to schedule jobs in Laravel. I learned that Laravel maintains a schedule that it'll check every time php artisan schedule:run is run. I'll assume a cron job on the server is configured to regularly run that command.
I added a daily scheduled job which will fetch any quotes created in the past 24 hours, and pass them to a mailer.
I created a simple template that lists details of the quotes to use in the email.
I resolved an issue with the email never being sent because the destination address wasn't being set correctly.
I confirmed that the scheduled job sends an email of recently created quotes.

## To Do
A quote view (separate from edit.)
Link to it from the summary email sent out.

Note in readme that after changing .env file should run `php artisan config:cache`

factory to generate some sample ProductInQuote instances
Load products from external source (CSV?)

Feature tests.

Run a GET for contents of current content every X seconds to make sure it stays up to date. (Config by env variable?)

Experiment with preloading before moving to the next view? Handled by vue-router, somewhere

## Notes
To access database directly:
```
& "C:/Program Files/sqlite3/sqlite3" database/database.sqlite
.headers on
.mode column
```

Run the seeder:
```
php artisan migrate:refresh --seed
```

Removed (dev) dependences:
"bootstrap": "^4.0.0",
"jquery": "^3.2",
"lodash": "^4.17.13",
"popper.js": "^1.12",

Ceci n'est pas un 'o'
о ο օ ȯ ọ ỏ ơ ó ò ö

Run any scheduled tasks (server should be set up to automatically call this every X minutes)
```
php artisan schedule:run
```

## Some reference sources
https://www.youtube.com/watch?v=hbq2CAHNRZM
https://laravel-news.com/using-vue-router-laravel
https://vuejs.org/v2/guide/
https://laravel.com/docs/7.x

## Questions
What more can I do with the Vue.use() static method? Currently used for telling it to use vue-router

On success, what should Laravel be returning as a response?
    Been doing stuff like: return response('', Response::HTTP_NO_CONTENT);

How to combine/inherit/something validation rules in Laravel.
    Try extending the class, overriding method and just adding to the array it outputs.

I define some relationships in ProductInQuote, am I doing that in some way the wrong way around? Feels like if I defined it from the direction, I wouldn't have to specify column names for the columns.

Which is better API design?
- Separate endpoints for adding an item, removing an item, and changing the item's count
- Single endpoint for setting item count, which adds or removes as necessary.

What's the best practice for keeping front and back updated? Frontend is sending out PATCH whenever a change happens, but (currently) doesn't make a GET request to read the updated state. If someone else is logged in and altering the quote could get into a bit of a confused mess. On a multi-user system, run a GET every X seconds?
