<?php

namespace JansenFelipe\LoggiPHP\Presto;

use JansenFelipe\LoggiPHP\LoggiClient;
use JansenFelipe\LoggiPHP\Contracts\ClientGraphQLContract;
use JansenFelipe\LoggiPHP\Presto\Entities\ShopEntity;
use JansenFelipe\LoggiPHP\Query;

class ShopResource
{
    /**
     * @var ClientGraphQLContract
     */
    private $client;

    /**
     * ShopResource constructor.
     * @param ClientGraphQLContract|null $client
     */
    function __construct(ClientGraphQLContract $client = null)
    {
        if(is_null($client))
            $client = new LoggiClient();

        $this->client = $client;
    }

    /**
     * Get all Shops
     *
     * @return array
     */
    public function all()
    {
        $result = [];

        $query = new Query([
            'allShops' => [
                'edges' => [
                    'node' => ['id', 'name', 'pk']
                ]
            ]
        ]);

        $response = $this->client->executeQuery($query);

        foreach ($response['allShops']['edges'] as $row) {

            $shop = new ShopEntity();
            $shop->id = $row['node']['id'];
            $shop->pk = $row['node']['pk'];
            $shop->name = $row['node']['name'];

            $result[] = $shop;
        }

        return $result;
    }
}