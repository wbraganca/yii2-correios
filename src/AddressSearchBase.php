<?php

/**
 * @link      https://github.com/wbraganca/yii2-correios
 * @copyright Copyright (c) 2015 Wanderson Bragança
 * @license   https://github.com/wbraganca/yii2-correios/blob/master/LICENSE
 */

namespace wbraganca\correios;

use Yii;

/**
 * Class AddressSearchBase is the base class for yii2-correios
 *
 * @author Wanderson Bragança <wanderson.wbc@gmail.com>
 */
abstract class AddressSearchBase
{
    const URL_CORREIOS = 'http://www.buscacep.correios.com.br/servicos/dnec/consultaEnderecoAction.do';
    /**
     * @var array data sent in request
     */
    protected $formDataDefaultValues = [
        'TipoCep' => 'ALL',
        'semelhante' => 'N',
        'cfm' => '1',
        'Metodo' => 'listaLogradouro',
        'TipoConsulta' => 'relaxation',
        'StartRow' => '1',
        'EndRow' => '10'
    ];
    /**
     * @var array data sent in request
     */
    public $formData = [];

    /**
     * @param array $formData
     */
    public function __construct($formData = [])
    {
        $this->formData = array_merge($this->formDataDefaultValues, $formData);
        $this->initI18N();
    }

    /**
     * Yii i18n messages configuration for generating translations
     * @return void
     */
    protected function initI18N()
    {
        if (empty(Yii::$app->i18n->translations['wb_correios'])) {
            Yii::setAlias("@wb_correios", __DIR__);
            Yii::$app->i18n->translations['wb_correios'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => "@wb_correios/messages",
                'forceTranslation' => true
            ];
        }
    }
}
