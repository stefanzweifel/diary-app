<?php

namespace App;

use App\Entry;
use Illuminate\Database\Eloquent\Model;

class Media extends UuidModel
{
    protected $fillable = ['blob'];

    /**
     * Retrieve the blob attribute.
     *
     * @param   mixed
     * @return  string
     */
    public function getBlobAttribute($value)
    {
        return decrypt($value);
    }

    /**
     * Set the blob attribute.
     *
     * @param   mixed
     * @return  void
     */
    public function setBlobAttribute($value)
    {
        $this->attributes['blob'] = encrypt($value);
    }

    /**
     * Relationship with the Entry model.
     *
     * @return    Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entry()
    {
        return $this->belongsTo(Entry::class);
    }
}
