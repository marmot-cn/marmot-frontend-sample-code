<?php
namespace Common\Controller\Traits;

use PHPUnit\Framework\TestCase;

use Marmot\Framework\Classes\Request;

class OperatControllerTraitTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(TestOperatController::class)
        ->setMethods(
            [
                'getRequest',
                'addView',
                'addAction',
                'editView',
                'editAction',
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
    public function testAddView($action, $expected)
    {
        $request = $this->prophesize(Request::class);

        $request->isGetMethod()->shouldBeCalledTimes(1)->willReturn(true);

        $this->stub->expects($this->any())->method('getRequest')->willReturn($request->reveal());

        $this->stub->expects($this->exactly(1))
            ->method('addView')
            ->will($this->returnValue($action));

        $result =$this->stub->add();

        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testAddAction($action, $expected)
    {
        $request = $this->prophesize(Request::class);

        $request->isGetMethod()->shouldBeCalledTimes(1)->willReturn(false);

        $this->stub->expects($this->any())->method('getRequest')->willReturn($request->reveal());

        $this->stub->expects($this->exactly(1))
            ->method('addAction')
            ->will($this->returnValue($action));

        $result =$this->stub->add();

        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testEditView($action, $expected)
    {
        $id = 1;
        $request = $this->prophesize(Request::class);

        $request->isGetMethod()->shouldBeCalledTimes(1)->willReturn(true);

        $this->stub->expects($this->any())->method('getRequest')->willReturn($request->reveal());

        $this->stub->expects($this->exactly(1))
            ->method('editView')
            ->with($id)
            ->will($this->returnValue($action));

        $result =$this->stub->edit($id);

        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testEditAction($action, $expected)
    {
        $id = 1;
        $request = $this->prophesize(Request::class);

        $request->isGetMethod()->shouldBeCalledTimes(1)->willReturn(false);

        $this->stub->expects($this->any())->method('getRequest')->willReturn($request->reveal());

        $this->stub->expects($this->exactly(1))
            ->method('editAction')
            ->with($id)
            ->will($this->returnValue($action));

        $result =$this->stub->edit($id);

        $this->assertEquals($expected, $result);
    }

    public function dataProvider()
    {
        return [
            [false, false],
            [true, true]
        ];
    }
}
