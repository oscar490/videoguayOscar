<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$log = require __DIR__ . '/log.php';

$config = [
    'id' => 'basic',
    'name' => 'VideoGuay',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'language' => 'es-ES',
    'container' => [
        'definitions' => [
            yii\data\Pagination::className() => [
                'pageSize' => 5,
            ],
            kartik\number\NumberControl::className() => [
                'maskedInputOptions' => [
                    'prefix' => '',
                    'suffix' => ' €',
                    'groupSeparator' => '.',
                    'radixPoint' => ',',
                    // 'allowMinus' => false
                ],
            ],
        ],
    ],
    'components' => [
        'formatter' => [
            'timeZone' => 'Europe/Madrid',
            'datetimeFormat' => $params['datetimeFormat'],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'lt4VIsdtcHs3NGMNyugo1vFFazD_A9EX',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
            /*
            // comment the following array to send mail using php's mail function:
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => $params['smtpUsername'],
                'password' => getenv('SMTP_PASS'),
                'port' => '587',
                'encryption' => 'tls',
            ],
            */
        ],
        'log' => $log,
        'db' => $db,
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
    'modules' => [
        'datecontrol' => [
            'class' => '\kartik\datecontrol\Module',
            'displaySettings' => [
                \kartik\datecontrol\Module::FORMAT_DATE => $params['dateFormat'],
                \kartik\datecontrol\Module::FORMAT_TIME => $params['timeFormat'],
                \kartik\datecontrol\Module::FORMAT_DATETIME => $params['datetimeFormat'],
            ],
            'saveSettings' => [
                \kartik\datecontrol\Module::FORMAT_DATE => 'php:Y-m-d',
                \kartik\datecontrol\Module::FORMAT_TIME => 'php:H:i:s',
                \kartik\datecontrol\Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
            ],
            'displayTimezone' => 'Europe/Madrid',
            'saveTimezone' => 'UTC',
            'autoWidgetSettings' => [
                \kartik\datecontrol\Module::FORMAT_DATETIME => [
                    'options' => [
                        'readonly' => true,
                    ],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'weekStart' => 1,
                    ],
                ],
                \kartik\datecontrol\Module::FORMAT_DATE => [
                    'options' => [
                        'readonly' => true,
                    ],
                ],
            ],
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
