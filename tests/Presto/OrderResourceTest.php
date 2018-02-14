<?php

namespace JansenFelipe\LoggiPHP\Tests\Presto;

use JansenFelipe\LoggiPHP\Contracts\ClientGraphQLContract;
use JansenFelipe\LoggiPHP\Presto\Entities\EstimateEntity;
use JansenFelipe\LoggiPHP\Presto\Entities\LocationEntity;
use JansenFelipe\LoggiPHP\Presto\Entities\ShopEntity;
use JansenFelipe\LoggiPHP\Presto\OrderResource;
use PHPUnit_Framework_TestCase;

class OrderResourceTest extends PHPUnit_Framework_TestCase
{
    public function testEstimation()
    {
        $clientGraphQL = $this->getMockBuilder(ClientGraphQLContract::class)->getMock();

        $clientGraphQL->method('executeQuery')->willReturn([
            'estimate' => [
                'normal' => [
                    'cost' => 9.9
                ]
            ]
        ]);

        $orderResource = new OrderResource($clientGraphQL);

        $from = new ShopEntity();
        $from->id = 1234;

        $to = new LocationEntity();
        $to->latitude = -19.8579253;
        $to->longitude = -43.94522380000001;

        $result = $orderResource->estimation($from, $to);

        $this->assertInstanceOf(EstimateEntity::class, $result);
        $this->assertEquals(9.9, $result->price);
    }
}