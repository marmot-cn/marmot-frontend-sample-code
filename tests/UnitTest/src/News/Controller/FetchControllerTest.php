<?php
namespace News\Controller;

use Marmot\Framework\Classes\Request;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use Sdk\News\Model\News;
use Sdk\News\Model\NullNews;
use News\Utils\ObjectGenerate;
use Sdk\News\Repository\NewsRepository;

class FetchControllerTest extends TestCase
{
    private $stub;
    
    private $request;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(TestFetchController::class)
            ->setMethods(
                [
                    'getRequest',
                    'getNews',
                    'getNewsInputWidgetRules'
                ]
            )->getMock();

        $this->request = $this->prophesize(Request::class);
    }

    public function tearDown()
    {
        unset($this->stub);
    }

    public function testCorrectExtendsController()
    {
        $controller = new FetchController();
        $this->assertInstanceof('Marmot\Framework\Classes\Controller', $controller);
    }

    public function testCorrectImplementsIFetchAbleController()
    {
        $controller = new FetchController();
        $this->assertInstanceof('Common\Controller\Interfaces\IFetchAbleController', $controller);
    }

    public function testGetRepository()
    {
        $this->assertInstanceof(
            'Sdk\News\Repository\NewsRepository',
            $this->stub->getRepository()
        );
    }

    public function testFilterActionSuccess()
    {
        $this->stub = $this->getMockBuilder(TestFetchController::class)
            ->setMethods(
                [
                    'getPageAndSize',
                    'filterFormatChange',
                    'getRequest',
                    'getRepository',
                    'render'
                ]
            )->getMock();

        $search[0] = 'name';
        $request = $this->prophesize(Request::class);
        $request->get(Argument::exact('search'), Argument::exact(array()))
            ->shouldBeCalledTimes(1)
            ->willReturn($search);
        $this->stub->expects($this->any())
            ->method('getRequest')
            ->willReturn($request->reveal());

        $page = 1;
        $size = 10;
        $this->stub->expects($this->exactly(1))
            ->method('getPageAndSize')
            ->willReturn([$size, $page]);

        $sort = ['-updateTime'];
        $filter['title'] = $search[0];
        $this->stub->expects($this->exactly(1))
            ->method('filterFormatChange')
            ->with($search)
            ->willReturn([$filter, $sort]);

        $newsList = array(1,2);
        $count = 2;
        $repository = $this->prophesize(NewsRepository::class);
        $repository->scenario(Argument::exact(NewsRepository::LIST_MODEL_UN))
            ->shouldBeCalledTimes(1)
            ->willReturn($repository->reveal());
        $repository
            ->search(
                Argument::exact($filter),
                Argument::exact($sort),
                Argument::exact($page),
                Argument::exact($size)
            )
            ->shouldBeCalledTimes(1)
            ->willReturn([$count, $newsList]);

        $this->stub->expects($this->exactly(1))
            ->method('getRepository')
            ->willReturn($repository->reveal());

        $this->stub->expects($this->exactly(1))
            ->method('render');

        $result = $this->stub->filterAction();
        $this->assertTrue($result);
    }

    public function testFetchOneActionNullFailure()
    {
        $id = 1;
        $this->stub = $this->getMockBuilder(TestFetchController::class)
            ->setMethods(
                [
                    'getRepository'
                ]
            )->getMock();

        $news = new NullNews();

        $repository = $this->prophesize(NewsRepository::class);
        $repository->scenario(Argument::exact(NewsRepository::FETCH_ONE_MODEL_UN))
            ->shouldBeCalledTimes(1)
            ->willReturn($repository->reveal());

        $repository
            ->fetchOne(Argument::exact($id))
            ->shouldBeCalledTimes(1)
            ->willReturn($news);

        $this->stub->expects($this->exactly(1))
            ->method('getRepository')
            ->willReturn($repository->reveal());

        $result = $this->stub->fetchOneAction($id);
        $this->assertFalse($result);
    }

    public function testFetchOneActionSuccess()
    {
        $id = 1;
        $this->stub = $this->getMockBuilder(TestFetchController::class)
            ->setMethods(
                [
                    'getRepository',
                    'render'
                ]
            )->getMock();

        $news = ObjectGenerate::generateNews($id);

        $repository = $this->prophesize(NewsRepository::class);
        $repository->scenario(Argument::exact(NewsRepository::FETCH_ONE_MODEL_UN))
            ->shouldBeCalledTimes(1)
            ->willReturn($repository->reveal());

        $repository
            ->fetchOne(Argument::exact($id))
            ->shouldBeCalledTimes(1)
            ->willReturn($news);

        $this->stub->expects($this->exactly(1))
            ->method('getRepository')
            ->willReturn($repository->reveal());

        $this->stub->expects($this->exactly(1))
            ->method('render');

        $result = $this->stub->fetchOneAction($id);
        $this->assertTrue($result);
    }

    public function testFilterFormatChange()
    {
        $search[0] = 'name';
        $sort = ['-updateTime'];
        $filter = array();

        $filter['title'] = $search[0];
        $expected = [$filter, $sort];
        $result = $this->stub->filterFormatChange($search);
        $this->assertEquals($expected, $result);
    }
}
