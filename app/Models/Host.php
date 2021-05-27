<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Host extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'address',
        'host_login',
        'host_password',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class, 'client_host');
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

}
