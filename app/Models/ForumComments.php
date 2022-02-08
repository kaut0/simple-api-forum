<?php

namespace App\Models;

use App\Models\Forums;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumComments extends Model
{
    use HasFactory;

    protected $table = 'comments';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function forum()
    {
        return $this->hasOne(Forums::class);
    }
}