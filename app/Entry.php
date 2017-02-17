<?php

namespace App;

use App\Journal;
use App\User;

class Entry extends UuidModel
{
    protected $fillable = ['content', 'journal_id', 'user_id'];


    /**
     * Retrieve the content attribute.
     *
     * @param   mixed
     * @return  string
     */
    public function getContentAttribute($value)
    {
        return decrypt($value);
    }

    /**
     * Set the content attribute.
     *
     * @param   mixed
     * @return  void
     */
    public function setContentAttribute($value)
    {
        $this->attributes['content'] = encrypt($value);
    }



    /**
     * Relationship with the Journal model.
     *
     * @return    Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function journal()
    {
        return $this->belongsTo(Journal::class);
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
