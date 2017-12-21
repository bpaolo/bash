<?php

namespace App\Consumers;

use App\Consumers\AbstractConsumer;
// Client
use App\Interfaces\SapClientInterface;
// Rules
use App\Requests\AtualizaStatusFinanceiroRule;

class AtualizaStatusFinanceiroConsumer extends AbstractConsumer
{
	protected function consume($payload){
		$integrate = SapClientInterface::send(AtualizaStatusFinanceiroRule::parse($payload), AtualizaStatusFinanceiroRule::$endpoint );
		return $integrate;
	}
}