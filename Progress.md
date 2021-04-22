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
I began cleaning up frontend for managing a quóte.
I split the component into modular parts.

## To Do
QuoteProducts.vue is long. Split it up into components if possible.

cron that runs at the end of the day to give an overview of the quotes created that day with totals sent via email

give styling to validation errors

No need for quote edit screen to list the product's count twice.

Arrange buttons on quote edit screen a bit nicer too.

Frontend, on quote there's "product" and "productInQuote" object which are similar but not the same. Improve that somehow?

A "sync with server" button? Trigger a GET of the quote.

Combine the quote editing screens into one, rather than jumping between pages.

factory to generate some sample ProductInQuote instances

Frontend force the price field to only take numbers (with decimal)

Load products from some external source (CSV?)

Note in readme that after changing .env file should run `php artisan config:cache`

Run a GET for contents of current content every X seconds to make sure it stays up to date. (Config by env variable?)

experiment with preloading before moving to the next view. Handled by vue-router, somewhere

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

## Some reference sources
https://www.youtube.com/watch?v=hbq2CAHNRZM
https://laravel-news.com/using-vue-router-laravel
https://vuejs.org/v2/guide/
https://laravel.com/docs/7.x

## Questions
What's the deal with naming Vue components? I seem to be able to use <product-list> and <ProductList> interchangably.
    kebab-case is recommended for custom XHTML (or XML generally?) tags. It looking different from real HTML is very much intended.

What more can I do with the Vue.use() static method? Currently used for telling it to use vue-router

On success, what should Laravel be returning as a response?
    Been doing stuff like: return response('', Response::HTTP_NO_CONTENT);

How to combine/inherit/something validation rules in Laravel.
    Try extending the class, overriding method and just adding to the array it outputs.

When taking input for creating a "product in quote" it'll receive an ID for each. Should FormRequest-type validation handle checking that those IDs exist on the relevant tables? It'll get checked by the database-level foreign key enforcement. But would be nice to have a more human-friendly check first. Remember (and note in comment) that some other user could be logged in that deleted a product/quote in the time between a dropdown being populated and the dropdown being used.

I define some relationships in ProductInQuote, am I doing that in some way the wrong way around? Feels like if I defined it from the direction, I wouldn't have to specify column names for the columns.

Which is better API design?
- Separate endpoints for adding an item, removing an item, and changing the item's count
- Single endpoint for setting item count, which adds or removes as necessary.

What's the best practice for keeping front and back updated? Frontend is sending out PATCH whenever a change happens, but (currently) doesn't make a GET request to read the updated state. If someone else is logged in and altering the quote could get into a bit of a confused mess. On a multi-user system, run a GET every X seconds?
