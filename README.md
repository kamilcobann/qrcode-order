QR-Code Ordering API

This API documentation leads the way to how to use QR-Code Order API.

All the routes/endpoints started with the prefix /api since these routes created in api.php and also because JWT Authentication is used in this API except some endpoints, there must be a Bearer token used. (The \* sign beginning of the endpoint means there’s no need to use bearer token).

After import this repository :

composer update

change env.example to env

set up your mysql database

php artisan key:generate

configure your .env

Authentication Operations:

|Endpoint|Function Location|Request Method|
| :- | :- | :- |
|\*login|AuthController@login|POST|
|\*register|AuthController@register|POST|
|refresh|AuthController@refresh|POST|
|logout|AuthController@logout|POST|

Endpoint requirements: 

register (POST):

'name' => 'required|string',

'surname' => 'required|string',

'email' => 'required|string|email',

'phone' => 'required|numeric|digits:10',

'password' => 'required|string',

'address' => 'required|string'

login (POST):

'email' => 'required|string|email',

'password' => 'required|string',



Product Operations: 

|Endpoint|Function Location|Request Method|
| :- | :- | :- |
|\*products|ProductController@getAllProducts|GET|
|\*products/id|ProductController@getProductById|GET|
|products|ProductController@addProduct|POST|
|products/id|ProductController@updateProductById|PUT|
|products/id|ProductController@deleteProductById|DELETE|

Endpoint requirements:

products (POST) :

'category\_id' => 'required|integer',

'name' => 'required|string',

'description' => 'required|string',

'image' => 'required|string',

'amount' => 'required|integer',

'price'=>'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',

products/id (PUT):

'category\_id' => 'required|integer',

'name' => 'required|string',

'description' => 'required|string',

'image' => 'required|string',

'amount' => 'required|integer',

'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',



Category Operations:

|Endpoint|Function Location|Request Method|
| :- | :- | :- |
|\*categories|CategoryController@getAllCategories|GET|
|\*categories/id|CategoryController@getCategoryById|GET|
|categories|CategoryController@addCategory|POST|
|categories/id|CategoryController@updateCategoryById|PUT|
|categories/id|CategoryController@deleteCategoryById|DELETE|

Endpoint requirements:

categories(POST):

'name' => 'required|string'

categories/id (PUT) : 

'name' => 'required|string'



Cart Operations:

|Endpoint|Function Location|Request Method|
| :- | :- | :- |
|carts|CartController@getCart|GET|
|carts|CartController@addToCart|POST|
|carts|CartController@removeFromCart|PATCH|
|carts|CartController@deleteCart|DELETE|

Endpoint requirements:

carts (POST):

'product\_id' => 'required|integer',

'amount' => 'required|integer'

carts (PATCH):

'product\_id' => 'integer|required',

'amount' => 'integer|nullable',



QR-Code Operations:

|Endpoint|Function Location|Request Method|
| :- | :- | :- |
|qr-cart|QRCodeController@cartQR|GET|
|qr-read|QRCodeController@readQR|POST|
|qr-read|QRCodeController@page|GET|

Endpoint requirements:

qr-read (POST):

'cart\_qrcode' => 'required'

\*\*\* qr-read (GET) returns the view of the form that requires the ’cart\_qrcode' \*\*\*  

\*\*\* cart.qrcode is an image \*\*\*



