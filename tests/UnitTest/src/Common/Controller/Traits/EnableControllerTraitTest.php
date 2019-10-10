<?php
namespace Common\Controller\Traits;

use PHPUnit\Framework\TestCase;

class EnableControllerTraitTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(TestEnableController::class)
        ->setMethods(
            [
                'enableAction',
                'disableAction',
                'displayError',
                'displaySuccess'
            ]
        )->getMock();
    }

    public function tearDown()
    {
        unset($this->stub);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testEnable($action, $expected)
    {
        $id = 1;

        $this->stub->expects($this->exactly(1))
            ->method('enableAction')
            ->with($id)
            ->will($this->returnValue($action));

        if ($expected) {
            $this->stub->expects($this->exactly(1))
                 ->method('displaySuccess');
        } else {
            $this->stub->expects($this->exactly(1))
                 ->method('displayError');
        }

        $this->stub->enable($id);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testDisable($action, $expected)
    {
        $id = 1;

        $this->stub->expects($this->exactly(1))
            ->method('disableAction')
            ->with($id)
            ->will($this->returnValue($action));

        if ($expected) {
            $this->stub->expects($this->exactly(1))
                 ->method('displaySuccess');
        } else {
            $this->stub->expects($this->exactly(1))
                 ->method('displayError');
        }

        $this->stub->disable($id);
    }

    public function dataProvider()
    {
        return [
            [false, false],
            [true, true]
        ];
    }
}
