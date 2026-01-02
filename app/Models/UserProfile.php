<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'dob',
        'gender',
        'nid_number',
        'passport_number',
        'address',
        'salary',
        'salary_type',
        'employment_type',
        'joining_date',
        'bank_name',
        'bank_account',
        'profile_photo',
        'nid_document',
        'contract_document',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
