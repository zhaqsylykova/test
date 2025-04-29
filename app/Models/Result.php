<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = ['story_id', 'nickname', 'path'];

    public function story()
    {
        return $this->belongsTo(Story::class);
    }
}
