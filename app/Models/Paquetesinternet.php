<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paquetesinternet extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'paquetesinternet';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'clave_paquete';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'velocidad',
        'costo',
        'periodo',
        'descripcion',
    ];

    public function servicio()
    {
        return $this->hasMany(Servicio::class, 'servicios');
    }
}
