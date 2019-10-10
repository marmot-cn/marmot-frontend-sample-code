<?php
namespace UserGroup\Translator;

use Marmot\Interfaces\ITranslator;

use Sample\Sample\Sdk\UserGroup\Model\UserGroup;
use Sample\Sample\Sdk\UserGroup\Model\NullUserGroup;

class UserGroupTranslator implements ITranslator
{
    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function arrayToObject(array $expression, $userGroup = null)
    {
        if ($expression == null) {
            return new NullUserGroup();
        }
        
        if ($userGroup == null) {
            $userGroup = new UserGroup(marmot_decode($expression['id']));
        }

        if (isset($expression['name'])) {
            $userGroup->setName($expression['name']);
        }
        if (isset($expression['createTime'])) {
            $userGroup->setCreateTime($expression['createTime']);
        }
        if (isset($expression['updateTime'])) {
            $userGroup->setUpdateTime($expression['updateTime']);
        }
        if (isset($expression['status'])) {
            $userGroup->setStatus($expression['status']);
        }

        return $userGroup;
    }

    public function arrayToObjects(array $expression) : array
    {
        unset($expression);
        return array();
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function objectToArray($userGroup, array $keys = array())
    {
        if (!$userGroup instanceof UserGroup) {
            return array();
        }

        if (empty($keys)) {
            $keys = array(
                'id',
                'name',
                'createTime',
                'updateTime',
                'status',
            );
        }

        $expression = array();
        
        if (in_array('id', $keys)) {
            $expression['id'] = marmot_encode($userGroup->getId());
        }
        if (in_array('name', $keys)) {
            $expression['name'] = $userGroup->getName();
        }
        if (in_array('createTime', $keys)) {
            $expression['createTime'] = $userGroup->getCreateTime();
        }
        if (in_array('updateTime', $keys)) {
            $expression['updateTime'] = $userGroup->getUpdateTime();
        }
        if (in_array('status', $keys)) {
            $expression['status'] = $userGroup->getStatus();
        }

        return $expression;
    }
}
