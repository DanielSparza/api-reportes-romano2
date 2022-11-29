<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'clientes';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'fk_clave_persona';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fk_clave_persona',
        'direccion',
        'nexterior',
        'ninterior',
        'colonia',
        'fk_comunidad',
        'estado',
        'telefono_fijo',
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'personas');
    }

    public function servicio()
    {
        return $this->hasMany(Servicio::class, 'servicios');
    }

    public function comunidad()
    {
        return $this->belongsTo(Comunidad::class, 'comunidades');
    }
}
