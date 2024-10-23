<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'user_id', 'contentt', 'parent_id'];

    public function replies(){
     
        return $this->hasMany(Comment::class,'parent_id');
    }


   
}
