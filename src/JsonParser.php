<?php
/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://flipboxfactory.com/software/transformer/license
 * @link       https://www.flipboxfactory.com/software/transformer/
 */

namespace flipbox\craft\rest;

/**
 * Class JsonParser
 * @package flipbox\craft\rest
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
                $arr[$key] = '';
            }
            if (is_array($value)) {
                $arr[$key] = $this->filterNullValuesFromArray($value);
            }
        }

        return $arr;
    }
}
