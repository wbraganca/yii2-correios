<?php

/**
 * @link      https://github.com/wbraganca/yii2-correios
 * @copyright Copyright (c) 2015 Wanderson Bragança
 * @license   https://github.com/wbraganca/yii2-correios/blob/master/LICENSE
 */

namespace wbraganca\correios;

use Yii;
use SoapFault;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use wbraganca\correios\CepValidator;
use wbraganca\correios\AddressSearchBase;

/**
 * Class AddressSearchByCep search addresses in Brazil using the CEP.
 *
 * @author Wanderson Bragança <wanderson.wbc@gmail.com>
 */
class AddressSearchByCep extends AddressSearchBase
{
    /**
     * Search address by CEP
     * @param string $q query
     * @return array
     */
    public function search($cep)
    {
        $cep = trim($cep);
        $validator = new CepValidator();

        if ($validator->validate($cep, $error) === false) {
            return [
                'result' => 0,
                'result_text' => $error
            ];
        }

        $output = [
            'result' => 0,
            'result_text' => Yii::t('wb_correios', 'Address not found.')
        ];

        try {
            $soapClient = $this->getSoapClient();
            $soapClientResult = $soapClient->consultaCEP(['cep' => $cep]);
            $output = [
                'location' => $soapClientResult->return->end,
                'district' => $soapClientResult->return->bairro,
                'city' => $soapClientResult->return->cidade,
                'state' => $soapClientResult->return->uf,
                'cep' => $cep,
                'result' => 1,
                'result_text' => Yii::t('wb_correios', 'Address found.'),
            ];
        } catch (SoapFault $fault) {
            $output = [
                'result' => 0,
                'result_text' => Yii::t('wb_correios', $fault->faultstring)
            ];
        }

        return $output;
    }
}
