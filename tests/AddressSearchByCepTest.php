<?php

namespace wbraganca\correios\test;

use wbraganca\correios\AddressSearchByCep;

class AddressSearchByCepTest extends \PHPUnit_Framework_TestCase
{
    public function testValidCep()
    {
        $expected = [
            'location' => 'Avenida Atlântica',
            'district' => 'Copacabana',
            'city' => 'Rio de Janeiro',
            'state' => 'RJ',
            'cep' => '22021-001',
            'result' => 1,
            'result_text' => 'Address found.'
        ];

        $obj = new AddressSearchByCep();
        $result = $obj->search('22021-001');
        $this->assertEquals($expected, $result);
    }

    public function testInvalidCep()
    {
        $expected = [
            'result' => 0,
            'result_text' => 'CEP invalid.'
        ];

        $obj = new AddressSearchByCep();
        $result = $obj->search('000000');
        $this->assertEquals($expected, $result);
    }

    public function testCEPNotFound()
    {
        $expected = [
            'result' => 0,
            'result_text' => 'Address not found.'
        ];

        $obj = new AddressSearchByCep();
        $result = $obj->search('24010500');
        $this->assertEquals($expected, $result);
    }
}
