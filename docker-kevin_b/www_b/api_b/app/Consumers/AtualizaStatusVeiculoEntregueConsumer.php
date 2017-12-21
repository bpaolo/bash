<?php

namespace App\Consumers;

use App\Consumers\AbstractConsumer;
// Client
use App\Interfaces\SapClientInterface;
// Rules
use App\Requests\AtualizaStatusVeiculoEntregueRule;

class AtualizaStatusVeiculoEntregueConsumer extends AbstractConsumer
{
    protected function consume($payload){
        $integrate = SapClientInterface::send(AtualizaStatusVeiculoEntregueRule::parse($payload), AtualizaStatusVeiculoEntregueRule::$endpoint);
        return $integrate;
    }
}