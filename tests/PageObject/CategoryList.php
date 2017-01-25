<?php

namespace Test\PageObject;

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy as By;
use Facebook\WebDriver\WebDriverElement;
use Facebook\WebDriver\WebDriverWait;
use Facebook\WebDriver\WebDriverExpectedCondition;

class CategoryList
{
    private $driver;

    private $elements;

    function __construct(RemoteWebDriver $driver)
    {
        $this->driver = $driver;

        $productSelector = 'div.resultGrid > article.product > div.desc > a';

        $this->driver->wait(10, 500)->until(
            WebDriverExpectedCondition::elementToBeClickable(
                By::cssSelector($productSelector)
            )
        );

        $this->elements = $this->driver->findElements(
            By::cssSelector($productSelector)
        );

        if (count($this->elements) == 0)
        {
            throw new \RuntimeException("Category page is missing products, are we on the right page?");
        }
    }


    function selectRandomProduct()
    {
        $this->driver->findElement(
            By::cssSelector('div.resultGrid > article.product:nth-child('.rand(1, count($this->elements)).'n) > div.desc > a')
        )->click();

        return new ProductDetail($this->driver);
    }
}
