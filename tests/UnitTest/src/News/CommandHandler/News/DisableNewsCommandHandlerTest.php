<?php
namespace News\CommandHandler\News;

use PHPUnit\Framework\TestCase;

use Sdk\Common\Model\IEnableAble;
use Sdk\News\Repository\NewsRepository;

class DisableNewsCommandHandlerTest extends TestCase
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
        $this->stub = $this->getMockBuilder(DisableNewsCommandHandler::class)
            ->setMethods(['getRepository', 'fetchIEnableObject'])
            ->getMock();

        $this->childStub = new class extends DisableNewsCommandHandler{
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
            'Common\CommandHandler\DisableCommandHandler',
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
