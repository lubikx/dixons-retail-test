<?php

namespace Test\PageObject;

use Test\DriverFactory;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy as By;
use Facebook\WebDriver\WebDriverElement;
use Facebook\WebDriver\WebDriverWait;
use Facebook\WebDriver\WebDriverExpectedCondition;

class Homepage
{
    private $driver;

    function __construct(RemoteWebDriver $driver)
    {
        $this->driver = $driver;

        if ($this->driver->getTitle() != 'Currys | TVs, Washing Machines, Cookers, Cameras, Tablets')
        {
            throw new \RuntimeException("This is not the homepage (title doesn't match)");
        }

        $selector = 'i.icon-reorder';

        if ($this->driver->driverType == 'desktop')
        {
            $selector = '#desktop-nav a[data-di-id="di-id-b732b89e-c866d4be"]';
        }

        $this->driver->wait(10, 500)->until(
            WebDriverExpectedCondition::elementToBeClickable(
                By::cssSelector($selector)
            )
        );          

    }

    private function selectRandomCategoryDesktop()
    {
        $computingDiv = $this->driver->findElement(
            By::cssSelector('#desktop-nav a[data-di-id="di-id-b732b89e-c866d4be"]')
        );

        $this->driver->getMouse()->mouseMove( $computingDiv->getCoordinates() );

        $childMenuSelector = '#desktop-nav a[data-di-id="di-id-467205a1-f1ff1470"] +ul > li';
        $this->driver->wait(10, 500)->until(
            WebDriverExpectedCondition::elementToBeClickable(
                By::cssSelector($childMenuSelector)
            )
        );

        $elements = $this->driver->findElements(
            By::cssSelector($childMenuSelector)
        );

        // -2, protoze posledni 2 kategorie nelistuji produkty
        $this->driver->findElement(
            By::cssSelector('#desktop-nav a[data-di-id="di-id-467205a1-f1ff1470"] +ul > li:nth-child('.rand(1, count($elements)-2).'n) > a')
        )->click();

        return new \Test\PageObject\CategoryList($this->driver);
    }

    private function selectRandomCategoryTouch()
    {
        $menuSelector = 'i.icon-reorder';

        $this->driver->wait(10, 500)->until(
            WebDriverExpectedCondition::elementToBeClickable(
                By::cssSelector($menuSelector)
            )
        );

        $this->driver->findElement(
            By::cssSelector($menuSelector)
        )->click();

        usleep(500000); // TODO: vymyslet jinak, ale Selenium aktualne neumi cekat na dokonceni efektu

        // ------------------------------------------------------------------------------------------------
        // computing
        $childMenuSelector = 'div.touch a[data-di-id="di-id-d9838d15-d1f7a384"]';
        $this->driver->wait(10, 500)->until(
            WebDriverExpectedCondition::elementToBeClickable(
                By::cssSelector($childMenuSelector)
            )
        );

        $this->driver->findElement(
            By::cssSelector($childMenuSelector)
        )->click();

        usleep(500000); // TODO: vymyslet jinak, ale Selenium aktualne neumi cekat na dokonceni efektu

        // ------------------------------------------------------------------------------------------------
        // ipad, tablets...
        $childMenuSelector = 'div.touch a[data-di-id="di-id-8f90f3b4-fff42e39"]';
        $this->driver->wait(10, 500)->until(
            WebDriverExpectedCondition::elementToBeClickable(
                By::cssSelector($childMenuSelector)
            )
        );

        $this->driver->findElement(
            By::cssSelector($childMenuSelector)
        )->click();

        usleep(500000); // TODO: vymyslet jinak, ale Selenium aktualne neumi cekat na dokonceni efektu

        // ------------------------------------------------------------------------------------------------
        $childMenuSelector = 'div.touch a[data-di-id="di-id-8f90f3b4-fff42e39"] +ul li';
        $this->driver->wait(10, 500)->until(
            WebDriverExpectedCondition::elementToBeClickable(
                By::cssSelector($childMenuSelector)
            )
        );

        $elements = $this->driver->findElements(
            By::cssSelector($childMenuSelector)
        );

        $this->driver->findElement(
            By::cssSelector('div.touch a[data-di-id="di-id-8f90f3b4-fff42e39"] +ul li:nth-child('.rand(1, count($elements)-2).'n) > a')
        )->click();

        return new \Test\PageObject\CategoryList($this->driver);
    }

    function selectRandomCategory()
    {
        if ($this->driver->driverType == DriverFactory::DESKTOP)
        {
            return $this->selectRandomCategoryDesktop();
        }
        else
        {
            return $this->selectRandomCategoryTouch();
        }
    }
}
