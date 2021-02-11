<?php
namespace App\Tests\Utils;

use App\Utils\OrderFactory;
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use App\Entity\OrderStatus;
use App\Entity\User;
use App\Entity\Product;
use App\Repository\OrderStatusRepository;

class OrderFactoryTest extends TestCase
{
    private $entityManager;
    private $security;

    public function testCreate()
    {
        // Arrange
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $security = $this->createMock(Security::class);
        $orderStatusRepository = $this->createMock(OrderStatusRepository::class);

        $user = new User();
        $user->setemail("test.user@gamil.com");

        $security->expects($this->any())
            ->method('getUser')
            ->willReturn($user);

        $orderStatus = new OrderStatus();
        $orderStatus->setStatus("In cart");

        $orderStatusRepository->expects($this->any())
            ->method('findOneBy')
            ->willReturn($orderStatus);

        $entityManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($orderStatusRepository);

        $date = new \DateTime();

        // Act
        $orderFactory = new OrderFactory($entityManager, $security);
        $order = $orderFactory->create();

        // Assert
        $this->assertEquals("In cart", $order->getOrderStatus()->getStatus());
        $this->assertEquals($date->format('d/m/Y'), $order->getDate()->format('d/m/Y'));
        $this->assertequals("test.user@gamil.com", $order->getUser()->getEmail());
    }

    public function testCreateItem()
    {
        // Arrange
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $security = $this->createMock(Security::class);
        $orderStatusRepository = $this->createMock(OrderStatusRepository::class);

        $product = new Product();
        $product->setName("Double Dresser");

        // Act
        $orderFactory = new OrderFactory($entityManager, $security);
        $orderItem = $orderFactory->createItem($product);

        // Assert
        $this->assertEquals("Double Dresser", $orderItem->getProduct()->getName());
        $this->assertEquals(1, $orderItem->getQuantity());
    }
}