<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $fillable = ['user_id', 'product_id', 'parent_comment_id', 'comment'];
    public function User()
    {
        return $this->belongsTo( User::class, 'user_id','id');
    }
    public function Product()
    {
        return $this->belongsTo( Product::class, 'product_id','id');
    }
    public function Parent()
    {
        return $this->belongsTo(Comment::class, 'parent_comment_id');
    }
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_comment_id');
    }
    public function hasChildren()
    {
        return $this->hasMany(Comment::class, 'parent_comment_id')->exists();
    }
}
