<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Translatable;
    /**
     * @var array
     */
    protected $with = ['translations'];  //
    protected $translatedAttributes = ['name'];

    protected $fillable = ['parent_id', 'slug', 'is_active'];


    protected $hidden = ['translations'];

    protected $casts = [

        'is_active' => 'boolean',

    ];



    public function getActive()
    {
        $this->is_active == 0 ? 'غير مفعل' : 'مفعل';
    }


    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }
}
