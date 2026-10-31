<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    //

    protected $fillable = [
        'department',
    ];



    public function alumniProfiles()
{
    return $this->hasMany(alumni_Profile::class);
}


}
