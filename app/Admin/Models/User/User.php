<?php

namespace App\Admin\Models\User;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\Catalog\Product;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable,
    Authorizable,
    HasFactory;

    /**
    * The attributes that are mass assignable.
    *
    * @var string[]
    */
    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    /**
    * The attributes excluded from the model's JSON form.
    *
    * @var string[]
    */
    protected $hidden = [
        'password',
    ];
}