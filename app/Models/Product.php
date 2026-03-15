<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'category',
        'description',
        'price',
        'image',
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
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function getImageUrlAttribute(): string
    {
        if (! $this->image) {
            return asset('images/lemorfood1.png');
        }

        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }

        $storageUrl = Storage::url($this->image);
        $publicPath = public_path(ltrim($storageUrl, '/'));

        if (is_file($publicPath)) {
            return $storageUrl;
        }

        return asset('images/lemorfood1.png');
    }
}
