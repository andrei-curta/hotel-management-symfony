<?php

namespace App\Tests\Entity;

use App\Entity\Appartment;
use PHPUnit\Framework\TestCase;

class AppartmentTest extends TestCase
{

    /**
     * @dataProvider setNumberOfRoomsData
     */
    public function testSetNumberOfRooms($input)
    {
        $appartment = new Appartment();
        $appartment->setNumberOfRooms($input);

        $this->assertEquals($appartment->getNumberOfRooms(), $input);
    }

    public function setNumberOfRoomsData()
    {
        return [
            [1], [100]
        ];
    }
}
