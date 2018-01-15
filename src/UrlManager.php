<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://flipboxfactory.com/software/transformer/license
 * @link       https://www.flipboxfactory.com/software/transformer/
 */

namespace flipbox\craft\rest;

use Craft;
use craft\events\RegisterUrlRulesEvent;

/**
 * @inheritdoc
 *
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 1.0.0
 */
class UrlManager extends \yii\web\UrlManager
{

    const EVENT_REGISTER_REST_URL_RULES = 'registerRestUrlRules';

    /**
     * @inheritdoc
     */
    public function __construct(array $config = [])
    {
        $config['rules'] = $this->getRules();
        parent::__construct($config);
    }

    /**
     * @return array
     */
    private function getRules()
    {
        $event = new RegisterUrlRulesEvent();
        $this->trigger(
            self::EVENT_REGISTER_REST_URL_RULES,
            $event
        );

        return array_filter($event->rules);
    }

    /**
     * @inheritdoc
     */
    public function parseRequest($request)
    {
        if (!$result = parent::parseRequest($request)) {
            Craft::warning("Unable to parse request: " . $request->getUrl());
        }

        return $result;
    }
}
