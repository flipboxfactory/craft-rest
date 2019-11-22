<?php

return [
    'components' => [
        'user' => function() {
            $stateKeyPrefix = md5('Craft.'.craft\web\User::class.'.'.Craft::$app->id);
            return Craft::createObject([
                'class' => craft\web\User::class,
                'identityClass' => craft\elements\User::class,
                'enableAutoLogin' => false,
                'autoRenewCookie' => false,
                'enableSession' => false,
                'identityCookie' => Craft::cookieConfig(['name' => $stateKeyPrefix.'_identity']),
                'usernameCookie' => Craft::cookieConfig(['name' => $stateKeyPrefix.'_username']),
                'loginUrl' => null,
                'idParam' => $stateKeyPrefix.'__id',
                'authTimeoutParam' => $stateKeyPrefix.'__expire',
                'absoluteAuthTimeoutParam' => $stateKeyPrefix.'__absoluteExpire',
                'returnUrlParam' => $stateKeyPrefix.'__returnUrl',
            ]);
        },
        'urlManager' => function() {
            $generalConfig = Craft::$app->getConfig()->getGeneral();
            return Craft::createObject([
                'class' => flipbox\craft\rest\UrlManager::class,
                'routeParam' => $generalConfig->pathParam,
                'enablePrettyUrl' => true,
                'enableStrictParsing' => true,
                'showScriptName' => false
            ]);
        },
        'request' => function() {
            $generalConfig = Craft::$app->getConfig()->getGeneral();
            return Craft::createObject([
                'class' => flipbox\craft\rest\Request::class,
                'enableCookieValidation' => true,
                'cookieValidationKey' => $generalConfig->securityKey,
                'enableCsrfValidation' => false,
                'parsers' => [
                    'application/json' => flipbox\craft\rest\JsonParser::class
                ]
            ]);
        },
        'log' => function() {
            $generalConfig = Craft::$app->getConfig()->getGeneral();
            $target = [
                'class' => craft\log\FileTarget::class,
                'fileMode' => $generalConfig->defaultFileMode,
                'dirMode' => $generalConfig->defaultDirMode,
                'includeUserIp' => $generalConfig->storeUserIps,
                'except' => [
                    yii\i18n\PhpMessageSource::class . ':*',
                ],
            ];

            $target['logFile'] = '@storage/logs/rest.log';

            // Only log errors and warnings, unless Craft is running in Dev Mode or it's being installed/updated
            $target['levels'] = yii\log\Logger::LEVEL_ERROR | yii\log\Logger::LEVEL_WARNING;
            if (YII_DEBUG) {
                $target['levels'] = $target['levels'] | yii\log\Logger::LEVEL_INFO;
            }

            return Craft::createObject([
                'class' => yii\log\Dispatcher::class,
                'targets' => [
                    $target,
                ]
            ]);
        },
        'response' => [
            'class' => yii\web\Response::class,
            'format' => yii\web\Response::FORMAT_JSON
        ],
        'errorHandler' => [
            'class' => yii\web\ErrorHandler::class,
        ]
    ],
    'modules' => [
        'debug' => null
    ],
    'bootstrap' => []
];