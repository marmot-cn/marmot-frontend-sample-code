<?php
namespace Common\Controller\Factory;

use Common\Controller\NullOperationController;
use Common\Controller\Interfaces\IOperatAbleController;

class OperationControllerFactory
{
    const MAPS = array(
        'news'=>'\News\Controller\OperationController',
    );

    public static function getOperationController(string $resource) : IOperatAbleController
    {
        $operationController = isset(self::MAPS[$resource]) ? self::MAPS[$resource] : '';

        return class_exists($operationController) ? new $operationController : new NullOperationController();
    }
}
