<?php

namespace Tests\Feature;

use App\Services\Shipping;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShippingOptionsTest extends TestCase
{

    public function testSameShippingCostAndDeliveryDates()
    {
        $mock = [
            [
                'name' => 'Option 1',
                'type' => 'Delivery',
                'cost' => 10,
                'estimated_days' => 3
            ],
            [
                'name' => 'Option 2',
                'type' => 'Custom',
                'cost' => 10,
                'estimated_days' => 3
            ],
            [
                'name' => 'Option 3',
                'type' => 'Pickup',
                'cost' => 10,
                'estimated_days' => 3
            ]
        ];

        $expected = [
            [
                'name' => 'Option 1',
                'type' => 'Delivery',
                'cost' => 10,
                'estimated_days' => 3
            ],
            [
                'name' => 'Option 2',
                'type' => 'Custom',
                'cost' => 10,
                'estimated_days' => 3
            ],
            [
                'name' => 'Option 3',
                'type' => 'Pickup',
                'cost' => 10,
                'estimated_days' => 3
            ]
        ];

        $response = Shipping::orderOptions($mock);
        $this->assertTrue($this->checkOrder($expected, $response));
    }

    public function testSameShippingCostAndDifferentDeliveryDates()
    {
        $mock = [
            [
                'name' => 'Option 1',
                'type' => 'Delivery',
                'cost' => 10,
                'estimated_days' => 5
            ],
            [
                'name' => 'Option 2',
                'type' => 'Custom',
                'cost' => 10,
                'estimated_days' => 2
            ],
            [
                'name' => 'Option 3',
                'type' => 'Pickup',
                'cost' => 10,
                'estimated_days' => 3
            ]
        ];

        $expected = [
            [
                'name' => 'Option 1',
                'type' => 'Custom',
                'cost' => 10,
                'estimated_days' => 2
            ],
            [
                'name' => 'Option 2',
                'type' => 'Pickup',
                'cost' => 10,
                'estimated_days' => 3
            ],
            [
                'name' => 'Option 3',
                'type' => 'Delivery',
                'cost' => 10,
                'estimated_days' => 5
            ]
        ];

        $response = Shipping::orderOptions($mock);
        $this->assertTrue($this->checkOrder($expected, $response));
    }

    public function testSameDeliveryDatesAndDifferentShippingCost()
    {
        $mock = [
            [
                'name' => 'Option 1',
                'type' => 'Delivery',
                'cost' => 6,
                'estimated_days' => 3
            ],
            [
                'name' => 'Option 2',
                'type' => 'Custom',
                'cost' => 5,
                'estimated_days' => 3
            ],
            [
                'name' => 'Option 3',
                'type' => 'Pickup',
                'cost' => 10,
                'estimated_days' => 3
            ]
        ];

        $expected = [
            [
                'name' => 'Option 1',
                'type' => 'Custom',
                'cost' => 5,
                'estimated_days' => 3
            ],
            [
                'name' => 'Option 2',
                'type' => 'Delivery',
                'cost' => 6,
                'estimated_days' => 3
            ],
            [
                'name' => 'Option 3',
                'type' => 'Pickup',
                'cost' => 10,
                'estimated_days' => 3
            ]
        ];

        $response = Shipping::orderOptions($mock);
        $this->assertTrue($this->checkOrder($expected, $response));
    }

    public function testDifferentDeliveryDatesAndDifferentShippingCost()
    {
        $mock = [
            [
                'name' => 'Option 1',
                'type' => 'Delivery',
                'cost' => 10,
                'estimated_days' => 5
            ],
            [
                'name' => 'Option 2',
                'type' => 'Custom',
                'cost' => 5,
                'estimated_days' => 3
            ],
            [
                'name' => 'Option 3',
                'type' => 'Pickup',
                'cost' => 7,
                'estimated_days' => 2
            ]
        ];

        $expected = [
            [
                'name' => 'Option 1',
                'type' => 'Custom',
                'cost' => 5,
                'estimated_days' => 3
            ],
            [
                'name' => 'Option 2',
                'type' => 'Pickup',
                'cost' => 7,
                'estimated_days' => 2
            ],
            [
                'name' => 'Option 3',
                'type' => 'Delivery',
                'cost' => 10,
                'estimated_days' => 5
            ]
        ];

        $response = Shipping::orderOptions($mock);
        $this->assertTrue($this->checkOrder($expected, $response));
    }

    public function testNoShippingOptionsAvaliable()
    {
        $mock = [];
        $expected = [];

        $response = Shipping::orderOptions($mock);
        $this->assertEmpty($response);
    }

    public function checkOrder($expected, $response)
    {
        foreach ($expected as $index => $ex) {
            if ($ex['cost'] != $response[$index]['cost'] || $ex['type'] != $response[$index]['type'] || $ex['estimated_days'] != $response[$index]['estimated_days']) return false;
        }
        return true;
    }
}
