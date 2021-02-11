<?php


use App\Entity\Appartment;
use App\Entity\AppartmentPricing;
use App\Exception\BusinessLogicException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints\DateTime;

class AppartmentTests extends TestCase
{
    /**
     * @dataProvider testSetNumberOfRooms_ShouldThrowException_Data
     */
    public function testSetNumberOfRooms_ShouldThrowException($input)
    {
        $this->expectException(BusinessLogicException::class);

        $appartment = new Appartment();
        $appartment->setNumberOfRooms($input);

    }

    public function testSetNumberOfRooms_ShouldThrowException_Data(): array
    {
        return [
            [0],
            [-1]
        ];
    }
}