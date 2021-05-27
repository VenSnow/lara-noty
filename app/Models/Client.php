<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hosts()
    {
        return $this->belongsToMany(Host::class, 'client_host');
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

}
