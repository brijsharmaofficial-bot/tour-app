<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
     // Explicitly define the table name
     protected $table = 'car_options';

     // Primary key (if not 'id', update accordingly)
     protected $primaryKey = 'id';
 
     // Allow mass assignment for specific fields (update with actual columns)
     protected $fillable = [
         'name',
         'option_type',
         'price',
         'description',
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
