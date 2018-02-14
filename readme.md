# LoggiPHP

Abstraction layer PHP to integrate with a Loggi API.

Read More https://api.loggi.com/introduction/welcome

## HowTo Use

Just instantiate the resource you want to consume. 

In the example below I'm looking for all the Shops:

```php
<?php

use JansenFelipe\LoggiPHP\Presto\ShopResource;

$shopResource = new ShopResource();

$result = $shopResource->all();

foreach ($result as $shop) {
    
    echo $shop->id;
    echo $shop->pk;
    echo $shop->name;
}

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

### Available resources

* Presto
    * ShopResource
        * all() : ShopEntity[]
    * OrderResource
        * estimation(from:ShopEntity, to:LocationEntity) : EstimateEntity
        
### Entities

* Presto
    * ShopEntity
    * LocationEntity
    * EstimateEntity

### License

The MIT License (MIT)