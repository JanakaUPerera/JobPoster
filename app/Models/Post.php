<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use function Nette\Utils\match;

class Post extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 'Active';
    const STATUS_INACTIVE = 'Inactive';

    protected $fillable = [
        'poster_id',
        'position',
        'location',
        'about',
        'responsibilities',
        'requirements',
        'benefits',
        'deadline',
        'status'
    ];

    protected $appends = ['age'];

    public function getAgeAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function jobPoster()
    {
        return $this->belongsTo(User::class,'poster_id','id');
    }

    public function statusToInteger()
    {
        return match($this->status){
            self::STATUS_ACTIVE => 1,
            self::STATUS_INACTIVE => 2
        };
    }

    protected static function booted(): void
    {
        static::addGlobalScope('postList', function (Builder $builder){
            $builder->when(Auth::user()->user_type == User::TYPE_EMPLOYER, function ($query){
                $query->where('poster_id',Auth::id());
            });
        });
    }
}
