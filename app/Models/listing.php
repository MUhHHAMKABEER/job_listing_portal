<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'job_category',
        'salary' ,
        'vacancies_available' ,
        'email' ,
        'facebook',
        'instagram',
        'youtube',
        'picture' ,
        'contact_no' ,
        'description' ,
        'address',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
