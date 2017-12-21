<?php

namespace App\Consumers;

use App\Consumers\AbstractConsumer;
// Client
use App\Interfaces\SapClientInterface;
// Rules
use App\Requests\CancelamentoDeContratoRule;

class CancelamentoDeContratoConsumer extends AbstractConsumer
{
    protected function consume($payload){
        $integrate = SapClientInterface::send(CancelamentoDeContratoRule::parse($payload), CancelamentoDeContratoRule::$endpoint);
        return $integrate;
    }
}