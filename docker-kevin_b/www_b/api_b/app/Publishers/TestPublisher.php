<?php

namespace App\Publishers;

use App\Publishers\AbstractFetcher;
use GuzzleHttp;

class TestPublisher extends AbstractPublisher
{
	/**
     * Função que envia para o SAP
     *
     * @return array
     */
    public function fetch(array $array = null){
    	return false;
    }
}