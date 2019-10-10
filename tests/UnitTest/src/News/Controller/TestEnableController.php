<?php
namespace News\Controller;

use Marmot\Framework\Classes\CommandBus;

class TestEnableController extends EnableController
{
    public function getCommandBus() : CommandBus
    {
        return parent::getCommandBus();
    }

    public function enableAction(int $id) : bool
    {
        return parent::enableAction($id);
    }

    public function disableAction(int $id) : bool
    {
        return parent::disableAction($id);
    }
}
