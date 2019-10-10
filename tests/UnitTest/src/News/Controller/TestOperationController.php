<?php
namespace News\Controller;

use WidgetRules\News\WidgetRules as NewsWidgetRules;
use WidgetRules\Common\WidgetRules as CommonWidgetRules;

use Sdk\News\Repository\NewsRepository;

use Marmot\Framework\Classes\CommandBus;

class TestOperationController extends OperationController
{
    public function getCommandBus() : CommandBus
    {
        return parent::getCommandBus();
    }

    public function getCommonWidgetRules() : CommonWidgetRules
    {
        return parent::getCommonWidgetRules();
    }

    public function getNewsWidgetRules() : NewsWidgetRules
    {
        return parent::getNewsWidgetRules();
    }

    public function getRepository() : NewsRepository
    {
        return parent::getRepository();
    }

    public function addView() : bool
    {
        return parent::addView();
    }

    public function editView(int $id) : bool
    {
        return parent::editView($id);
    }

    public function validateOperationScenario(
        $title,
        $source,
        $content,
        $image,
        $attachments
    ) : bool {
        return parent::validateOperationScenario($title, $source, $content, $image, $attachments);
    }
    
    public function addAction()
    {
        return parent::addAction();
    }

    public function editAction(int $id)
    {
        return parent::editAction($id);
    }
}
