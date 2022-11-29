<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'reportes';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'clave_reporte';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fk_servicio',
        'problema',
        'veces_reportado',
        'reporto',
        'fecha_reporte',
        'hora_reporte',
        'estatus',
        'fk_tecnico',
        'fecha_finalizacion',
        'hora_finalizacion',
        'observaciones',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuarios');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicios');
    }
}
