<?php
namespace Common\Controller;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use Marmot\Core;

use Common\Controller\Interfaces\IEnableAbleController;

class EnableControllerTest extends TestCase
{
    private $controller;

    private $resource;

    public function setUp()
    {
        $this->controller = $this->getMockBuilder(EnableController::class)
                                 ->setMethods(['getEnableController','displayError'])
                                 ->getMock();
        Core::setLastError(ERROR_NOT_DEFINED);

        $this->resource = 'tests';
    }

    public function tearDown()
    {
        unset($this->controller);
        unset($this->resource);
        Core::setLastError(ERROR_NOT_DEFINED);
    }

    /**
     * 错误格式id
     * 1. 不调用getEnableController
     * 2. 调用displayError
     */
    public function testEnableInvalidId()
    {
        $id = 1;
        
        $this->invalidExpects($id, 'enable');
        $this->controller->index($this->resource, $id, 'enable');
    }

    public function testEnableValidId()
    {
        $id = marmot_encode(1);

        $this->validExpects(marmot_decode($id), 'enable');
        $this->controller->index($this->resource, $id, 'enable');
    }

    public function testDisableInvalidId()
    {
        $id = 1;

        $this->invalidExpects($id, 'disable');
        $this->controller->index($this->resource, $id, 'disable');
    }

    private function invalidExpects($id, $status)
    {
        $statusController = $this->prophesize(IEnableAbleController::class);
        $statusController->$status(Argument::exact($id))->shouldBeCalledTimes(0);

        $this->controller->expects($this->exactly(0))
                         ->method('getEnableController')
                         ->with($this->resource)
                         ->willReturn($statusController->reveal());

        $this->controller->expects($this->once())
                         ->method('displayError');
    }

    private function validExpects($id, $status)
    {
        $statusController = $this->prophesize(IEnableAbleController::class);
        $statusController->$status(Argument::exact($id))->shouldBeCalledTimes(1);

        $this->controller->expects($this->exactly(1))
                         ->method('getEnableController')
                         ->with($this->resource)
                         ->willReturn($statusController->reveal());

        $this->controller->expects($this->exactly(0))
                         ->method('displayError');
    }
}
