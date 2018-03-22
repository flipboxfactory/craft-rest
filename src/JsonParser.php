<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipboxfactory/craft-rest/blob/master/LICENSE
 * @link       https://github.com/flipboxfactory/craft-rest
 */

namespace flipbox\craft\rest;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 1.0.0
 */
class JsonParser extends \yii\web\JsonParser
{
    /**
     * @inheritdoc
     */
    public function parse($rawBody, $contentType)
    {
        $bodyParams = parent::parse($rawBody, $contentType);
        $bodyParams = $this->filterNullValuesFromArray($bodyParams);
        return $bodyParams;
    }

    /**
     * Filters null values from an array.
     * @param array $arr
     * @return array
     */
    public function filterNullValuesFromArray(array $arr): array
    {
        foreach ($arr as $key => $value) {
            if ($value === null) {
                unset($arr[$key]);
            }
            if (is_array($value)) {
                $arr[$key] = $this->filterNullValuesFromArray($value);
            }
        }

        return $arr;
    }
}
