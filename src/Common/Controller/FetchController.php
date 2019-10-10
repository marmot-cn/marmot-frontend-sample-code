<?php
namespace Common\Controller;

use Marmot\Framework\Classes\Controller;
use Marmot\Framework\Controller\WebTrait;

use Common\Controller\Factory\FetchControllerFactory;
use Common\Controller\Interfaces\IFetchAbleController;

use WidgetRules\Common\UrlWidgetRules;

class FetchController extends Controller
{
    use WebTrait;
    
    protected function getFetchController(string $resource) : IFetchAbleController
    {
        return FetchControllerFactory::getFetchController($resource);
    }

    protected function getUrlWidgetRules() : UrlWidgetRules
    {
        return new UrlWidgetRules();
    }

    public function filter(string $resource)
    {
        $fetchController = $this->getFetchController($resource);

        return $fetchController->filter();
    }

    public function fetchOne(string $resource, $id = '')
    {
        $id = marmot_decode($id);

        if ($this->validateIndexScenario($id)) {
            $fetchController = $this->getFetchController($resource);

            return $fetchController->fetchOne($id);
        }

        $this->displayError();
        return false;
    }

    private function validateIndexScenario($id)
    {
        return $this->getUrlWidgetRules()->id($id);
    }
}
