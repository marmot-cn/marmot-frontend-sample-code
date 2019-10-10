<?php
namespace Common\Controller\Interfaces;

interface IFetchAbleController
{
    public function filter();
    
    public function fetchOne($id);
}
