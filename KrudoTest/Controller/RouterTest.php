<?php

use PHPUnit\Framework\TestCase;
include("./appConfiguration.php");

class RouterTest extends TestCase
{

    /**
     * Tests setting a route in Router class from configuration
     *
     * @return void
     */
    public function testSetRouteConfig(): void
    {
        $router = new Controller\Router();
        $this->assertEquals(
            include("./Krudo/routesConfiguration.php"),
            $router->setRoutes()->getRoutes()
        );
    }

    /**
     * Tests setting a pathName property in Router class
     *
     * @return void
     */
    public function testSetPathName(): void
    {
        $router = new Controller\Router();
        $setPathName = "test-path";
        $router->setPathName($setPathName);
        $this->assertEquals(
            $setPathName,
            $router->getPathName()
        );
    }

}
