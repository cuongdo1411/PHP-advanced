<?php

$config['app'] =
    [
        'service' => [
            HtmlHelper::class,
        ],
        'routeMiddleware' => [
            'san-pham' => AuthMiddleware::class,
        ],
        'globalMiddleware' => [
            ParamMiddleware::class
        ],
        'boot' => [
            AppServiceProvider::class,
        ]
    ];
