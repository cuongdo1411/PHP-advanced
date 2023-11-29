<?php

$config['app'] =
    [
        'service' => [
            HtmlHelper::class,
        ],
        'routeMiddleware' => [
            'quan-ly' => AuthMiddleware::class,
        ],
        'globalMiddleware' => [
            ParamMiddleware::class
        ],
        'boot' => [
            AppServiceProvider::class,
        ]
    ];
