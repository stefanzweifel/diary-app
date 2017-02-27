<?php

namespace App;

use App\Entry;
use App\User;

class Journal extends UuidModel
{
    protected $fillable = ['title', 'user_id'];

    /**
     * Set the title attribute.
     *
     * @param   mixed
     * @return  void
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = encrypt($value);
    }

    /**
     * Retrieve the title attribute.
     *
     * @param   mixed
     * @return  string
     */
    public function getTitleAttribute($value)
    {
        return decrypt($value);
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
     * Relationship with the User model.
     *
     * @return    Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
