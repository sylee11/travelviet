<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Social extends Model
{
    public $incrementing = false;
    public function users()
    {
        return $this->belongsTo(User::class);
    }

}
