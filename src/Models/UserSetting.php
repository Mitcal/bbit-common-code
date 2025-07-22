<?php

namespace BBIT\Models;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    protected $casts = [
        's_value' => 'string',
        'i_value' => 'integer',
        'text_value' => 'string',
    ];

    protected $fillable = [
        'setting_id',
        'setting_name',
        'user_id',
        's_value', // varchar(255)
        'i_value', // int
        'f_value', // float
        't_value', // datetime
        'text_value', // json / text
    ];

    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }


    public function value($field) {
        switch ($field) {
            case 'text_value' : return json_decode($this->text_value);
            case 's_value' : 
            case 'i_value' : 
            case 'f_value' : 
            case 't_value' : 
            default :
                return $this->{$field};
        }
    }

    public static function getGlobalSetting($setting_id, $field, $default = null) {
        $setting = UserSetting::firstOrCreate([
            'setting_id' => $setting_id,
            'user_id' => 0,
        ], [
            $field => $default,
        ]);

        return $setting->value($field);
    }
}
