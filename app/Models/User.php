<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// This is a public profile, not an authentication account.
class User extends Model
{
    use HasFactory;

    protected $fillable = ['username', 'full_name', 'email'];
}
