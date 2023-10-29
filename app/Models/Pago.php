<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pago extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'monto',
        'pago_tipo_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'monto' => 'float',
        'pago_tipo_id' => 'integer',
    ];

    public function citas(): HasMany
    {
        return $this->hasMany(Cita::class);
    }

    public function pagoTipo(): BelongsTo
    {
        return $this->belongsTo(PagoTipo::class);
    }
}
