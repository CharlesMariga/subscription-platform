<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;

    public function posts()
    {
        $this->hasMany(Post::class);
    }

    public function subscription() {
        $this->belongsToMany(Subscription::class);
    }
}
