<?php

/**
 * @link      https://github.com/wbraganca/yii2-correios
 * @copyright Copyright (c) 2015 Wanderson Bragança
 * @license   https://github.com/wbraganca/yii2-correios/blob/master/LICENSE
 */

namespace wbraganca\correios;

use Yii;
use yii\web\Response;
use wbraganca\correios\AddressSearchByCep;

/**
 * Class CepAction search addresses in Brazil using the CEP.
 *
 * @author Wanderson Bragança <wanderson.wbc@gmail.com>
 */
class CepAction extends \yii\base\Action
{
    /**
     * @var string name of query parameter
     */
    public $queryParam = 'cep';

    /**
     * Searches address by cep or location
     * @return array cep data
     * @throws NotFoundHttpException
     */
    public function run()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $query = Yii::$app->request->get($this->queryParam);
        $obj = new AddressSearchByCep();

        return $obj->search($query);
    }
}
