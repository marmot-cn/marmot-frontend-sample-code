<?php
namespace Home\Controller;

use Marmot\Framework\Classes\Controller;

use Home\View\Template\IndexView;

class IndexController extends Controller
{
    /**
     * @codeCoverageIgnore
     */
    public function index()
    {
        $this->render(new IndexView(array('Hello World')));
        return true;
    }
}
