<?php
namespace News\Translator;

use Marmot\Framework\Classes\Filter;
use Marmot\Interfaces\ITranslator;

use Sample\Sdk\News\Model\News;
use Sample\Sdk\News\Model\NullNews;

use UserGroup\Translator\UserGroupTranslator;

class NewsTranslator implements ITranslator
{
    public function arrayToObject(array $expression, $news = null)
    {
        unset($news);
        unset($expression);
        return new NullNews();
    }

    protected function getUserGroupTranslator() : UserGroupTranslator
    {
        return new UserGroupTranslator();
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function objectToArray($news, array $keys = array())
    {
        if (!$news instanceof News) {
            return array();
        }

        if (empty($keys)) {
            $keys = array(
                'id',
                'title',
                'source',
                'content',
                'image',
                'attachments',
                'publishUserGroup'=>['id', 'name'],
                'createTime',
                'updateTime',
                'status'
            );
        }

        $expression = array();

        if (in_array('id', $keys)) {
            $expression['id'] = marmot_encode($news->getId());
        }
        if (in_array('title', $keys)) {
            $expression['title'] = $news->getTitle();
        }
        if (in_array('source', $keys)) {
            $expression['source'] = $news->getSource();
        }
        if (in_array('createTime', $keys)) {
            $expression['createTime'] = $news->getCreateTime();
        }
        if (in_array('updateTime', $keys)) {
            $expression['updateTime'] = $news->getUpdateTime();
        }
        if (in_array('status', $keys)) {
            $expression['status'] = $news->getStatus();
        }
        if (in_array('content', $keys)) {
            $expression['content'] = Filter::dhtmlspecialchars($news->getContent());
        }
        if (isset($keys['publishUserGroup'])) {
            $expression['publishUserGroup'] = $this->getUserGroupTranslator()->objectToArray(
                $news->getPublishUserGroup(),
                $keys['publishUserGroup']
            );
        }
        if (in_array('image', $keys)) {
            $expression['image'] = $news->getImage();
        }
        if (in_array('attachments', $keys)) {
            $expression['attachments'] = $news->getAttachments();
        }

        return $expression;
    }
}
