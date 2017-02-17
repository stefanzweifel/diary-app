<?php

namespace App;

use App\Entry;
use App\Journal;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Relationship with the Journal model.
     *
     * @return    Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function journals()
    {
        return $this->hasMany(Journal::class);
    }

    /**
     * Relationship with the Entry model.
     *
     * @return    Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entries()
    {
        return $this->hasMany(Entry::class);
    }
}
