<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'domain',
        'domain_end',
        'client_id',
        'host_id',
        'host_end',
        'ftp_login',
        'ftp_password',
        'db_login',
        'db_password',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function host()
    {
        return $this->belongsTo(Host::class);
    }

}
