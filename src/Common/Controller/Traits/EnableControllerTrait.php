<?php
namespace Common\Controller\Traits;

trait EnableControllerTrait
{
    public function enable(int $id)
    {
        return $this->enableAction($id) ? $this->displaySuccess() : $this->displayError();
    }

    abstract protected function enableAction(int $id) : bool;

    public function disable(int $id)
    {
        return $this->disableAction($id) ? $this->displaySuccess() : $this->displayError();
    }

    abstract protected function disableAction(int $id) : bool;
}
