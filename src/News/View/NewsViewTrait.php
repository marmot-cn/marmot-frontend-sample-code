<?php
namespace News\View;

use Sample\Sdk\News\Model\News;
use News\Translator\NewsTranslator;

trait NewsViewTrait
{
    private $news;

    private $translator;

    public function __construct(News $news)
    {
        $this->news = $news;
        $this->translator = new NewsTranslator();
        parent::__construct();
    }

    protected function getNews() : News
    {
        return $this->news;
    }

    protected function getTranslator() : NewsTranslator
    {
        return $this->translator;
    }
}
