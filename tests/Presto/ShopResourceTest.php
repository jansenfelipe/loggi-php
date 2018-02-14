<?php

namespace JansenFelipe\LoggiPHP\Tests\Presto;

use JansenFelipe\LoggiPHP\Contracts\ClientGraphQLContract;
use JansenFelipe\LoggiPHP\Presto\Entities\ShopEntity;
use JansenFelipe\LoggiPHP\Presto\ShopResource;
use PHPUnit_Framework_TestCase;

class ShopResourceTest extends PHPUnit_Framework_TestCase
{
    public function testAll()
    {
        $clientGraphQL = $this->getMockBuilder(ClientGraphQLContract::class)->getMock();

        $clientGraphQL->method('executeQuery')->willReturn([
            'allShops' => [
                'edges' => [
                    [
                        'node' => [
                            'id' => '8923ue82u=',
                            'pk' => 1234,
                            'name' => 'Shop Name'
                        ]
                    ]
                ]
            ]
        ]);

        $shopResource = new ShopResource($clientGraphQL);

        $result = $shopResource->all();

        $this->assertInstanceOf(ShopEntity::class, $result[0]);
        $this->assertEquals('8923ue82u=', $result[0]->id);
        $this->assertEquals(1234, $result[0]->pk);
        $this->assertEquals('Shop Name', $result[0]->name);
    }
}