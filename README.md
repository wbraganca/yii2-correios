# yii2-correios

[![Latest Version](https://img.shields.io/github/release/wbraganca/yii2-correios.svg?style=flat-square)](https://github.com/wbraganca/yii2-correios/releases)
[![Software License](http://img.shields.io/badge/license-BSD3-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/wbraganca/yii2-correios.svg?style=flat-square)](https://packagist.org/packages/wbraganca/yii2-correios)


## Install

Via Composer

```bash
$ composer require wbraganca/yii2-correios
```

or add

```
"wbraganca/yii2-correios": "*"
```

to the require section of your `composer.json` file.


## Usage

###Raw search.

```php
<?php

use wbraganca\correios\AddressSearchByCep;

$obj = new AddressSearchByCep();
$result = $obj->search('22021-001');
/* OUTPUT
array(
    'location' => 'Avenida Atlântica - de 1662 a 2172 - lado pa'
    'district' => 'Copacabana'
    'city' => 'Rio de Janeiro'
    'state' => 'RJ'
    'cep' => '22021-001'
    'result' => 1
    'result_text' => 'Address found.'
);
*/

```

###On your controller.

```php
public function actions()
{
    return [
        'searchAddress' => 'wbraganca\correios\CepAction'
    ];
}
```
http:://example.com/your-controller/searchAddress?cep=22021-001
