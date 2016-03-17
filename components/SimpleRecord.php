<?php
/**
 * SimpleRecord.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace Plp\components;

/**
 * Class SimpleRecord
 * @package Plp\components
 */
abstract class SimpleRecord
{

    /**
     * @param array $attributes
     */
    public function setAttributes(array $attributes)
    {
        if (!empty($attributes)) {
            foreach ($attributes as $attribute => $value) {
                $this->$attribute = $value;
            }
        }
    }
}