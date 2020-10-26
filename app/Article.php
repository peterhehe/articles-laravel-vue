<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Account
 * @package App\Models
 * @property string type
 * @property string name
 * @property string account_number
 * @property string implementation
 * @property string status
 * @property \DateTime created_by
 */

class Article extends Model
{
    use SoftDeletes;

    protected $table = 'articles';
    protected $dates = ['published_at'];
    
    protected $fillable = [
        'title',
        'content',
        'photo',
        'published_at'
    ];

    public function tags()
    {
        return $this->hasMany('App\Tag', 'article_id');
    }

    protected static function boot()
    {
        parent::boot();
    
        static::deleting(function ($article) {
            $article->tags()->delete();
        });
    }
}
