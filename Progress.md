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
I read through the vue-select documentation.
I added vue-select to the project's dependencies and included v-select as a component within the Vue instance.
I replaced the plain HTML select form element with the vue-select component.
I adjusted styling for the vue-select element to match with the rest of the form elements.

## To Do
* Frontend:
    * Use addon vueselect to create/manage the select dropdown on the quote edit.
    * Review Vue recommended naming conventions, check work.
        * Rename QuoteLineItemEdit -> QuoteLineEdit (etc.)
    * Use learned stuff to do more updates to whole thing.
        * Use direct event retransmit with like `<button @click="$emit('delete')">Delete</button>` rather than bouncing through a method.
    * Style project using Tailwind
    * The height difference between buttons and route links is a bit painful.
    * Run a GET for contents of current content every X seconds to make sure it stays up to date? (Config by env variable?)
    * Experiment with preloading before moving to the next view? Handled by vue-router.

* Backend:
    * factory to generate some sample ProductInQuote instances
    * Feature tests.
    * Load products from external source (CSV?)
    * Note in readme that after changing .env file should run `php artisan config:cache`

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
Which is better API design?
- Separate endpoints for adding an item, removing an item, and changing the item's count
- Single endpoint for setting item count, which adds or removes as necessary.

What's the best practice for keeping front and back updated? Frontend is sending out PATCH whenever a change happens, but (currently) doesn't make a GET request to read the updated state. If someone else is logged in and altering the quote could get into a bit of a confused mess. On a multi-user system, run a GET every X seconds?

I've been entirely using single file components - except for renderless components. Are there other forms I should be ready to use?

It's easy for a renderless component to generate errors with multiple root node, because effectively it dumps whatever is in its default slot directly as its root nodes
