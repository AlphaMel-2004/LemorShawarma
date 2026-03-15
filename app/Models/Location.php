<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Location extends Model
{
    /** @use HasFactory<\Database\Factories\LocationFactory> */
    use HasFactory, SoftDeletes;

    /** @var list<string> */
    protected $fillable = [
        'name',
        'address',
        'phone',
        'hours',
        'image',
        'latitude',
        'longitude',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
            'is_active' => 'boolean',
        ];
    }

    public function getImageUrlAttribute(): string
    {
        if (! $this->image) {
            return asset('images/lemorfood3.png');
        }

        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }

        $storageUrl = Storage::url($this->image);
        $publicPath = public_path(ltrim($storageUrl, '/'));

        if (is_file($publicPath)) {
            return $storageUrl;
        }

        return asset('images/lemorfood3.png');
    }
}
