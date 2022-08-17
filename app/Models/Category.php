<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image', 'parent_id'];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id')->withDefault();
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getNameAttribute($name)
    {
        if($name) {
            return json_decode($name, true)[app()->currentLocale()];
        }
        return $name;
    }

    // protected function name(): Attribute
    // {
    //     return Attribute::make(
    //         get: function ($value) {
    //             if($value) {
    //                 return json_decode($value, true)[app()->currentLocale()];
    //             }
    //             return $value;
    //         }
    //     );
    // }
}
