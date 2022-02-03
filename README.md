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

Now, for you will be able to access the api by hitting the API urls mentioned in web.php.
