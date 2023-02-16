<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\ShopMenus\Database\factories\MenuOptionTranslationFactory;

class Language extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'active',
        'position',
    ];
    public static function updateCache()
    {
        cache()->forget('activeLanguages');
        cache()->remember('activeLanguages', config('default.app.cache.ttl_seconds'), function () {
            return Language::where('active', true)->get();
        });
    }
    protected static function newFactory()
    {
        return MenuOptionTranslationFactory::new();
    }
}
