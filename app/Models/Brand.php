<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{

    use Translatable;
    /**
     * @var array
     */
    protected $with = ['translations'];  //


    protected $translatedAttributes = ['name'];

    protected $fillable = ['is_active', 'photo'];



    public function getActive()
    {
        $this->is_active == 0 ? 'غير مفعل' : 'مفعل';
    }


    public function getPhotoAttribute($val)
    {
        return ($val !== null) ? asset('assets/images/brands/' . $val) : "";
    }
}
