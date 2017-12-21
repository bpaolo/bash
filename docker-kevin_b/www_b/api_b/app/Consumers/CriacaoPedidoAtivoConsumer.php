<?php

namespace App\Consumers;

use App\Consumers\AbstractConsumer;
// Client
use App\Interfaces\SapClientInterface;
// Rules
use App\Requests\CriacaoPedidoAtivoRule;

class CriacaoPedidoAtivoConsumer extends AbstractConsumer
{
    protected function consume($payload){
		$integrate = SapClientInterface::send(CriacaoPedidoAtivoRule::parse($payload), CriacaoPedidoAtivoRule::$endpoint);
		return $integrate;
    }
}