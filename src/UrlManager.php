<?php
/**
 * @link      http://buildwithcraft.com/
 * @copyright Copyright (c) 2015 Pixel & Tonic, Inc.
 * @license   http://buildwithcraft.com/license
 */

namespace flipbox\rest;

use craft\events\RegisterUrlRulesEvent;

class UrlManager extends \yii\web\UrlManager
{

    const EVENT_REGISTER_REST_URL_RULES = 'registerRestUrlRules';

    /**
     * @inheritdoc
     */
    public function __construct(array $config = [])
    {
        $config['rules'] = $this->_getRules();
        parent::__construct($config);
    }

    /**
     * @return array
     */
    private function _getRules()
    {

        $event = new RegisterUrlRulesEvent();
        $this->trigger(
            self::EVENT_REGISTER_REST_URL_RULES,
            $event
        );

        return array_filter($event->rules);

    }

}

