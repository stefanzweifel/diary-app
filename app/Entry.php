<?php

namespace App;

use App\Journal;
use App\Media;
use App\User;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

class Entry extends UuidModel implements HasMedia
{
    use HasMediaTrait;

    protected $fillable = ['title', 'content', 'date', 'journal_id', 'user_id'];

    protected $touches = ['journal'];

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
