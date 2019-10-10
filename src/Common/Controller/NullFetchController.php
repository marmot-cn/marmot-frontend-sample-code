<?php
namespace Common\Controller;

use Marmot\Core;
use Marmot\Interfaces\INull;

use Common\Controller\Interfaces\IFetchAbleController;

class NullFetchController implements IFetchAbleController, INull
{
    public function filter()
    {
        Core::setLastError(ROUTE_NOT_EXIST);
    }
    
    public function fetchOne($id)
    {
        Core::setLastError(ROUTE_NOT_EXIST);
    }
}
