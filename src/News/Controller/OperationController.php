<?php
namespace News\Controller;

use Marmot\Core;
use Marmot\Framework\Classes\CommandBus;
use Marmot\Framework\Classes\Controller;
use Marmot\Framework\Controller\WebTrait;

use News\View\Template\AddView;
use News\View\Template\EditView;
use News\Command\News\AddNewsCommand;
use News\Command\News\EditNewsCommand;
use News\CommandHandler\News\NewsCommandHandlerFactory;

use Sample\Sdk\News\Repository\NewsRepository;

use Common\Controller\Traits\OperatControllerTrait;
use Common\Controller\Interfaces\IOperatAbleController;

use WidgetRules\News\WidgetRules as NewsWidgetRules;
use WidgetRules\Common\WidgetRules as CommonWidgetRules;

class OperationController extends Controller implements IOperatAbleController
{
    use WebTrait, OperatControllerTrait;

    private $commandBus;

    private $commonWidgetRules;

    private $newsWidgetRules;

    private $repository;
    
    public function __construct()
    {
        parent::__construct();
        $this->commandBus = new CommandBus(new NewsCommandHandlerFactory());
        $this->commonWidgetRules = new CommonWidgetRules();
        $this->newsWidgetRules = new NewsWidgetRules();
        $this->repository = new NewsRepository();
    }

    protected function getCommandBus() : CommandBus
    {
        return $this->commandBus;
    }

    protected function getCommonWidgetRules() : CommonWidgetRules
    {
        return $this->commonWidgetRules;
    }

    protected function getNewsWidgetRules() : NewsWidgetRules
    {
        return $this->newsWidgetRules;
    }
 
    protected function getRepository() : NewsRepository
    {
        return $this->repository;
    }

    protected function addView() : bool
    {
        $this->render(new AddView());
        return true;
    }

    protected function addAction()
    {
        $request = $this->getRequest();

        $title = $request->post('title', '');
        $source = $request->post('source', '');
        $content = $request->post('content', '');
        $image = $request->post('image', '');
        $attachments = $request->post('attachments', array());
        $publishUserGroup = $request->post('publishUserGroup', '');
        $publishUserGroup = marmot_decode($publishUserGroup);

        if ($this->validateOperationScenario(
            $title,
            $source,
            $content,
            $image,
            $attachments
        )) {
            $command = new AddNewsCommand(
                $title,
                $source,
                $content,
                $image,
                $attachments,
                $publishUserGroup
            );
            
            if ($this->getCommandBus()->send($command)) {
                $this->displaySuccess();
                return true;
            }
        }
        $this->displayError();
        return false;
    }

    protected function validateOperationScenario(
        $title,
        $source,
        $content,
        $image,
        $attachments
    ) : bool {
        return $this->getCommonWidgetRules()->title($title)
        && $this->getNewsWidgetRules()->source($source)
        && $this->getNewsWidgetRules()->content($content)
        && (empty($image) ? true : $this->getCommonWidgetRules()->image($image, 'image'))
        && $this->getCommonWidgetRules()->attachments($attachments);
    }

    protected function editView(int $id) : bool
    {
        $news = $this->getRepository()->scenario(NewsRepository::FETCH_ONE_MODEL_UN)->fetchOne($id);

        if ($news instanceof INull) {
            Core::setLastError(RESOURCE_NOT_EXIST);
            return false;
        }

        $this->render(new EditView($news));
        return true;
    }

    protected function editAction(int $id)
    {
        $title = $this->getRequest()->post('title', '');
        $source = $this->getRequest()->post('source', '');
        $content = $this->getRequest()->post('content', '');
        $image = $this->getRequest()->post('image', '');
        $attachments = $this->getRequest()->post('attachments', array());
        
        if ($this->validateOperationScenario(
            $title,
            $source,
            $content,
            $image,
            $attachments
        )) {
            $command = new EditNewsCommand(
                $title,
                $source,
                $content,
                $image,
                $attachments,
                $id
            );

            if ($this->getCommandBus()->send($command)) {
                $this->displaySuccess();
                return true;
            }
        }
        $this->displayError();
        return false;
    }
}
