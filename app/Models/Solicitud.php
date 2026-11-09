<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    protected $table = 'solicitudes';

    protected $fillable = [
        'numero_solicitud',
        'cliente_id',
        'equipo_id',
        'fecha_recepcion',
        'tipo_servicio',
        'descripcion_problema',
        'estado',
        'observaciones',
    ];

    protected $casts = [
        'fecha_recepcion' => 'date',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'equipo_id', 'id');
    }

    public function historialEstados()
    {
        return $this->hasMany(HistorialEstado::class)
            ->orderBy('fecha_cambio')
            ->orderBy('id');
    }
}
