# LoggiPHP
[![Travis](https://travis-ci.org/jansenfelipe/loggi-php.svg?branch=master)](https://travis-ci.org/jansenfelipe/loggi-php)


Abstraction layer PHP to integrate with a Loggi API.

Read More https://docs.api.loggi.com/docs

## HowTo Use

First, install library:

```ssh
$ composer require jansenfelipe/loggi-php
```

Just instantiate the resource you want to consume. 

In the example below I'm looking for all the Shops:

```php
<?php

use JansenFelipe\LoggiPHP\Presto\ShopResource;
use JansenFelipe\LoggiPHP\Presto\OrderResource;
use JansenFelipe\LoggiPHP\Presto\Entities\LocationEntity;

$shopResource = new ShopResource();

$result = $shopResource->all();

foreach ($result as $shop) {
    
    echo $shop->id;
    echo $shop->pk;
    echo $shop->name;
}

/*
 * Now, I will estimate the price to deliver at a certain point
 */

$from = $result[0]; //Get a first shop

$orderResource = new OrderResource();

$to = new LocationEntity();
$to->latitude = -19.8579253;
$to->longitude = -43.94522380000001;

$result = $orderResource->estimation($from, $to);

echo 'Estimated price: '. $result->price;

```

## Setup

The above example assumes that the environment variables `LOGGI_API_URL`, `LOGGI_API_EMAIL` and `LOGGI_API_KEY` are configured.

By default, the request will be sent in the production environment.

If you want, you can instantiate the `LoggiClient` manually and inject into the resource. 

For example:

```php
<?php

use JansenFelipe\LoggiPHP\Presto\ShopResource;
use JansenFelipe\LoggiPHP\LoggiClient;

$client = new LoggiClient(LoggiClient::SANDBOX, 'my-email@gmail.com', 'my-key-api');

$shopResource = new ShopResource($client);

```

## Available resources

* Presto
    * ShopResource
        * all() : ShopEntity[]
    * OrderResource
        * estimation(from:ShopEntity, to:LocationEntity) : EstimateEntity
        
## Entities

* Presto
    * [ShopEntity](https://github.com/jansenfelipe/loggi-php/blob/master/src/Presto/Entities/ShopEntity.php)
    * [LocationEntity](https://github.com/jansenfelipe/loggi-php/blob/master/src/Presto/Entities/LocationEntity.php)
    * [EstimateEntity](https://github.com/jansenfelipe/loggi-php/blob/master/src/Presto/Entities/EstimateEntity.php)

## Standalone

You can run a query without using resources. Just call the `executeQuery($query)` method of the `LoggiClient` class.

For example, let's look at all the cities where Loggi operates:

```php
<?php

use JansenFelipe\LoggiPHP\LoggiClient;
use JansenFelipe\LoggiPHP\Query;

$client = new LoggiClient(LoggiClient::SANDBOX, 'my-email@gmail.com', 'my-key-api');

$query = new Query([
    'allCities' => [
        'edges' => [
            'node' => ['pk', 'name', 'slug']
        ]
    ]
]);

$response = $client->executeQuery($query);

```

## License

The MIT License (MIT)
