<?php
namespace News\Controller;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use Marmot\Framework\Classes\Request;
use Marmot\Framework\Classes\CommandBus;

use News\View\Template\AddView;
use News\View\Template\EditView;
use News\Command\News\AddNewsCommand;
use News\Command\News\EditNewsCommand;
use Sdk\News\Repository\NewsRepository;

use WidgetRules\News\WidgetRules as NewsWidgetRules;
use WidgetRules\Common\WidgetRules as CommonWidgetRules;

class OperationControllerTest extends TestCase
{
    private $stub;

    private $request;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(TestOperationController::class)
            ->setMethods(
                [
                    'getCommonWidgetRules',
                    'getNewsWidgetRules',
                    'getRequest',
                    'getRepository',
                    'displayError',
                    'displaySuccess',
                    'render'
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
        $controller = new OperationController();
        $this->assertInstanceof('Marmot\Framework\Classes\Controller', $controller);
    }

    public function testCorrectImplementsIOperatAbleController()
    {
        $controller = new OperationController();
        $this->assertInstanceof('Common\Controller\Interfaces\IOperatAbleController', $controller);
    }

    public function testGetCommandBus()
    {
        $this->assertInstanceof(
            'Marmot\Framework\Classes\CommandBus',
            $this->stub->getCommandBus()
        );
    }

    public function testGetCommonWidgetRules()
    {
        $this->assertInstanceof(
            'WidgetRules\Common\WidgetRules',
            $this->stub->getCommonWidgetRules()
        );
    }

    public function testGetNewsWidgetRules()
    {
        $this->assertInstanceof(
            'WidgetRules\News\WidgetRules',
            $this->stub->getNewsWidgetRules()
        );
    }

    public function testGetRepository()
    {
        $this->assertInstanceof(
            'Sdk\News\Repository\NewsRepository',
            $this->stub->getRepository()
        );
    }

    public function testAddView()
    {
        $this->stub->expects($this->exactly(1))
                   ->method('render');

        $result= $this->stub->addView();
        $this->assertTrue($result);
    }

    public function testEditView()
    {
        $id = 1;
        $this->stub = $this->getMockBuilder(TestOperationController::class)
            ->setMethods(
                [
                    'getRepository',
                    'render'
                ]
            )->getMock();

        $news = \News\Utils\ObjectGenerate::generateNews($id);

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

        $result = $this->stub->editView($id);
        $this->assertTrue($result);
    }

    /**
     * @dataProvider operationScenarioProvider
     */
    public function testValidateOperationScenario($expect, $actual)
    {
        $title = 'title';
        $source = 'source';
        $content = 'content';
        $image = array('name'=>'name','identify'=>'identify.jpg');
        $newsType = 1;
        $attachments = array(
            array('name'=>'name','identify'=>'identify.zip')
        );

        $commonWidgetRules = $this->prophesize(CommonWidgetRules::class);
        $newsWidgetRules = $this->prophesize(NewsWidgetRules::class);

        $commonWidgetRules->title(Argument::exact($title))
            ->shouldBeCalledTimes($expect['titleCount'])
            ->willReturn($expect['title']);
        $newsWidgetRules->source(Argument::exact($source))
            ->shouldBeCalledTimes($expect['sourceCount'])
            ->willReturn($expect['source']);
        $newsWidgetRules->content(Argument::exact($content))
            ->shouldBeCalledTimes($expect['contentCount'])
            ->willReturn($expect['content']);
        $commonWidgetRules->image(Argument::exact($image), Argument::exact('image'))
            ->shouldBeCalledTimes($expect['imageCount'])
            ->willReturn($expect['image']);
        $commonWidgetRules->attachments(Argument::exact($attachments))
            ->shouldBeCalledTimes($expect['attachmentsCount'])
            ->willReturn($expect['attachments']);

        $this->stub->expects($this->any())
            ->method('getCommonWidgetRules')
            ->willReturn($commonWidgetRules->reveal());

        $this->stub->expects($this->any())
            ->method('getNewsWidgetRules')
            ->willReturn($newsWidgetRules->reveal());
        $result = $this->stub->validateOperationScenario($title, $source, $content, $image, $attachments);
        $this->assertEquals($actual, $result);
    }

    public function operationScenarioProvider()
    {
        return [
            [
                [
                    'title'=>false,
                    'titleCount'=>1,
                    'source'=>false,
                    'sourceCount'=>0,
                    'content'=>false,
                    'contentCount'=>0,
                    'image'=>false,
                    'imageCount'=>0,
                    'attachments'=>false,
                    'attachmentsCount'=>0
                ],
                false
            ],
            [
                [
                    'title'=>true,
                    'titleCount'=>1,
                    'source'=>false,
                    'sourceCount'=>1,
                    'content'=>false,
                    'contentCount'=>0,
                    'image'=>false,
                    'imageCount'=>0,
                    'attachments'=>false,
                    'attachmentsCount'=>0
                ],
                false
            ],
            [
                [
                    'title'=>true,
                    'titleCount'=>1,
                    'source'=>true,
                    'sourceCount'=>1,
                    'content'=>false,
                    'contentCount'=>1,
                    'image'=>false,
                    'imageCount'=>0,
                    'attachments'=>false,
                    'attachmentsCount'=>0
                ],
                false
            ],
            [
                [
                    'title'=>true,
                    'titleCount'=>1,
                    'source'=>true,
                    'sourceCount'=>1,
                    'content'=>true,
                    'contentCount'=>1,
                    'image'=>false,
                    'imageCount'=>1,
                    'attachments'=>false,
                    'attachmentsCount'=>0
                ],
                false
            ],
            [
                [
                    'title'=>true,
                    'titleCount'=>1,
                    'source'=>true,
                    'sourceCount'=>1,
                    'content'=>true,
                    'contentCount'=>1,
                    'image'=>true,
                    'imageCount'=>1,
                    'attachments'=>false,
                    'attachmentsCount'=>1
                ],
                false
            ],
            [
                [
                    'title'=>true,
                    'titleCount'=>1,
                    'source'=>true,
                    'sourceCount'=>1,
                    'content'=>true,
                    'contentCount'=>1,
                    'image'=>true,
                    'imageCount'=>1,
                    'attachments'=>true,
                    'attachmentsCount'=>1
                ],
                true
            ],
        ];
    }

    private function initialAdd(bool $result)
    {
        $this->stub = $this->getMockBuilder(TestOperationController::class)
            ->setMethods(
                [
                    'getRequest',
                    'displayError',
                    'displaySuccess',
                    'getCommandBus',
                    'validateOperationScenario'
                ]
            )->getMock();

        $title = 'title';
        $source = 'source';
        $publishUserGroup = "MA";
        $publishUserGroupId = 1;
        $content = 'content';
        $image = array('image');
        $attachments = array('attachment1', 'attachment2');

        $request = $this->prophesize(Request::class);
        $request->post(Argument::exact('title'), Argument::exact(''))
                ->shouldBeCalledTimes(1)
                ->willReturn($title);
        $request->post(Argument::exact('source'), Argument::exact(''))
                ->shouldBeCalledTimes(1)
                ->willReturn($source);
        $request->post(Argument::exact('content'), Argument::exact(''))
                ->shouldBeCalledTimes(1)
                ->willReturn($content);
        $request->post(Argument::exact('publishUserGroup'), Argument::exact(''))
                ->shouldBeCalledTimes(1)
                ->willReturn($publishUserGroup);
        $request->post(Argument::exact('image'), Argument::exact(''))
                ->shouldBeCalledTimes(1)
                ->willReturn($image);
        $request->post(Argument::exact('attachments'), Argument::exact(array()))
                ->shouldBeCalledTimes(1)
                ->willReturn($attachments);

        $this->stub->expects($this->exactly(1))
                   ->method('getRequest')
                   ->willReturn($request->reveal());

        $this->stub->expects($this->exactly(1))
                    ->method('validateOperationScenario')
                    ->with($title, $source, $content, $image, $attachments)
                    ->willReturn(true);
                 
        $commandBus = $this->prophesize(CommandBus::class);
        $commandBus->send(
            Argument::exact(
                new AddNewsCommand(
                    $title,
                    $source,
                    $content,
                    $image,
                    $attachments,
                    $publishUserGroupId
                )
            )
        )->shouldBeCalledTimes(1)->willReturn($result);

        $this->stub->expects($this->exactly(1))
                   ->method('getCommandBus')
                   ->willReturn($commandBus->reveal());
    }

    public function testAddActionSuccess()
    {
        $this->initialAdd(true);

        $this->stub->expects($this->exactly(1))
                   ->method('displaySuccess')
                   ->willReturn(true);

        $result = $this->stub->addAction();
        $this->assertTrue($result);
    }

    public function testAddFailure()
    {
        $this->initialAdd(false);

        $this->stub->expects($this->exactly(1))
                   ->method('displayError')
                   ->willReturn(false);

        $result = $this->stub->addAction();
        $this->assertFalse($result);
    }

    private function initialEdit(int $id, bool $result)
    {
        $this->stub = $this->getMockBuilder(TestOperationController::class)
            ->setMethods(
                [
                    'getRequest',
                    'displayError',
                    'displaySuccess',
                    'getCommandBus',
                    'validateOperationScenario'
                ]
            )->getMock();

        $title = 'title';
        $source = 'source';
        $content = 'content';
        $image = array('image');
        $attachments = array('attachment1', 'attachment2');

        $request = $this->prophesize(Request::class);
        $request->post(Argument::exact('title'), Argument::exact(''))
                ->shouldBeCalledTimes(1)
                ->willReturn($title);
        $request->post(Argument::exact('source'), Argument::exact(''))
                ->shouldBeCalledTimes(1)
                ->willReturn($source);
        $request->post(Argument::exact('content'), Argument::exact(''))
                ->shouldBeCalledTimes(1)
                ->willReturn($content);
        $request->post(Argument::exact('image'), Argument::exact(''))
                ->shouldBeCalledTimes(1)
                ->willReturn($image);
        $request->post(Argument::exact('attachments'), Argument::exact(array()))
                ->shouldBeCalledTimes(1)
                ->willReturn($attachments);

        $this->stub->expects($this->any())
                   ->method('getRequest')
                   ->willReturn($request->reveal());

        $this->stub->expects($this->exactly(1))
                    ->method('validateOperationScenario')
                    ->with($title, $source, $content, $image, $attachments)
                    ->willReturn(true);
                 
        $commandBus = $this->prophesize(CommandBus::class);
        $commandBus->send(
            Argument::exact(
                new EditNewsCommand(
                    $title,
                    $source,
                    $content,
                    $image,
                    $attachments,
                    $id
                )
            )
        )->shouldBeCalledTimes(1)->willReturn($result);

        $this->stub->expects($this->exactly(1))
                   ->method('getCommandBus')
                   ->willReturn($commandBus->reveal());
    }

    public function testEditActionSuccess()
    {
        $id = 1;

        $this->initialEdit($id, true);

        $this->stub->expects($this->exactly(1))
                   ->method('displaySuccess')
                   ->willReturn(true);

        $result = $this->stub->editAction($id);
        $this->assertTrue($result);
    }

    public function testEditActionFailure()
    {
        $id = 1;

        $this->initialEdit($id, false);

        $this->stub->expects($this->exactly(1))
                   ->method('displayError')
                   ->willReturn(false);

        $result = $this->stub->editAction($id);
        $this->assertFalse($result);
    }
}
