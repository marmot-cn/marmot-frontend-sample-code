<?php
namespace News\Command\News;

trait OperationNewsCommandTrait
{
    public function testCorrectInstanceExtendsCommand()
    {
        $this->assertInstanceOf(
            'Marmot\Framework\Interfaces\ICommand',
            $this->stub
        );
    }

    public function testTitleParameter()
    {
         $this->assertEquals($this->fakerData['title'], $this->stub->title);
    }

    public function testSourceParameter()
    {
         $this->assertEquals($this->fakerData['source'], $this->stub->source);
    }

    public function testContentParameter()
    {
         $this->assertEquals($this->fakerData['content'], $this->stub->content);
    }

    public function testImageParameter()
    {
         $this->assertEquals($this->fakerData['image'], $this->stub->image);
    }

    public function testAttachmentsParameter()
    {
         $this->assertEquals($this->fakerData['attachments'], $this->stub->attachments);
    }

    public function testIdParameter()
    {
        $this->assertEquals($this->fakerData['id'], $this->stub->id);
    }
}
