<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, HasUuids;

    protected $table = 'users';

    protected $fillable = ['id', 'name', 'password', 'role'];

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;


    public function getAuthPassword() {
        return bcrypt($this->password);
    }
}
