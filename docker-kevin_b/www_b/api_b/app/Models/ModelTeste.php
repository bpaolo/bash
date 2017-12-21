<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelTeste extends Model
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
    protected $table = "A001_Moedas";
    /**
     * Nome do campo da chave primária.
     *
     * @var string
     */
    protected $primaryKey = "MoedaID";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Moeda',
        'Sigla',
        'StatusID',
        'CodigoISO',
    ];
}
