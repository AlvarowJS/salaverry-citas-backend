<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cita extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fecha',
        'silla',
        'hora',
        'pago',
        'confirmar',
        'llego',
        'entro',
        'observacion',
        'user_id',
        'paciente_id',
        'consultorio_id',
        'medico_id',
        'pago_tipo_id',        
        'estado_id',
        'multiuso',
        'multiuso_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        // 'fecha' => 'date',
        'silla' => 'boolean',
        // 'hora' => 'datetime',
        'confirmar' => 'boolean',
        'multiuso' => 'boolean',
        'user_id' => 'integer',
        'paciente_id' => 'integer',
        'consultorio_id' => 'integer',
        'medico_id' => 'integer',
        'pago_tipo_id' => 'integer',
        'estado_id' => 'integer',
        'multiuso_id' => 'integer'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class);
    }

    public function consultorio(): BelongsTo
    {
        return $this->belongsTo(Consultorio::class);
    }

    public function medico(): BelongsTo
    {
        return $this->belongsTo(Medico::class);
    }

    public function pagoTipo(): BelongsTo
    {
        return $this->belongsTo(PagoTipo::class);
    }

    public function estado(): BelongsTo
    {
        return $this->belongsTo(Estado::class);
    }
}
