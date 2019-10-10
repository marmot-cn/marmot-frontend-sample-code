<?php
$fetchControllerKeys = array_keys(\Common\Controller\Factory\FetchControllerFactory::MAPS);
$fetchControllerRoutes = '{resource:'.implode('|', $fetchControllerKeys).'}';

$operationControllerKeys = array_keys(\Common\Controller\Factory\OperationControllerFactory::MAPS);
$operationControllerRoutes = '{resource:'.implode('|', $operationControllerKeys).'}';

$enableControllerKeys = array_keys(\Common\Controller\Factory\EnableControllerFactory::MAPS);
$enableControllerRoutes = '{resource:'.implode('|', $enableControllerKeys).'}';

return [
    //通用
    //添加
    [
        'method'=>['POST', 'GET'],
        'rule'=>'/'.$operationControllerRoutes.'/add',
        'controller'=>[
            'Common\Controller\OperationController',
            'add'
        ]
    ],
    //编辑
    [
        'method'=>['POST', 'GET'],
        'rule'=>'/'.$operationControllerRoutes.'/{id}/edit',
        'controller'=>[
            'Common\Controller\OperationController',
            'edit'
        ]
    ],
    //获取数据
    [
        'method'=>'GET',
        'rule'=>'/'.$fetchControllerRoutes,
        'controller'=>[
            'Common\Controller\FetchController',
            'filter'
        ]
    ],
    [
        'method'=>'GET',
        'rule'=>'/'.$fetchControllerRoutes.'/{id}',
        'controller'=>[
            'Common\Controller\FetchController',
            'fetchOne'
        ]
    ],

    //启用禁用
    [
        'method'=>'POST',
        'rule'=>'/'.$enableControllerRoutes.'/{id}/{status:enable|disable}',
        'controller'=>[
            'Common\Controller\EnableController',
            'index'
        ]
    ],
];
