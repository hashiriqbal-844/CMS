<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class post extends Model
{
    use SoftDeletes; 


    use HasFactory;

    protected $date = [
        'published_at'
    ];

    protected $fillable = [
        'title',
        'description',
        'content',
        'image',
        'published_at',
        'category_id',
        'user_id'

    ];
    public function category()
    {
        return $this->belongsTo(category::class);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * check if post has tag
     * 
     * @return bool
     */
    public function hasTag($tagId)
    {
        return in_array($tagId, $this->tags->pluck('id')->toArray());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function scopePublished($query)
    {
        return $query->where('published_at','<=',Now());
    }
    public function scopeSearched($query)
    {
        $search = (request()->query('search'));
        if(!$search)
        {
            return $query->published();
        }

        return $query->published()->where('title','LIKE',"%{$search}%");
    }
}
