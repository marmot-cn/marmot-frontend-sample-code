<?php
namespace Common\Controller;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use Common\Controller\Interfaces\IFetchAbleController;

use WidgetRules\Common\UrlWidgetRules;

class FetchControllerTest extends TestCase
{
    private $controller;

    private $childController;

    public function setUp()
    {
        $this->controller = $this->getMockBuilder(FetchController::class)
                          ->setMethods(['getFetchController','displayError'])
                          ->getMock();

        $this->childController = new class extends FetchController
        {
            public function getFetchController(string $resource) : IFetchAbleController
            {
                return parent::getFetchController($resource);
            }
            
            public function getUrlWidgetRules() : UrlWidgetRules
            {
                return parent::getUrlWidgetRules();
            }
        };
    }

    public function tearDown()
    {
        unset($this->controller);
        unset($this->childController);
    }

    public function testGetFetchController()
    {
        $resource = 'members';
        $this->assertInstanceOf(
            'Common\Controller\Interfaces\IFetchAbleController',
            $this->childController->getFetchController($resource)
        );
    }

    public function testGetUrlWidgetRules()
    {
        $this->assertInstanceOf(
            'WidgetRules\Common\UrlWidgetRules',
            $this->childController->getUrlWidgetRules()
        );
    }

    public function testFilter()
    {
        $resource = 'test';

        $fetchController = $this->prophesize(IFetchAbleController::class);
        $fetchController->filter()->shouldBeCalledTimes(1);

        $this->controller->expects($this->once())
                         ->method('getFetchController')
                         ->with($resource)
                         ->willReturn($fetchController->reveal());

        $this->controller->filter($resource);
    }

    public function testFetchOneValidId()
    {
        $resource = 'test';
        $id = marmot_encode(1);

        $fetchController = $this->prophesize(IFetchAbleController::class);
        $fetchController->fetchOne(Argument::exact(marmot_decode($id)))->shouldBeCalledTimes(1);

        $this->controller->expects($this->once())
                         ->method('getFetchController')
                         ->with($resource)
                         ->willReturn($fetchController->reveal());
        $this->controller->expects($this->exactly(0))
                         ->method('displayError');

        $this->controller->fetchOne($resource, $id);
    }

    public function testFetchOneInvalidId()
    {
        $resource = 'test';
        $id = 1;

        $fetchController = $this->prophesize(IFetchAbleController::class);
        $fetchController->fetchOne(Argument::exact($id))->shouldBeCalledTimes(0);

        $this->controller->expects($this->exactly(0))
                         ->method('getFetchController')
                         ->with($resource)
                         ->willReturn($fetchController->reveal());
        $this->controller->expects($this->exactly(1))
                         ->method('displayError');

        $this->controller->fetchOne($resource, $id);
    }
}
