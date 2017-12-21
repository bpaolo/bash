<?php

namespace App\Consumers;

use App\Consumers\AbstractConsumer;
// Client
use App\Interfaces\SapClientInterface;
// Rules
use App\Requests\MovimentacaoAtivosRule;

class MovimentacaoAtivosConsumer extends AbstractConsumer{
	
	protected function consume($payload){
        
        $integrate = SapClientInterface::send(MovimentacaoAtivosRule::parse($payload), MovimentacaoAtivosRule::$endpointSAP);

        return $integrate;
	}

}
