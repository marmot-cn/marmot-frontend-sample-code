<?php
namespace News\CommandHandler\News;

use Sdk\Common\Model\IEnableAble;
use Sdk\News\Repository\NewsRepository;

use Common\CommandHandler\DisableCommandHandler;

class DisableNewsCommandHandler extends DisableCommandHandler
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

    protected function fetchIEnableObject($id) : IEnableAble
    {
        return $this->getRepository()->scenario(NewsRepository::FETCH_ONE_MODEL_UN)->fetchOne($id);
    }
}
