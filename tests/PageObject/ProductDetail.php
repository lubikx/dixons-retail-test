<?php

namespace Test\PageObject;

use Test\DriverFactory;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy as By;
use Facebook\WebDriver\WebDriverElement;
use Facebook\WebDriver\WebDriverWait;
use Facebook\WebDriver\WebDriverExpectedCondition;

class ProductDetail
{
    private $driver;

    private $elements;

    function __construct(RemoteWebDriver $driver)
    {
        $this->driver = $driver;

        $selector = 'div.touch#product-actions-touch button.main-purchase-btn';

        if ($this->driver->driverType == DriverFactory::DESKTOP)
        {
            $selector = 'div.desktop#product-actions button.main-purchase-btn';
        }

        // toto nam zaridi exception pokud jsme na jine strance, pripadne pokud se jedna o produkt, ktery aktualne nelze koupit (coz v zadani tohoto testu neni reseno)
        $this->driver->wait(10, 500)->until(
            WebDriverExpectedCondition::elementToBeClickable(
                By::cssSelector($selector)
            )
        );
    }

    function getProductId(&$productId)
    {
        $selector = 'div.touch#product-actions-touch div[data-productid]';
        if ($this->driver->driverType == DriverFactory::DESKTOP)
        {
            $selector = 'div.desktop div[data-productid]';
        }

        $productDetailDataElement = $this->driver->findElement(
            By::cssSelector($selector)
        );

        $productId = $productDetailDataElement->getAttribute('data-productid');

        return $this;
    }

    function addToBasket()
    {
        $purchaseButtonSelector = 'div.touch#product-actions-touch button.main-purchase-btn';
        $continueToBasketSelector = 'form.touch a.btnShop';

        if ($this->driver->driverType == DriverFactory::DESKTOP)
        {
            $purchaseButtonSelector = 'div.desktop#product-actions button.main-purchase-btn';
            $continueToBasketSelector = '#buttonBuyOrReserve';
        }

        $this->driver->findElement(
            By::cssSelector($purchaseButtonSelector)
        )->click();


        $this->driver->wait(10, 500)->until(
            WebDriverExpectedCondition::elementToBeClickable(
                By::cssSelector($continueToBasketSelector)
            )
        );

        $this->driver->findElement(
            By::cssSelector($continueToBasketSelector)
        )->click();

        return new BasketDetail($this->driver);
    }
}
