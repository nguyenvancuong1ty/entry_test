<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prefecture extends Model
{
    /**
     * @var string
     */
    protected $primaryKey = 'prefecture_id';

    /**
     * @var array
     */
    protected $guarded = ['prefecture_id'];

    /**
     * @return HasMany
     */
    public function hotel(): HasMany
    {
        return $this->hasMany(Hotel::class);
    }
}
