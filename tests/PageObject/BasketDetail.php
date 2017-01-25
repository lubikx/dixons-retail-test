<?php

namespace Test\PageObject;

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy as By;
use Facebook\WebDriver\WebDriverElement;
use Facebook\WebDriver\WebDriverWait;
use Facebook\WebDriver\WebDriverExpectedCondition;

class BasketDetail
{
    private $driver;

    private $elements;

    function __construct(RemoteWebDriver $driver)
    {
        $this->driver = $driver;

        if ($this->driver->getTitle() != 'Your basket | Currys')
        {
            throw new \RuntimeException("This is not the basket contents page (title doesn't match)");
        }

        $productInBasketSelector = 'section.orderItem';

        $this->driver->wait(10, 500)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(
                By::cssSelector($productInBasketSelector)
            )
        );
    }

    function getProductsInBasket(&$products)
    {
        $productInBasketSelector = 'section.orderItem';

        $elements = $this->driver->findElements(
            By::cssSelector($productInBasketSelector)
        );

        $products = [];

        foreach ($elements as $e)
        {
            if (($id = substr($e->getAttribute('id'), strlen('product'))) !== FALSE)
            {
                $products[] = $id;
            }
        }

        return $this;
    }
}
