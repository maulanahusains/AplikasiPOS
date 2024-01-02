<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $keyType = 'string';
    protected $increment = false;
    protected $fillable = [
        'category'
    ];

    /**
     * Get all of the comments for the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Category()
    {
        return $this->hasMany(Category::class, 'id_category', 'id');
    }
}
