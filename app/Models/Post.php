<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiTrait;

class Post extends Model
{
    use HasFactory, ApiTrait;

    const DRAFT = 1;
    const PUBLISHED = 2;

    protected $fillable = [
        'title',
        'slug',
        'extract',
        'body',
        'status',
        'category_id',
        'user_id',
    ];

    protected $allowedIncludes = [
        'user',
        'category',
    ];

    protected $allowedFilters = [
        'id',
        'title',
        'slug',
        'extract',
        'body',
        'status',
        'category_id',
        'user_id',
    ];

    protected $allowedSorts = [
        'title',
        'slug',
        'extract',
        'body',
        'status',
        'category_id',
        'user_id',
    ];

    //relationships with User one to many inverse
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //relationships with Category one to many inverse
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    //relationships with Tag many to many
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    //relationships with Image Morphs
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
