<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'cod_cidade', 'descricao', 'estoque', 'valor', 'marca_cod'
    ];

    public function marca()
    {
        return $this->hasOne(Marca::class, 'cod_marca', 'marca_cod');
    }

    public function cidade()
    {
        return $this->hasOne(Cidade::class, 'id', 'cod_cidade');
    }
}
