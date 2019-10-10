<?php
namespace News\Translator;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use Sdk\News\Model\News;

use UserGroup\Translator\UserGroupTranslator;

class NewsTranslatorTest extends TestCase
{
    private $translator;
    private $childTranslator;

    public function setUp()
    {
        $this->translator = $this->getMockBuilder(NewsTranslator::class)
                          ->setMethods(['getUserGroupTranslator'])
                          ->getMock();

        $this->childTranslator = new class extends NewsTranslator
        {
            public function getUserGroupTranslator() : UserGroupTranslator
            {
                return parent::getUserGroupTranslator();
            }
        };
        parent::setUp();
    }

   /**
    * 1. 无论我传什么都返回NullNews
    */
    public function testArrayToObjectWithNewsObject()
    {
        $result = $this->translator->arrayToObject(array(), new News(1));
        $this->assertInstanceOf('Sdk\News\Model\NullNews', $result);
    }

    public function testArrayToObject()
    {
        $result = $this->translator->arrayToObject(array());
        $this->assertInstanceOf('Sdk\News\Model\NullNews', $result);
    }

    public function testGetUserGroupTranslator()
    {
        $this->assertInstanceOf(
            'UserGroup\Translator\UserGroupTranslator',
            $this->childTranslator->getUserGroupTranslator()
        );
    }

    /**
     * 如果传参错误对象, 期望返回空数组
     */
    public function testObjectToArrayIncorrectObject()
    {
        $result = $this->translator->objectToArray(null);
        $this->assertEquals(array(), $result);
    }

    /**
     * 传参正确对象, 返回对应数组
     */
    public function testObjectToArrayCorrectObject()
    {
        $news = \News\Utils\ObjectGenerate::generateNews(1, 1);

        $userGroupTranslator = $this->prophesize(UserGroupTranslator::class);
        $userGroupTranslator->objectToArray(
            Argument::exact($news->getPublishUserGroup()),
            Argument::exact(array('id', 'name'))
        )->shouldBeCalledTimes(1)->willReturn(array('userGroupTranslator'));
        $this->translator->expects($this->exactly(1))
            ->method('getUserGroupTranslator')
            ->willReturn($userGroupTranslator->reveal());

        $actual = $this->translator->objectToArray($news);

        $expectedArray = array(
            'id'=>marmot_encode($news->getId()),
            'title'=>$news->getTitle(),
            'content'=>$news->getContent(),
            'createTime'=>$news->getCreateTime(),
            'updateTime'=>$news->getUpdateTime(),
            'status'=>$news->getStatus(),
            'source'=>$news->getSource(),
            'publishUserGroup'=>array(
                'userGroupTranslator'
            ),
            'image'=>$news->getImage(),
            'attachments'=>$news->getAttachments()
        );

        $this->assertEquals($expectedArray, $actual);
    }
}
