<?php
namespace News\CommandHandler\News;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use Sdk\News\Model\News;
use News\Command\News\EditNewsCommand;
use Sdk\News\Repository\NewsRepository;

use Marmot\Framework\Interfaces\ICommand;

class EditNewsCommandHandlerTest extends TestCase
{
    private $stub;

    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(EditNewsCommandHandler::class)
            ->setMethods(['getRepository'])
            ->getMock();

        $this->childStub = new class extends EditNewsCommandHandler{
            public function getRepository() : NewsRepository
            {
                return parent::getRepository();
            }

            public function fetchNews($id) : News
            {
                return parent::fetchNews($id);
            }
        };
    }

    public function tearDown()
    {
        unset($this->stub);
        unset($this->childStub);
    }

    public function testImplementsICommandHandler()
    {
        $this->assertInstanceOf(
            'Marmot\Framework\Interfaces\ICommandHandler',
            $this->stub
        );
    }
    
    public function testGetRepository()
    {
        $this->assertInstanceOf(
            'Sdk\News\Repository\NewsRepository',
            $this->childStub->getRepository()
        );
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidArgumentException()
    {
        $command = new class implements ICommand {
        };
        $this->stub->execute($command);
    }

    public function testExecute()
    {
        $faker = \Faker\Factory::create('zh_CN');

        $title = $faker->sentence;
        $source = $faker->sentence;
        $content = $faker->sentence;
        $image = array($faker->md5);
        $attachments = array('attachments1','attachments2');
        $id = $faker->randomNumber(1);

        $command = new EditNewsCommand(
            $title,
            $source,
            $content,
            $image,
            $attachments,
            $id
        );

        $news = $this->prophesize(News::class);
        $news->setTitle($title)->shouldBeCalledTimes(1);
        $news->setSource($source)->shouldBeCalledTimes(1);
        $news->setContent($content)->shouldBeCalledTimes(1);
        $news->setImage($image)->shouldBeCalledTimes(1);
        $news->setAttachments($attachments)->shouldBeCalledTimes(1);
        $news->edit()->shouldBeCalledTimes(1)->willReturn(true);

        $newsRepository = $this->prophesize(NewsRepository::class);
        $newsRepository->fetchOne(Argument::exact($id))->shouldBeCalledTimes(1)->willReturn($news->reveal());

        $this->stub->expects($this->exactly(1))
            ->method('getRepository')
            ->willReturn($newsRepository->reveal());

        $result = $this->stub->execute($command);
        $this->assertTrue($result);
    }
}
