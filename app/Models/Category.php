<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiTrait;

class Category extends Model
{
    use HasFactory, ApiTrait;

    protected $fillable = [
        'name',
        'slug',
    ];

    protected $allowedIncludes = [
        'posts',
        'posts.user',
        'posts.category',
    ];

    protected $allowedFilters = [
        'id',
        'name',
        'slug',
    ];

    protected $allowedSorts = [
        'id',
        'name',
        'slug',
    ];

    //relationships with Post one to many 
    public function posts()
    {
        return $this->hasMany(Post::class);

    }

    

}
