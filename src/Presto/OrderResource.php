<?php

namespace JansenFelipe\LoggiPHP\Presto;

use JansenFelipe\LoggiPHP\Exceptions\ResponseException;
use JansenFelipe\LoggiPHP\LoggiClient;
use JansenFelipe\LoggiPHP\Contracts\ClientGraphQLContract;
use JansenFelipe\LoggiPHP\Presto\Entities\EstimateEntity;
use JansenFelipe\LoggiPHP\Presto\Entities\LocationEntity;
use JansenFelipe\LoggiPHP\Presto\Entities\ShopEntity;
use JansenFelipe\LoggiPHP\Query;

class OrderResource
{
    /**
     * @var ClientGraphQLContract
     */
    private $client;

    /**
     * OrderResource constructor.
     * @param ClientGraphQLContract|null $client
     */
    function __construct(ClientGraphQLContract $client = null)
    {
        if(is_null($client))
            $client = new LoggiClient();

        $this->client = $client;
    }

    /**
     * Estimate Cost
     *
     * @return EstimateEntity
     */
    public function estimation(ShopEntity $from, LocationEntity $to)
    {
        $query = new Query([
            'estimate(shopId: '.$from->id.', packagesDestination: [{lat: '.$to->latitude.', lng: '.$to->longitude.'}])' => [
                'packages' =>  [
                    'error'
                ],
                'normal' =>  [
                    'cost',
                    'distance',
                    'eta'
                ]
            ]
        ]);

        $response = $this->client->executeQuery($query);

        if(!isset($response['estimate']))
            throw new ResponseException('Estimate not found.');

        if(isset($response['estimate']['packages'][0]['error']))
            throw new ResponseException($response['estimate']['packages'][0]['error']);

        $estimate = new EstimateEntity();

        $estimate->price = $response['estimate']['normal']['cost'];

        return $estimate;
    }
}