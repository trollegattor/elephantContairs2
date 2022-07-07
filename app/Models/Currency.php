<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Currency extends Model
{
    use HasFactory;

    /** @var string[] */
    public $fillable = [
        'name',
        'symbol',
    ];
    /** @var string[]  */
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    /**
     * @return HasMany
     */
    public function price(): HasMany
    {
        return $this->hasMany(Price::class);
    }
}
