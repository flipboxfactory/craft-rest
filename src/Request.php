<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://flipboxfactory.com/software/transformer/license
 * @link       https://www.flipboxfactory.com/software/transformer/
 */

namespace flipbox\rest;

use Craft;
use craft\base\RequestTrait;
use yii\web\HttpException;
use craft\helpers\StringHelper;
use yii\base\InvalidConfigException;
use yii\web\BadRequestHttpException;

/** @noinspection ClassOverridesFieldOfSuperClassInspection */

/**
 * @inheritdoc
 *
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 1.0.0
 */
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
