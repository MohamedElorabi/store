<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use Translatable;

    /**
     * @var array
     */
    protected $with = ['translations'];
    protected $translatedAttributes = ['value'];

    protected $fillable = ['key', 'is_translatable', 'plain_value'];

    protected $casts = [

        'is_translatable' => 'boolean',

    ];

    /**
     * @param array $settings
     * @return void
     */

    public static function setMany(array $settings)
    {
        foreach ($settings as $key => $value)
        {
            self::set($key,$value);
        }
    }

    /***
     * @param string $key
     * @param mixed $value
     * @return void
     */

    public static function set(string $key, $value)
    {
        if ($key === 'translatable') {

            return static::setTranslatableSettings($value);
        }

        if (is_array($value))
        {
            $value = json_encode($value);
        }

        static::updateOrCreate(['key' => $key], ['plain_value' => $value]);
    }


    /**
     * @param array $settings
     * @return void
     */

    public static function setTranslatableSettings(array $settings = [])
    {
        foreach ($settings as $key => $value){

            static::updateOrCreate(['key'=> $key], [
                'is_translatable' => true,
                'value' => $value,
            ]);
        }
    }


}
