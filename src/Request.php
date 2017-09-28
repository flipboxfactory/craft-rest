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
}
