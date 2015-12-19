<?php

/**
 * @link      https://github.com/wbraganca/yii2-correios
 * @copyright Copyright (c) 2015 Wanderson Bragança
 * @license   https://github.com/wbraganca/yii2-correios/blob/master/LICENSE
 */

namespace wbraganca\correios;

use Yii;
use yii\helpers\Json;
use yii\validators\Validator;

/**
 * CepValidator checks if the attribute value is a valid CEP.
 *
 * @author Wanderson Bragança <wanderson.wbc@gmail.com>
 */
class CepValidator extends Validator
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = Yii::t('wb_correios', 'CEP invalid.');
        }
    }

    /**
     * @inheritdoc
     */
    protected function validateValue($value)
    {
        $value = str_replace('-', '', trim($value));
        $valid = preg_match('/^[0-9]{8}$/', $value, $matches);

        return ($valid === 1) ? [] : [$this->message, []];
    }
}
