<?php
namespace News\View\Template;

use Marmot\Interfaces\IView;
use Marmot\Framework\View\Template\TemplateView;

class AddView extends TemplateView implements IView
{
    public function display()
    {
        $this->getView()->display(
            'News/Add.tpl'
        );
    }
}
