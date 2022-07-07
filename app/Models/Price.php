<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Price extends Model
{
    use HasFactory;

    /** @var string[] */
    public $fillable = [
        'carrier',
        'origin',
        'destination',
        'price_container',
        'expiration_date',
        'currency_id'
    ];
    /** @var string[] */
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    /** @var string[]  */
    protected $with=[
        'port_origin',
        'port_destination',
        'currency'];
    /**
     * @return BelongsTo
     */
    public function port_origin(): BelongsTo
    {
        return $this->belongsTo(Port::class,'origin');
    }

    /**
     * @return BelongsTo
     */
    public function port_destination(): BelongsTo
    {
        return $this->belongsTo(Port::class,'destination',);
    }

    /**
     * @return BelongsTo
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
}

