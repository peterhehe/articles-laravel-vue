<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;

    protected $table = 'tags';
        
    protected $fillable = [
        'article_id',
        'tag'
    ];

    public function article()
    {
        return $this->belongsTo('App\Article', 'article_id');
    }
}
