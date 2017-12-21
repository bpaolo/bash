<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelPVteste extends Model
{
    /**
     * Nome da tabela representada pelo model.
     *
     * @var string
     */
    protected $connection = "vetor";
    /**
     * Nome da tabela representada pelo model.
     *
     * @var string
     */
    protected $table = "SN003_PedidoVenda";
    /**
     * Nome do campo da chave primária.
     *
     * @var string
     */
    protected $primaryKey = "PedidoID";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'PedidoID',
        'VendedorID',
        'ValorVenda',
        'ValorDesconto',
    ];
}
