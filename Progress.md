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
Models:
    Products
    Quote

Product:
    Name
    Price

ProductInQuote:
    Product (ref)
    Quote (ref)
    ProductCount


A quote has many products, each product


## Done
I created a new Laravel 7 project.
I installed the UI package.
I added Vue UI scaffolding for user authorisation.
I added a User seeder that creates a sample account.
I confirmed I could use the basic (non-Vue) user interface to log in.

I created a factory and seeder for Products, and confirmed they created valid data that can be accessed through the Product model.
I created a simple Vue component and added it to a Blade template.
I added an API route that returns all Products.
I used Axios to make the Vue component fetch data from that API route.
I made the Vue component show the names of those fetched products as a simple list.

I installed and set up vue-routes.
I created sample routes and views using Vue.
I added a SpaController and a catch-all route in Laravel that directs all requests to the front end's single page application.
I added the component that fetches and displays a list of products to a Vue view.

I added an API end point and controller action for adding a product.
I added validation rules for creating a product.
I created a basic Vue form for creating a new product, which submits the data as a POST request to the correct endpoint on the Laravel API.

The Vue frontend can add products and have them listed without the page ever needing to reload, but it doesn't handle validation errors it receives back from the backend. I'll be working on that next.

I examined the object provided by Axios when a request results in an error, and found how to access any validation error messages.
I added to the ProductAdd Vue component so it can extract and display validation errors next to the relevant form field.
I extracted the error display into its own Vue component.
Found an issue where entering a product price of "abc" displays the validation error that a product price is required, rather than the specific "must be a number" check.

## To Do
Display validation errors in the Vue side.
Test if the validation is actually working.

Pull out error listing to separate component.

Frontend force the price field to only take numbers (and decimals.)

Form to edit existing products.

Do some basic styling. Don't think we need Bootstrap (and jQuery), if we can be efficient about things.

Load products from some external source (CSV?)

Work out how exactly the "cart" is going to work.
Separate table for ProductInCart makes sense to me. Refers to product and quote, and count of product.

"Resources" may be useful? https://laravel.com/docs/7.x/eloquent-resources
Seems to define a mapping between Eloquent model and JSON, or other representation.
...although for basic models that's automatically done so not much advantage.

## Notes
To access database directly:
```
& "C:/Program Files/sqlite3/sqlite3" database/database.sqlite
```

Run the seeder:
```
php artisan migrate:refresh --seed
```

## Questions
What's the deal with naming Vue components? I seem to be able to use <product-list> and <ProductList> interchangably.

What more can I do with the Vue.use() static method? Currently used for telling it to use vue-router
