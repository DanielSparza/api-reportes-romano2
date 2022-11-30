<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comunidad extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'comunidades';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'clave_comunidad';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'comunidad',
        'fk_ciudad',
    ];

    public function cliente()
    {
        return $this->hasMany(Cliente::class, 'clientes');
    }

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'ciudades');
    }
}
