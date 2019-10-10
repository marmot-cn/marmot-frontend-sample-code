<?php
namespace UserGroup\Translator;

use PHPUnit\Framework\TestCase;

use Sdk\UserGroup\Model\UserGroup;

class UserGroupTranslatorTest extends TestCase
{
    private $translator;

    public function setUp()
    {
        $this->translator = new UserGroupTranslator();
    }

   /**
    * 1. 无论我传什么都返回NullUserGroup
    */
    public function testArrayToObjectWithUserGroupObject()
    {
        $result = $this->translator->arrayToObject(array(), new UserGroup(1));
        $this->assertInstanceOf('Sdk\UserGroup\Model\NullUserGroup', $result);
    }

    public function testArrayToObjectNull()
    {
        $result = $this->translator->arrayToObject(array());
        $this->assertInstanceOf('Sdk\UserGroup\Model\NullUserGroup', $result);
    }

    public function testArrayToObject()
    {
        $userGroup = \UserGroup\Utils\ArrayGenerate::generateUserGroup(1);

        $data = $userGroup['data'];
        $attributes = $data['attributes'];
        $attributes['id'] = marmot_encode($data['id']);

        $actual = $this->translator->arrayToObject($attributes);

        $expectObject = new UserGroup();

        $expectObject->setId($data['id']);

        if (isset($attributes['name'])) {
            $expectObject->setName($attributes['name']);
        }
        if (isset($attributes['createTime'])) {
            $expectObject->setCreateTime($attributes['createTime']);
        }
        if (isset($attributes['updateTime'])) {
            $expectObject->setUpdateTime($attributes['updateTime']);
        }
        if (isset($attributes['status'])) {
            $expectObject->setStatus($attributes['status']);
        }

        $this->assertEquals($expectObject, $actual);
    }

    /**
     * 1. 无论我赋值什么都返回空数组
     */
    public function testArrayToObjects()
    {
        $userGroupList = array();

        $userGroupList[] = \UserGroup\Utils\ObjectGenerate::generateUserGroup(1, 1);
        $userGroupList[] = \UserGroup\Utils\ObjectGenerate::generateUserGroup(2, 2);
    
        $result = $this->translator->arrayToObjects($userGroupList);
        $this->assertEquals(array(), $result);
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
        $userGroup = \UserGroup\Utils\ObjectGenerate::generateUserGroup(1, 1);

        $actual = $this->translator->objectToArray($userGroup);

        $expectedArray = array(
            'id'=>marmot_encode($userGroup->getId()),
            'name'=>$userGroup->getName(),
            'updateTime'=>$userGroup->getUpdateTime(),
            'createTime'=>$userGroup->getCreateTime(),
            'status'=>$userGroup->getStatus(),
        );

        $this->assertEquals($expectedArray, $actual);
    }
}
