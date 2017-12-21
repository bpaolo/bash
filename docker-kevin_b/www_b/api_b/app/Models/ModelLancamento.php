<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelLancamento extends Model{
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
    protected $table = "SN003_Lancamentos";
    /**
     * Nome do campo da chave primária.
     *
     * @var string
     */
    protected $primaryKey = "NroLancamento";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'DataLancto',
        'DTIntegracao',
        'TID',
        'BandeiraID',
        'Valor',
        'Origem',
        'NroParcelas',
        'Estabelecimento',
    ];
}
