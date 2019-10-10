<?php
namespace News\Controller;

use Marmot\Core;
use Marmot\Interfaces\INull;
use Marmot\Framework\Classes\Controller;
use Marmot\Framework\Controller\WebTrait;

use Common\Controller\Traits\FetchControllerTrait;
use Common\Controller\Interfaces\IFetchAbleController;

use News\View\Template\NewsView;
use News\View\Template\NewsListView;
use Sample\Sdk\News\Repository\NewsRepository;

class FetchController extends Controller implements IFetchAbleController
{
    use WebTrait, FetchControllerTrait;

    private $repository;

    public function __construct()
    {
        parent::__construct();
        $this->repository = new NewsRepository('http://backend-sample-nginx/');
    }

    public function __destruct()
    {
        parent::__destruct();
        unset($this->repository);
    }

    protected function getRepository() : NewsRepository
    {
        return $this->repository;
    }

    protected function filterAction()
    {
        $search = $this->getRequest()->get('search', array());

        list($size,$page) = $this->getPageAndSize();
        list($filter, $sort) = $this->filterFormatChange($search);

        $newsList = array();

        list($count, $newsList) =
            $this->getRepository()->scenario(NewsRepository::LIST_MODEL_UN)->search($filter, $sort, $page, $size);

        $this->render(new NewsListView($newsList, $count));
        return true;
    }

    protected function filterFormatChange($search)
    {
        $sort = ['-updateTime'];
        $filter = array();

        if (!empty($search[0])) {
            $filter['title'] = $search[0];
        }

        return [$filter, $sort];
    }

    protected function fetchOneAction(int $id)
    {
        if (empty($id)) {
            Core::setLastError(RESOURCE_NOT_EXIST);
            return false;
        }

        $news = $this->getRepository()->scenario(NewsRepository::FETCH_ONE_MODEL_UN)->fetchOne($id);
      
        if ($news instanceof INull) {
            Core::setLastError(RESOURCE_NOT_EXIST);
            return false;
        }

        $this->render(new NewsView($news));
        return true;
    }
}
