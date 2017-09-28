<?php
/**
 * @link      http://buildwithcraft.com/
 * @copyright Copyright (c) 2015 Pixel & Tonic, Inc.
 * @license   http://buildwithcraft.com/license
 */

namespace flipbox\rest;

use Craft;
use craft\base\RequestTrait;
use yii\web\HttpException;
use craft\helpers\StringHelper;
use yii\base\InvalidConfigException;
use yii\web\BadRequestHttpException;

class Request extends \craft\web\Request
{

    /**
     * @inheritdoc
     */
    public function getIsRestRequest(): bool
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function getIsSiteRequest(): bool
    {
        return false;
    }

//    /**
//     * Resolves the current request into a route and the associated parameters.
//     * @return array the first element is the route, and the second is the associated parameters.
//     * @throws NotFoundHttpException if the request cannot be resolved.
//     */
//    public function resolve()
//    {
//        $result = Craft::$app->getUrlManager()->parseRequest($this);
//        if ($result !== false) {
//            list ($route, $params) = $result;
//            if ($this->_queryParams === null) {
//                $_GET = $params + $_GET; // preserve numeric keys
//            } else {
//                $this->_queryParams = $params + $this->_queryParams;
//            }
//            return [$route, $this->getQueryParams()];
//        } else {
//            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
//        }
//    }

}
