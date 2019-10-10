<?php
namespace News\Controller;

use Sdk\News\Repository\NewsRepository;

class TestFetchController extends FetchController
{
    public function getRepository() : NewsRepository
    {
        return parent::getRepository();
    }

    public function filterAction()
    {
        return parent::filterAction();
    }

    public function filterFormatChange($search)
    {
        return parent::filterFormatChange($search);
    }

    public function fetchOneAction(int $id)
    {
        return parent::fetchOneAction($id);
    }
}
