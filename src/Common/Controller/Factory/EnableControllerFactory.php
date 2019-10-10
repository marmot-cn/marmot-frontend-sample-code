<?php
namespace Common\Controller\Factory;

use Common\Controller\NullEnableController;
use Common\Controller\Interfaces\IEnableAbleController;

class EnableControllerFactory
{
    const MAPS = array(
        'news'=>'\News\Controller\EnableController',
        'banners'=>'\Banner\Controller\EnableController',
    );

    public static function getEnableController(string $resource) : IEnableAbleController
    {
        $enableController = isset(self::MAPS[$resource]) ? self::MAPS[$resource] : '';

        return class_exists($enableController) ? new $enableController : new NullEnableController();
    }
}
