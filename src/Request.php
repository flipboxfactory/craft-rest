<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipboxfactory/craft-rest/blob/master/LICENSE
 * @link       https://github.com/flipboxfactory/craft-rest
 */

namespace flipbox\craft\rest;

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
