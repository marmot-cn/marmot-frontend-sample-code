<?php
namespace Common\Controller\Traits;

class TestEnableController
{
    use EnableControllerTrait;

    protected function enableAction(int $id)
    {
        return true;
    }

    protected function disableAction(int $id)
    {
        return false;
    }
}
