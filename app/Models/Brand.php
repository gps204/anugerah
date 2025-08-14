<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'logo_url',
        'status',
    ];

    /**
     * Relasi ke semua terjemahan.
     */
    public function translations()
    {
        return $this->hasMany(BrandTranslation::class);
    }

    /**
     * Relasi ke satu terjemahan berdasarkan locale aplikasi saat ini.
     * Ini sangat berguna untuk mengambil nama yang sudah diterjemahkan.
     */
    public function translation()
    {
        $languageCode = app()->getLocale();
        return $this->hasOne(BrandTranslation::class)->where('language_code', $languageCode)
            ->withDefault(fn () => new BrandTranslation(['name' => $this->slug]));
    }

    /**
     * Get the products for the brand.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}