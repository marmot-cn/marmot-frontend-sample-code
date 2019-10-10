<?php
namespace News\View\Template;

use Marmot\Interfaces\IView;
use Marmot\Framework\View\Template\TemplateView;

use News\View\NewsViewTrait;

class NewsView extends TemplateView implements IView
{
    use NewsViewTrait;
    
    public function display()
    {
        $translator = $this->getTranslator();
        $data = $translator->objectToArray(
            $this->getNews()
        );

        $this->getView()->display(
            'News/Show.tpl',
            ['news'=>$data]
        );
    }
}
