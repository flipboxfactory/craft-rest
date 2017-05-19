<?php

return [
    'components' => [
        'user' => function() {

            $stateKeyPrefix = md5('Craft.'.craft\web\User::class.'.'.Craft::$app->id);

            return Craft::createObject([
                'class' => craft\web\User::class,
                'identityClass' => flipbox\rest\UserIdentity::class,
                'enableAutoLogin' => false,
                'autoRenewCookie' => false,
                'enableSession' => false,
                'usernameCookie' => null,
                'identityCookie' => null,
                'loginUrl' => null,
                'idParam' => $stateKeyPrefix.'__id',
                'authTimeoutParam' => $stateKeyPrefix.'__expire',
                'absoluteAuthTimeoutParam' => $stateKeyPrefix.'__absoluteExpire',
                'returnUrlParam' => $stateKeyPrefix.'__returnUrl',
            ]);
        },
        'urlManager' => [
            'class' => flipbox\rest\UrlManager::class,
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false
        ],
        'request' => [
            'class' => flipbox\rest\Request::class,
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false,
            'parsers' => [
                'application/json' => yii\web\JsonParser::class
            ],
            'acceptableContentTypes' => [
                'application/json' => ['q' => 1, 'version' => '1.0'],
                'application/xml' => ['q' => 1, 'version' => '2.0']
            ]
        ],
        'response' => [
            'class' => flipbox\rest\Response::class,
            'format' => flipbox\rest\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
            'formatters' => [
                'json' => flipbox\rest\JsonPrettyResponseFormatter::class,
            ]
        ],
        'errorHandler' => [
            'class' => yii\web\ErrorHandler::class,
            'errorAction' => function() {
                throw new yii\web\NotFoundHttpException(
                    Craft::t('rest', 'Resource Not Found.')
                );
            }
        ]
    ],
    'modules' => [
        'debug' => null
    ],
];
