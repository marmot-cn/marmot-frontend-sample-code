<?php
namespace News\Controller;

use Marmot\Framework\Classes\Controller;
use Marmot\Framework\Classes\CommandBus;
use Marmot\Framework\Controller\WebTrait;

use Common\Controller\Traits\EnableControllerTrait;
use Common\Controller\Interfaces\IEnableAbleController;

use News\Command\News\EnableNewsCommand;
use News\Command\News\DisableNewsCommand;
use News\CommandHandler\News\NewsCommandHandlerFactory;

class EnableController extends Controller implements IEnableAbleController
{
    use WebTrait, EnableControllerTrait;

    private $commandBus;

    public function __construct()
    {
        parent::__construct();
        $this->commandBus = new CommandBus(new NewsCommandHandlerFactory());
    }

    public function __destruct()
    {
        parent::__destruct();
        unset($this->commandBus);
    }

    protected function getCommandBus() : CommandBus
    {
        return $this->commandBus;
    }

    protected function enableAction(int $id) : bool
    {
        return $this->getCommandBus()->send(new EnableNewsCommand($id));
    }

    protected function disableAction(int $id) : bool
    {
        return $this->getCommandBus()->send(new DisableNewsCommand($id));
    }
}
