<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelFrota extends Model
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
    protected $table = "F001_Frotas";
    /**
     * Nome do campo da chave primária.
     *
     * @var string
     */
    protected $primaryKey = "FrotaID";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'FrotaID',
        'Chassi',
        'Placa',
        'L001_FilialID_Atual',
        'StatusID',
        'Renavam'
    ];
}
