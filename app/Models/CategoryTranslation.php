<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'category_translations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'locale',
        'name',
        'description',
        'meta_title',
        'meta_description',
        'slug',
    ];

    /**
     * Get the category that owns the translation.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
