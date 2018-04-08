<?php
return [
    'id' => 'authentication',
    'migrationPath' => '@vendor/yuncms/authentication/migrations',
    'translations' => [
        'yuncms/authentication' => [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@vendor/yuncms/authentication/messages',
        ],
    ],
    'backend' => [
        'class' => 'yuncms\authentication\backend\Module'
    ],
    'frontend' => [
        'class' => 'yuncms\authentication\frontend\Module',
    ],
];