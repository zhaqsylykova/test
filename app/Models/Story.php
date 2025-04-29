<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author_name'];

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }
}
