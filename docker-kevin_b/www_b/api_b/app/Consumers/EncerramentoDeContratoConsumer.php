<?php

namespace App\Consumers;

use App\Consumers\AbstractConsumer;
// Client
use App\Interfaces\SapClientInterface;
// Rules
use App\Requests\EncerramentoDeContratoRule;

class EncerramentoDeContratoConsumer extends AbstractConsumer
{
    protected function consume($payload){
        $integrate = SapClientInterface::send(EncerramentoDeContratoRule::parse($payload), EncerramentoDeContratoRule::$endpoint);
        return $integrate;
    }
}
