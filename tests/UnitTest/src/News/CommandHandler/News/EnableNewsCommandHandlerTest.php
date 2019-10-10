<?php
namespace News\CommandHandler\News;

use PHPUnit\Framework\TestCase;

use Sdk\Common\Model\IEnableAble;
use Sdk\News\Repository\NewsRepository;

class EnableNewsCommandHandlerTest extends TestCase
{
    private $stub;

    private $childStub;

    public function tearDown()
    {
        unset($this->stub);
        unset($this->childStub);
    }

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(EnableNewsCommandHandler::class)
            ->setMethods(['getRepository', 'fetchIEnableObject'])
            ->getMock();

        $this->childStub = new class extends EnableNewsCommandHandler{
            public function getRepository() : NewsRepository
            {
                return parent::getRepository();
            }

            public function fetchIEnableObject($id) : IEnableAble
            {
                return parent::fetchIEnableObject($id);
            }
        };
    }

    public function testExtendsCommandHandler()
    {
        $this->assertInstanceOf(
            'Common\CommandHandler\EnableCommandHandler',
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

    public function testFetchIEnableObject()
    {
        $id =1;
        
        $this->assertInstanceOf(
            'Sdk\Common\Model\IEnableAble',
            $this->childStub->fetchIEnableObject($id)
        );
    }
}
