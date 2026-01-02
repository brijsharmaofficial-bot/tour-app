<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title', 'slug', 'meta_title', 'meta_description', 'meta_keywords', 'content', 'status'
    ];

    /**
     * Get the page's content.
     *
     * @return string
     */
    public function getContentAttribute($value)
    {
        return $value;
    }

    /**
     * Set the page's content.
     *
     * @param  string  $value
     * @return void
     */
    public function setContentAttribute($value)
    {
        $this->attributes['content'] = $value;
    }
}
