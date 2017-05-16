<?php

namespace App;

use App\Entry;
use App\Journal;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'master_password', 'encryption_key'
    ];

    protected $appends = ['has_master_password'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'master_password', 'encryption_key'
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

    /**
     * Set the encryption_key attribute.
     *
     * @param   mixed
     * @return  void
     */
    public function setEncryptionKeyAttribute($value)
    {
        $this->attributes['encryption_key'] = encrypt($value);
    }

    /**
     * Retrieve the encryption_key attribute.
     *
     * @param   mixed
     * @return  string
     */
    public function getEncryptionKeyAttribute($value)
    {
        return decrypt($value);
    }

    /**
     * Set the masterPassword attribute.
     *
     * @param   mixed
     * @return  void
     */
    public function setMasterPasswordAttribute($value)
    {
        $this->attributes['master_password'] = encrypt($value);
    }

    /**
     * Retrieve the MasterPassword attribute.
     *
     * @param   mixed
     * @return  string
     */
    public function getMasterPasswordAttribute($value)
    {
        if (!is_null($value)) {
            return decrypt($value);
        }

        return null;
    }

    /**
     * Retrieve the HasMasterPassword attribute.
     *
     * @param   mixed
     * @return  string
     */
    public function getHasMasterPasswordAttribute()
    {
        // \Log::info($this->master_password);

        // if (property_exists($this, 'master_password')) {
            return ! is_null($this->master_password) ;
        // }

        return false;
    }

}
