<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datosempresa extends Model
{
    use HasFactory;

     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'datosempresa';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'clave_empresa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'eslogan',
        'logo',
        'imagen_fondo',
        'sobre_nosotros',
        'direccion',
        'ciudad',
        'telefono',
        'correo',
        'facebook',
        'whatsapp',
    ];
}
