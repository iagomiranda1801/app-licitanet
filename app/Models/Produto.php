<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'cod_marca', 'descricao', 'estoque', 'valor', 'marca_cod', 'cod_marca'
    ];

    public function marca()
    {
        return $this->hasOne(Marca::class, 'marca_cod', 'cod_marca');
    }

    public function cidade()
    {
        return $this->hasOne(Cidade::class, 'cod_cidade', 'cod_cidade');
    }
}
