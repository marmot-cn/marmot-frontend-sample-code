<?php
namespace News\CommandHandler\News;

use PHPUnit\Framework\TestCase;

use Sdk\News\Model\News;
use News\Utils\ObjectGenerate;
use News\Command\News\AddNewsCommand;

use Marmot\Framework\Interfaces\ICommand;

use Sdk\UserGroup\Model\UserGroup;
use Sdk\UserGroup\Repository\UserGroup\UserGroupRepository;

class AddNewsCommandHandlerTest extends TestCase
{
    private $stub;

    private $childStub;
    
    public function setUp()
    {
        $this->stub = $this->getMockBuilder(AddNewsCommandHandler::class)
            ->setMethods(['getNews', 'fetchUserGroup'])
            ->getMock();

        $this->childStub = new class extends AddNewsCommandHandler{
            public function getNews() : News
            {
                return parent::getNews();
            }

            public function getUserGroupRepository() : UserGroupRepository
            {
                return parent::getUserGroupRepository();
            }
        
            public function fetchUserGroup(int $id) : UserGroup
            {
                return parent::fetchUserGroup($id);
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
    
    public function testGetNews()
    {
        $this->assertInstanceOf(
            'Sdk\News\Model\News',
            $this->childStub->getNews()
        );
    }
    
    public function testGetUserGroupRepository()
    {
        $this->assertInstanceOf(
            'Sdk\UserGroup\Repository\UserGroup\UserGroupRepository',
            $this->childStub->getUserGroupRepository()
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
        $publishUserGroup = $faker->randomNumber(1);

        $command = new AddNewsCommand(
            $title,
            $source,
            $content,
            $image,
            $attachments,
            $publishUserGroup
        );

        $userGroup = \UserGroup\Utils\ObjectGenerate::generateUserGroup($publishUserGroup);

        $this->stub->expects($this->exactly(1))
            ->method('fetchUserGroup')
            ->with($publishUserGroup)
            ->willReturn($userGroup);

        $news = $this->prophesize(News::class);
        $news->setTitle($title)->shouldBeCalledTimes(1);
        $news->setSource($source)->shouldBeCalledTimes(1);
        $news->setContent($content)->shouldBeCalledTimes(1);
        $news->setImage($image)->shouldBeCalledTimes(1);
        $news->setAttachments($attachments)->shouldBeCalledTimes(1);
        $news->setPublishUserGroup($userGroup)->shouldBeCalledTimes(1);

        $news->add()->shouldBeCalledTimes(1)->willReturn(true);

        $this->stub->expects($this->exactly(1))
            ->method('getNews')
            ->willReturn($news->reveal());

        $result = $this->stub->execute($command);
        $this->assertTrue($result);
    }
}
