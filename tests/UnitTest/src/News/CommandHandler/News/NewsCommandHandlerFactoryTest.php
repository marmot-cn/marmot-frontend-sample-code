<?php
namespace News\CommandHandler\News;

use PHPUnit\Framework\TestCase;

use News\Command\News\AddNewsCommand;
use News\Command\News\EditNewsCommand;
use News\Command\News\EnableNewsCommand;
use News\Command\News\DisableNewsCommand;

class NewsCommandHandlerFactoryTest extends TestCase
{
    private $stub;

    private $faker;

    public function setUp()
    {
        $this->faker = \Faker\Factory::create('zh_CN');
        $this->stub = new NewsCommandHandlerFactory();
    }

    public function testAddNewsCommandHandler()
    {
        $commandHandler = $this->stub->getHandler(
            new AddNewsCommand(
                $this->faker->sentence(),
                $this->faker->sentence(),
                $this->faker->sentence(),
                array($this->faker->md5),
                array('attachment1','attachment2'),
                $this->faker->randomNumber(1)
            )
        );

        $this->assertInstanceOf(
            'News\CommandHandler\News\AddNewsCommandHandler',
            $commandHandler
        );
    }

    public function testEditNewsCommandHandler()
    {
        $commandHandler = $this->stub->getHandler(
            new EditNewsCommand(
                $this->faker->sentence(),
                $this->faker->sentence(),
                $this->faker->sentence(),
                array($this->faker->md5),
                array('attachment1','attachment2'),
                $this->faker->randomNumber()
            )
        );

        $this->assertInstanceOf(
            'News\CommandHandler\News\EditNewsCommandHandler',
            $commandHandler
        );
    }

    public function testDisableNewsCommandHandler()
    {
        $commandHandler = $this->stub->getHandler(
            new DisableNewsCommand(
                $this->faker->randomNumber(1)
            )
        );
        $this->assertInstanceOf(
            'News\CommandHandler\News\DisableNewsCommandHandler',
            $commandHandler
        );
    }

    public function testEnableNewsCommandHandler()
    {
        $commandHandler = $this->stub->getHandler(
            new EnableNewsCommand(
                $this->faker->randomNumber(1)
            )
        );

        $this->assertInstanceOf(
            'News\CommandHandler\News\EnableNewsCommandHandler',
            $commandHandler
        );
    }
}
