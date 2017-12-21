<?php

namespace App\Consumers;

use App\Consumers\AbstractConsumer;
// Client
use App\Interfaces\SapClientInterface;
// Rules
use App\Requests\AberturaDeContratoRule;

class AberturaDeContratoConsumer extends AbstractConsumer
{
    protected function consume($payload){
        $integrate = SapClientInterface::send(AberturaDeContratoRule::parse($payload), AberturaDeContratoRule::$endpoint);
        return $integrate;
    }
}
