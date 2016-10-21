<?php

return [

    'use' => 'production',

    'properties' => [

        'production' => [
            'host'                => env('RABBITMQ_HOST', '127.0.0.1'),
            'port'                => env('RABBITMQ_PORT', 5672),
            'username'            => env('RABBITMQ_LOGIN', 'guest'),
            'password'            => env('RABBITMQ_PASSWORD', 'guest'),
            'vhost'               => env('RABBITMQ_VHOST', '/'),
            'exchange'            => env('RABBITMQ_EXCHANGE'),
            'exchange_type'       => env('RABBITMQ_EXCHANGE_TYPE', 'direct'),
            'exchange_durable'    => env('RABBITMQ_EXCHANGE_DURABLE', ['t', true,]),
            'consumer_tag'        => env('RABBITMQ_CONSUMER'),
            'ssl_options'         => [], // See https://secure.php.net/manual/en/context.ssl.php
            'connect_options'     => [], // See https://github.com/php-amqplib/php-amqplib/blob/master/PhpAmqpLib/Connection/AMQPSSLConnection.php
            'queue_properties'    => ['x-ha-policy' => ['S', 'all']],
            'exchange_properties' => [],
            'timeout'             => 0
        ],

    ],

];