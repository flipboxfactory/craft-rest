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
class UrlRule extends \yii\rest\UrlRule
{
    /**
     * The prefix to the action
     *
     * @var string
     */
    public $prepend;

    /**
     * @inheritdoc
     */
    protected function createRule($pattern, $prefix, $action)
    {
        if (!empty($this->prepend)) {
            $action = $this->prepend . '/' . $action;
        }

        return parent::createRule($pattern, $prefix, $action);
    }
}
