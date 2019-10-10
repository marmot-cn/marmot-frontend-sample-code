<?php
namespace Common\Controller\Traits;

class TestOperatController
{
    use OperatControllerTrait;

    protected function addView()
    {
        return true;
    }

    protected function addAction()
    {
        return false;
    }

    protected function editView(int $id)
    {
        return true;
    }

    protected function editAction(int $id)
    {
        return true;
    }
}
