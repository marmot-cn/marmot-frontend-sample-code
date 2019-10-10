<?php
namespace Common\Controller;

use Marmot\Framework\Classes\Controller;
use Marmot\Framework\Controller\WebTrait;

use WidgetRules\Common\UrlWidgetRules;

use Common\Controller\Factory\OperationControllerFactory;
use Common\Controller\Interfaces\IOperatAbleController;

class OperationController extends Controller
{
    use WebTrait;
    protected function getOperationController(string $resource) : IOperatAbleController
    {
        return OperationControllerFactory::getOperationController($resource);
    }

    protected function getUrlWidgetRules() : UrlWidgetRules
    {
        return new UrlWidgetRules();
    }

    public function add(string $resource)
    {
        $operationController = $this->getOperationController($resource);
        return $operationController->add();
    }

    public function edit(string $resource, $id)
    {
        $id = marmot_decode($id);
        if ($this->validateIdScenario($id)) {
            $operationController = $this->getOperationController($resource);

            return $operationController->edit($id);
        }

        $this->displayError();
        return false;
    }

    private function validateIdScenario($id)
    {
        return $this->getUrlWidgetRules()->id($id);
    }
}
