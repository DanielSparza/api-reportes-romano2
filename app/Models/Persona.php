<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'personas';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'clave_persona';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'fk_ciudad',
        'telefono_movil',
        'estatus',
    ];

    public function usuario()
    {
        return $this->hasOne(User::class, 'usuarios');
    }

    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'clientes');
    }

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'ciudades');
    }
}
