<?php
namespace News\Command\News;

use PHPUnit\Framework\TestCase;

class AddNewsCommandTest extends TestCase
{
    use OperationNewsCommandTrait;

    private $fakerData = array();

    private $stub;
    
    public function setUp()
    {
        $faker = \Faker\Factory::create('zh_CN');
        $this->fakerData = array(
            'title' => 'title',
            'source' => 'source',
            'content' => 'content',
            'image' => array('image'),
            'attachments' => array('attachment1','attachment2'),
            'publishUserGroup' => $faker->randomNumber(1),
            'id' => $faker->randomNumber(3)
        );

        $this->stub = new AddNewsCommand(
            $this->fakerData['title'],
            $this->fakerData['source'],
            $this->fakerData['content'],
            $this->fakerData['image'],
            $this->fakerData['attachments'],
            $this->fakerData['publishUserGroup'],
            $this->fakerData['id']
        );
    }

    public function testPublishUserGroupParameter()
    {
        $this->assertEquals($this->fakerData['publishUserGroup'], $this->stub->publishUserGroup);
    }

    public function testDefaultParameter()
    {
        $command = new AddNewsCommand(
            $this->fakerData['title'],
            $this->fakerData['source'],
            $this->fakerData['content'],
            $this->fakerData['image']
        );

        $this->assertEmpty($command->attachments);
        $this->assertEquals(0, $command->publishUserGroup);
        $this->assertEquals(0, $command->id);
    }
}
