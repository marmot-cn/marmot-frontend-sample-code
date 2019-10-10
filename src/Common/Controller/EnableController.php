<?php
namespace Common\Controller;

use Marmot\Framework\Classes\Controller;
use Marmot\Framework\Controller\WebTrait;

use Common\Controller\Factory\EnableControllerFactory;
use Common\Controller\Interfaces\IEnableAbleController;

use WidgetRules\Common\UrlWidgetRules;

class EnableController extends Controller
{
    use WebTrait;
    
    protected function getEnableController(string $resource) : IEnableAbleController
    {
        return EnableControllerFactory::getEnableController($resource);
    }

    protected function getUrlWidgetRules() : UrlWidgetRules
    {
        return new UrlWidgetRules();
    }

    public function index(string $resource, $id, string $status)
    {
        $id = marmot_decode($id);

        if ($this->validateIndexScenario($id)) {
            $enableController = $this->getEnableController($resource);
            return $enableController->$status($id);
        }

        $this->displayError();
        return false;
    }

    private function validateIndexScenario($id)
    {
        return $this->getUrlWidgetRules()->id($id);
    }
}
