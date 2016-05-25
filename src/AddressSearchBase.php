<?php

/**
 * @link      https://github.com/wbraganca/yii2-correios
 * @copyright Copyright (c) 2015 Wanderson Bragança
 * @license   https://github.com/wbraganca/yii2-correios/blob/master/LICENSE
 */

namespace wbraganca\correios;

use Yii;
use SoapClient;

/**
 * Class AddressSearchBase is the base class for yii2-correios
 *
 * @author Wanderson Bragança <wanderson.wbc@gmail.com>
 */
abstract class AddressSearchBase
{
    /**
     * @var string
     */
    public $wsdl = 'https://apps.correios.com.br/SigepMasterJPA/AtendeClienteService/AtendeCliente?wsdl';
    /**
     * @var SoapClient
     */
    private $_soapClient;

    /**
     * @param array $formData
     */
    public function __construct()
    {
        $this->initI18N();
    }

    /**
     * @return SoapClient
     */
    protected function getSoapClient()
    {
        if (!isset($this->_soapClient)) {
            $this->_soapClient = new SoapClient($this->wsdl);
        }

        return $this->_soapClient;
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
