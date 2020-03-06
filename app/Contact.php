<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\User;

class Contact extends Model
{
    protected $guarded = [];

    public function path()
    {
        return '/contacts/' .$this->id;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
