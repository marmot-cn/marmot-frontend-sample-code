<?php
namespace Common\Controller\Traits;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use Marmot\Framework\Classes\Request;

class FetchControllerTraitTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(TestFetchController::class)
        ->setMethods(
            [
                'getRequest',
                'filterAction',
                'fetchOneAction',
                'displayError',
                'displaySuccess'
            ]
        )->getMock();
    }

    public function tearDown()
    {
        unset($this->stub);
    }

    public function testGetPageAndSize()
    {
        $size = 10;
        $page = 1;

        $request = $this->prophesize(Request::class);

        $request->get(Argument::exact('limit'), Argument::exact(10))
                ->shouldBeCalledTimes(1)
               ->willReturn($size);

        $request->get(Argument::exact('page'), Argument::exact(1))
            ->shouldBeCalledTimes(1)
            ->willReturn($page);

        $this->stub->expects($this->any())
            ->method('getRequest')
            ->willReturn($request->reveal());

        $result = $this->stub->getPageAndSize();

        $this->assertEquals([$size, $page], $result);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testFilter($action, $expected)
    {
        $this->stub->expects($this->exactly(1))
            ->method('filterAction')
            ->will($this->returnValue($action));

        if (!$expected) {
            $this->stub->expects($this->exactly(1))
                 ->method('displayError');
        }

        $this->stub->filter();
    }

    /**
     * @dataProvider dataProvider
     */
    public function testFetchOne($action, $expected)
    {
        $id = 1;

        $this->stub->expects($this->exactly(1))
            ->method('fetchOneAction')
            ->with($id)
            ->will($this->returnValue($action));

        if (!$expected) {
            $this->stub->expects($this->exactly(1))
                 ->method('displayError');
        }

        $this->stub->fetchOne($id);
    }

    public function dataProvider()
    {
        return [
            [false, false],
            [true, true]
        ];
    }
}
