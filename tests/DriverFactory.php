<?php

namespace Test;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;

class DriverFactory
{
    const MOBILE = 'mobile';
    const TABLET = 'tablet';
    const DESKTOP = 'desktop';

    const SELENIUM_HOST = 'http://localhost:4444/wd/hub';

    const DEVICE_NAME_TABLET = 'Apple iPad';
    const DEVICE_NAME_MOBILE = 'Apple iPhone 5';

    private static $createdDrivers = [];

    public static function create($driverType)
    {
        $options = new ChromeOptions();
        $options->addArguments(["--start-maximized"]);

        switch ($driverType)
        {
            case self::TABLET:
                $options->setExperimentalOption('mobileEmulation', [ "deviceName" => self::DEVICE_NAME_TABLET ]);
                break;

            case self::MOBILE:
                $options->setExperimentalOption('mobileEmulation', [ "deviceName" => self::DEVICE_NAME_MOBILE ]);
                break;

            case self::DESKTOP:
                break;

            default:
                throw new \RuntimeException("Unknown driver type: {$driverType}");
        }

        $capabilities = DesiredCapabilities::chrome();
        $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);

        $driver = RemoteWebDriver::create(self::SELENIUM_HOST, $capabilities);
        $driver->driverType = $driverType;
        
        self::$createdDrivers[] = $driver;

        return $driver;
    }

    public static function tearDown()
    {
        foreach (self::$createdDrivers as $driver)
        {
            $driver->quit();
        }
    }
}
