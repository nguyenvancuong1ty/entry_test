<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prefecture extends Model
{
    /**
     * @var string
     */
    protected $primaryKey = 'prefecture_id';

    /**
     * @var list<string>
     */
    protected $guarded = ['prefecture_id'];

    /**
     * Get hotels in this prefecture
     */
    public function hotels(): HasMany
    {
        return $this->hasMany(Hotel::class, 'prefecture_id', 'prefecture_id');
    }

    /**
     * Alias for backward compatibility
     */
    public function hotel(): HasMany
    {
        return $this->hotels();
    }

    /**
     * Get the resolved public URL of the prefecture image
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function (): ?string {
                if (empty($this->file_path)) {
                    return null;
                }

                return asset('assets/img/' . $this->file_path);
            },
        );
    }
}
