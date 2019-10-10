<?php
namespace Common\Controller\Traits;

class TestFetchController
{
    use FetchControllerTrait;

    protected function filterAction()
    {
        return true;
    }

    protected function fetchOneAction(int $id)
    {
        return false;
    }
}
