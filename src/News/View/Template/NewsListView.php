<?php
namespace News\View\Template;

use Marmot\Interfaces\IView;
use Marmot\Framework\View\Template\TemplateView;

use News\Translator\NewsTranslator;

class NewsListView extends TemplateView implements IView
{
    private $newsList;

    private $count;

    private $translator;

    public function __construct(
        array $newsList,
        int $count
    ) {
        $this->newsList = $newsList;
        $this->count = $count;
        $this->translator = new NewsTranslator();
        parent::__construct();
    }

    protected function getNewsList() : array
    {
        return $this->newsList;
    }

    protected function getCount() : int
    {
        return $this->count;
    }

    protected function getTranslator() : NewsTranslator
    {
        return $this->translator;
    }

    public function display() : void
    {
        $data = array();

        $translator = $this->getTranslator();

        foreach ($this->getNewsList() as $news) {
            $data[] = $translator->objectToArray(
                $news,
                array(
                    'id',
                    'title',
                    'source',
                    'updateTime',
                    'status',
                    'publishUserGroup'=>['id','name'],
                )
            );
        }

        $dataList = array(
            'total' => $this->getCount(),
            'list' => $data
        );

        $this->getView()->display(
            'News/List.tpl',
            ['dataList'=>$dataList]
        );
    }
}
