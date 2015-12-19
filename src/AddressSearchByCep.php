<?php

/**
 * @link      https://github.com/wbraganca/yii2-correios
 * @copyright Copyright (c) 2015 Wanderson Bragança
 * @license   https://github.com/wbraganca/yii2-correios/blob/master/LICENSE
 */

namespace wbraganca\correios;

use Yii;
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
     * Parse html content and returning cep data
     * @param string $html
     * @return array
     */
    private function parseHTML($html)
    {
        $output = [
            'result' => 0,
            'result_text' => Yii::t('wb_correios', 'Address not found.')
        ];
        $pattern = '/<table border="0" cellspacing="1" cellpadding="5" bgcolor="gray">(.*?)<\/table>/is';

        if ($html && preg_match($pattern, $html, $matches)) {
            $domDoc = new \DOMDocument();
            if ($domDoc->loadHTML($matches[0])) {
                $rows = $domDoc->getElementsByTagName('tr');
                foreach ($rows as $tr) {
                    $cols = $tr->getElementsByTagName('td');
                    $output = [
                        'location' => $cols->item(0)->nodeValue,
                        'district' => $cols->item(1)->nodeValue,
                        'city' => $cols->item(2)->nodeValue,
                        'state' => $cols->item(3)->nodeValue,
                        'cep' => $cols->item(4)->nodeValue,
                        'result' => 1,
                        'result_text' => Yii::t('wb_correios', 'Address found.'),
                    ];
                }
            }
        }

        return $output;
    }

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

        $params = array_merge([$this->formData['TipoConsulta'] => $cep], $this->formData);
        $streamContextOptions = [
            'http' => [
               'method' => 'POST',
               'header' => 'Content-type: application/x-www-form-urlencoded',
               'content' => http_build_query($params)
            ]
        ];

        $streamContext = stream_context_create($streamContextOptions);
        $html = @file_get_contents(self::URL_CORREIOS, false, $streamContext);
        return $this->parseHTML($html);
    }
}
