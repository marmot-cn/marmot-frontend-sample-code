<?php
namespace Common\Controller\Factory;

use PHPUnit\Framework\TestCase;

class EnableControllerFactoryTest extends TestCase
{
    public function testNullEnableController()
    {
        $controller = EnableControllerFactory::getEnableController('not exist');
        $this->assertInstanceOf('Common\Controller\NullEnableController', $controller);
    }

    public function testNewsEnableController()
    {
        $controller = EnableControllerFactory::getEnableController('news');
        $this->assertInstanceOf('News\Controller\EnableController', $controller);
    }
}
