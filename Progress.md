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
I began learning about renderless components.
I learned that renderless components have state and methods just like any component, but do not themselves define any rendered output. Instead they use scoped slots to make that state and logic available to the consuming component
I used a renderless component to calculate the total cost of a quote, separating how those totals are calculated from how they are displayed.

## To Do
Learn about renderless components.
    Apply to calculating totals

Renderless components do an interesting thing with not having a root element, just dumping the slot contents in there directly. Is there a way to avoid problems with that?

Remove all import PriceFromPence (no longer exists)

Review Vue recommended naming conventions, check work.

Use learned stuff to do more updates to whole thing.
    Use direct event retransmit with like `<button @click="$emit('delete')">Delete</button>` rather than bouncing through a method.

Use addon vueselect to create/manage the select dropdown on the quote edit.

The height difference between buttons and route links is a bit painful.

Style project using Tailwind

factory to generate some sample ProductInQuote instances

Feature tests.

Load products from external source (CSV?)

Run a GET for contents of current content every X seconds to make sure it stays up to date? (Config by env variable?)

Experiment with preloading before moving to the next view? Handled by vue-router.

Note in readme that after changing .env file should run `php artisan config:cache`

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

I've been entirely using single file components. Should I be ready to swap to an alternative?
