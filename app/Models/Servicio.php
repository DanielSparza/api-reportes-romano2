<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'servicios';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'clave_servicio';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fk_paquete',
        'fk_cliente',
        'latitud',
        'longitud',
        'foto_fachada',
    ];

    public function reporte()
    {
        return $this->hasMany(Reporte::class, 'reportes');
    }

    public function paquete()
    {
        return $this->belongsTo(Paquetesinternet::class, 'paquetesinternet');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'clientes');
    }
}
