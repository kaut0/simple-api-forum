<?php

namespace App\Models;

use App\Models\ForumComments;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forums extends Model
{
    use HasFactory;

    protected $table = 'forums';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function forumsComments()
    {
        return $this->hasMany(ForumComments::class, 'forum_id', 'id');
    }
}