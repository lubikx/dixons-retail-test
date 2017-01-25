Dixons Retail Testing Task
==========================

This is a simple project that tests one of Dixons Retail eshop platforms for add product to basket scenario.

Assignment text (as provided by head hunter)
============================================

Adding items to basket is critical functionality for e-shop and it must work in every case. It must work on our all three different layouts (desktop, tablet, mobile) as well.
You’ve got testing procedure from our testing architect:

- Access our webpage on `http://www.currys.co.uk/` address
- Hover `Computing` category - category listing should become visible
- Choose random subcategory from `iPad, Tablets & eReaders` category and click on it
- Choose random product from this category and add it into the basket
- Verify that item has been added into basket properly

This testing procedure must be written in PHP language and using Page Object Design Pattern.
Please prepare all necessary Page Objects which will be working on all layouts. Switching between these layouts should be “easy”. We are plan running this test in all three modes during every run.

Requirements
------------

PHP 5.3.1 or higher
Composer
Selenium Server
Chrome driver

Running
-------

Checkout this repository and run:

    composer install

Make directories `temp/` and `log/` writable.

You must have Selenium Server listening on port 4444 on localhost. You can simply start Selenium Server by running:
    
    java -jar selenium-server-standalone-3.0.1.jar

This project uses Chrome driver so `chromedriver.exe` must be in the same directory as Selenium Server.

Running test suite is easy, just run this command in project root:

    vendor/bin/tester -c tests/php.ini tests

Out of scope problems
=====================

As this is just a simple assignment from head hunter, I haven't given it thorough foundation.

Here is a list of tasks that should be solved before running this solution live:
- Sometimes a questionaire is shown and that makes the test case fail
- Product that is chosen randomly might not be in stock and as such cannot be put into basket


License
-------
- New BSD License or GPL 2.0 or 3.0

