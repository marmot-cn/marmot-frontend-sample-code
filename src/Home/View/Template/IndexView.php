<?php
namespace Home\View\Template;

use Marmot\Interfaces\IView;
use Marmot\Framework\View\Template\TemplateView;

class IndexView extends TemplateView implements IView
{
    public function display()
    {
        $this->getView()->display(
            'Home/Index.tpl',
            ['data'=>$this->getData()]
        );
    }
}
