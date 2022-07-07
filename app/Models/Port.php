<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Port extends Model
{
    use HasFactory;

    /** @var string[] */
    public $fillable = [
        'name',
        'iso_code',
        'country',
    ];
    /** @var string[] */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * @return HasMany
     */
    public function price(): HasMany
    {
        return $this->hasMany(Price::class,'origin');
    }
}
