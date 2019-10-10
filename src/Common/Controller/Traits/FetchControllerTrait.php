<?php
namespace Common\Controller\Traits;

trait FetchControllerTrait
{
    public function getPageAndSize()
    {
        $size = $this->getRequest()->get('limit', 10);
        $page = $this->getRequest()->get('page', 1);
     
        return [$size, $page];
    }

    public function filter() : bool
    {
        if ($this->filterAction()) {
            return true;
        }

        $this->displayError();
        return false;
    }

    abstract protected function filterAction() : bool;

    public function fetchOne($id) : bool
    {
        if ($this->fetchOneAction($id)) {
            return true;
        }
        $this->displayError();
        return false;
    }

    abstract protected function fetchOneAction(int $id) : bool;
}
