<?php

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

    /**
     * Parses the user request.
     * @param Request $request the request component
     * @return array|bool the route and the associated parameters. The latter is always empty
     * if [[enablePrettyUrl]] is `false`. `false` is returned if the current request cannot be successfully parsed.
     */
    public function parseRequest($request)
    {
        if (!$result = parent::parseRequest($request)) {
            var_dump($request);
        }

        return $result;
    }

}

