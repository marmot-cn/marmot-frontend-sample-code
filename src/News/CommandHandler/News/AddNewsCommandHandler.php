<?php
namespace News\CommandHandler\News;

use Sdk\News\Model\News;
use News\Command\News\AddNewsCommand;

use Marmot\Interfaces\ICommand;
use Marmot\Interfaces\ICommandHandler;

use Sdk\UserGroup\Model\UserGroup;
use Sdk\UserGroup\Repository\UserGroup\UserGroupRepository;

class AddNewsCommandHandler implements ICommandHandler
{
    private $news;

    private $userGroupRepository;

    public function __construct()
    {
        $this->news = new News();
        $this->userGroupRepository = new UserGroupRepository();
    }

    public function __destruct()
    {
        unset($this->news);
        unset($this->userGroupRepository);
    }

    protected function getNews() : News
    {
        return $this->news;
    }

    protected function getUserGroupRepository() : UserGroupRepository
    {
        return $this->userGroupRepository;
    }

    protected function fetchUserGroup(int $id) : UserGroup
    {
        return $this->getUserGroupRepository()->fetchOne($id);
    }

    public function execute(ICommand $command)
    {
        return $this->executeAction($command);
    }

    protected function executeAction($command)
    {
        if (!($command instanceof AddNewsCommand)) {
            throw new \InvalidArgumentException;
        }

        $userGroup = $this->fetchUserGroup($command->publishUserGroup);

        $news = $this->getNews();
        $news->setTitle($command->title);
        $news->setSource($command->source);
        $news->setContent($command->content);
        $news->setImage($command->image);
        $news->setAttachments($command->attachments);
        $news->setPublishUserGroup($userGroup);

        return $news->add();
    }
}
