<?php
namespace News\Controller;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;
use Marmot\Framework\Classes\CommandBus;

use News\Command\News\EnableNewsCommand;
use News\Command\News\DisableNewsCommand;

class EnableControllerTest extends TestCase
{
    private $stub;

    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(TestEnableController::class)
                    ->setMethods(['getCommandBus'])
                    ->getMock();

        $this->childStub = new class extends TestEnableController
        {
            public function getCommandBus(): CommandBus
            {
                return parent::getCommandBus();
            }
        };
    }

    public function testGetCommandBus()
    {
        $this->assertInstanceof(
            'Marmot\Framework\Classes\CommandBus',
            $this->childStub->getCommandBus()
        );
    }

    public function tearDown()
    {
        unset($this->stub);
        unset($this->childStub);
    }

    public function testCorrectExtendsController()
    {
        $this->assertInstanceof(
            'Marmot\Framework\Classes\Controller',
            $this->stub
        );
    }

    public function testCorrectImplementsIEnableAbleController()
    {
        $this->assertInstanceof(
            'Common\Controller\Interfaces\IEnableAbleController',
            $this->stub
        );
    }

    public function testEnableAction()
    {
        $command = new EnableNewsCommand(1);

        $commandBus = $this->prophesize(CommandBus::class);
        $commandBus->send(Argument::exact($command))->shouldBeCalledTimes(1)
            ->willReturn(true);
        $this->stub->expects($this->exactly(1))
            ->method('getCommandBus')
            ->willReturn($commandBus->reveal());

        $result = $this->stub->enableAction($command->id);
        $this->assertTrue($result);
    }

    public function testDisableAction()
    {
        $command = new DisableNewsCommand(1);

        $commandBus = $this->prophesize(CommandBus::class);
        $commandBus->send(Argument::exact($command))->shouldBeCalledTimes(1)->willReturn(true);
        $this->stub->expects($this->exactly(1))
            ->method('getCommandBus')
            ->willReturn($commandBus->reveal());

        $result = $this->stub->disableAction($command->id);
        $this->assertTrue($result);
    }
}
