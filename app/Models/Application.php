<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'post_id',
        'cover_letter',
        'cv',
    ];

    public function applicant()
    {
        return $this->belongsTo(User::class, 'applicant_id', 'id');
    }

    public function jobPost()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}
