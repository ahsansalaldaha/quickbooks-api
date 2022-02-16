# Resourceinn Quickbooks Microservice

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![License](https://img.shields.io/packagist/l/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)

Resourceinn Quickbooks Microservice is a microservice that serves the purpose of connecting to quickbooks

## Steps

The first thing you need to do is connect to the quickbooks by hitting url
Make sure you have passed a header **x-api-key** with pass mentioned in your .env

```
{url}/quickbooks/connect
```

this will allow you to to connect with the quickbooks and token will be stored in the quickbooks_tokens table.

```
{url}/quickbooks/token
```

it will hit the token url make sure this is properly set in the redirect urls

```
https://developer.intuit.com/app/developer/appdetail/test/keys?appId=djQuMTo6OGQzYmJlYTI3Yg:ca4aa4e3-b0e6-431b-a465-40e43712be5d
```
After doing that a token will be stored inside the token's table and the quickbooks provider will make use of first token. You can alter that in the provider or delete and reconnect if you want to change the account.

Now, for you will be able to access the api by hitting the API urls mentioned in web.php.

## Guide to create API

here are the places which you can use to create api

API for fields:
[API Guide](https://developer.intuit.com/app/developer/qbo/docs/api/accounting/all-entities/customer#create-a-customer)

SDK usage:
[SDK Usage](https://intuit.github.io/QuickBooks-V3-PHP-SDK/quickstart.html#sending-requests)

For Minimum Fields look at v3 Postman SDK

For creating more API's follow the Sample CRUD App

https://github.com/IntuitDeveloper/SampleApp-CRUD-PHP/tree/master/CRUD_Examples


## List of Routes
```
+--------+------------------------+-----------------------+------------+--------------------+------------------------------------------------------------+
| Method | URI                    | Name                  | Action     | Middleware         | Map To                                                     |
+--------+------------------------+-----------------------+------------+--------------------+------------------------------------------------------------+
| GET    | /                      |                       | Closure    |                    |                                                            |
| GET    | /quickbooks/connect    | quickbooks.connect    | Controller | logging            | App\Http\Controllers\QuickbookConnectController@connect    |
| DELETE | /quickbooks/disconnect | quickbooks.disconnect | Controller | logging            | App\Http\Controllers\QuickbookConnectController@disconnect |
| GET    | /quickbooks/token      | quickbooks.token      | Controller | logging            | App\Http\Controllers\QuickbookConnectController@token      |
| GET    | /company-info          |                       | Controller | logging,quickbooks | App\Http\Controllers\APIController@companyInfo             |
| GET    | /customers             |                       | Controller | logging,quickbooks | App\Http\Controllers\CustomerAPIController@index           |
| GET    | /customers/{id}        |                       | Controller | logging,quickbooks | App\Http\Controllers\CustomerAPIController@show            |
| POST   | /customers             |                       | Controller | logging,quickbooks | App\Http\Controllers\CustomerAPIController@store           |
| PUT    | /customers/{id}        |                       | Controller | logging,quickbooks | App\Http\Controllers\CustomerAPIController@update          |
| DELETE | /customers/{id}        |                       | Controller | logging,quickbooks | App\Http\Controllers\CustomerAPIController@delete          |
| GET    | /invoices              |                       | Controller | logging,quickbooks | App\Http\Controllers\InvoiceAPIController@index            |
| GET    | /invoices/{id}         |                       | Controller | logging,quickbooks | App\Http\Controllers\InvoiceAPIController@show             |
| POST   | /invoices              |                       | Controller | logging,quickbooks | App\Http\Controllers\InvoiceAPIController@store            |
| PUT    | /invoices/{id}         |                       | Controller | logging,quickbooks | App\Http\Controllers\InvoiceAPIController@update           |
| DELETE | /invoices/{id}         |                       | Controller | logging,quickbooks | App\Http\Controllers\InvoiceAPIController@delete           |
| GET    | /payments              |                       | Controller | logging,quickbooks | App\Http\Controllers\PaymentAPIController@index            |
| GET    | /payments/{id}         |                       | Controller | logging,quickbooks | App\Http\Controllers\PaymentAPIController@show             |
| POST   | /payments              |                       | Controller | logging,quickbooks | App\Http\Controllers\PaymentAPIController@store            |
| PUT    | /payments/{id}         |                       | Controller | logging,quickbooks | App\Http\Controllers\PaymentAPIController@update           |
| DELETE | /payments/{id}         |                       | Controller | logging,quickbooks | App\Http\Controllers\PaymentAPIController@delete           |
+--------+------------------------+-----------------------+------------+--------------------+------------------------------------------------------------+
```

### Network Configuration
This api is built to work with traefik proxy which can configured by running traefik instance on network 
```
traefik-network
```
which is an external network.

### Running the Service
You can run the service through docker by going inside the docker folder and running
```
docker-compose up -d
```
and changing your env accordingly