<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class alumni_Profile extends Model
{
    //

    protected $fillable = [
        'user_id',
        'department_id',
        'phone',
        'gender',
        'dob',
        'graduation_year',
        'current_address',
        'bio',
        'photo',
    ];



public function user()
{
    return $this->belongsTo(User::class);
}


public function department()
{
    return $this->belongsTo(Department::class);
}

// this code hides the link of the addprofile page if the user has already created a profile. It checks if the authenticated user has an associated alumni profile and returns a boolean value accordingly.
public function alumniProfile()
{
    return $this->hasOne(alumni_Profile::class);
}

}
