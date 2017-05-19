<?php

namespace flipbox\rest;

use Yii;
use yii\helpers\Json;
use yii\web\Response;

class JsonPrettyResponseFormatter extends \yii\web\JsonResponseFormatter
{

    /**
     * Formats response data in JSON format.
     * @param Response $response
     */
    protected function formatJson($response)
    {
        $response->getHeaders()->set('Content-Type', 'application/json; charset=UTF-8');
        if ($response->data !== null) {
            $response->content = Json::encode($response->data, JSON_PRETTY_PRINT);
        }
    }

}
