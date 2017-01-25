<?php

namespace Test;

use Nette;
use Tester;
use Tester\Assert;

$container = require __DIR__ . '/bootstrap.php';

class ComplexAddProductToBasketTest extends Tester\TestCase
{
    const HOMEPAGE_URL = 'http://www.currys.co.uk/';

    private $container;

    function __construct(Nette\DI\Container $container)
    {
        $this->container = $container;
    }

    public function tearDown()
    {
        DriverFactory::tearDown();
    }

    public function usedDriverTypes()
    {
        return [
            [ DriverFactory::DESKTOP ],
            [ DriverFactory::TABLET ],
            [ DriverFactory::MOBILE ],
        ];
    }

    /**
     * @dataProvider usedDriverTypes
     */
    function testComplexAddProductToBasket($driverType)
    {
        $driver = DriverFactory::create($driverType);

        $driver->get(self::HOMEPAGE_URL);

        (new PageObject\Homepage($driver))
            ->selectRandomCategory()
            ->selectRandomProduct()
            ->getProductId($selectedProductId)
            ->addToBasket()
            ->getProductsInBasket($productsInBasket);

        $driver->quit();

        Assert::count(1, $productsInBasket);
        Assert::same($selectedProductId, $productsInBasket[0]);
    }
}

$test = new ComplexAddProductToBasketTest($container);
$test->run();
