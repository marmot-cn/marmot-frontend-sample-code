<?php
namespace News\CommandHandler\News;

use Sdk\News\Model\News;
use Sdk\News\Repository\NewsRepository;
use News\Command\News\EditNewsCommand;

use Marmot\Interfaces\ICommand;
use Marmot\Interfaces\ICommandHandler;

class EditNewsCommandHandler implements ICommandHandler
{
    private $repository;

    public function __construct()
    {
        $this->repository = new NewsRepository();
    }

    public function __destruct()
    {
        unset($this->repository);
    }

    protected function getRepository() : NewsRepository
    {
        return $this->repository;
    }

    protected function fetchNews($id) : News
    {
        return $this->getRepository()->fetchOne($id);
    }

    public function execute(ICommand $command)
    {
        return $this->executeAction($command);
    }

    protected function executeAction($command)
    {
        if (!($command instanceof EditNewsCommand)) {
            throw new \InvalidArgumentException;
        }
        $this->news = $this->fetchNews($command->id);

        $this->news->setTitle($command->title);
        $this->news->setSource($command->source);
        $this->news->setContent($command->content);
        $this->news->setImage($command->image);
        $this->news->setAttachments($command->attachments);

        return $this->news->edit();
    }
}
