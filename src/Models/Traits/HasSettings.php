<?php

namespace BBIT\Models\Traits;

use BBIT\Models\UserSetting;

trait HasSettings {
    public function settings()
    {
        return $this->hasMany(UserSetting::class);
    }

    public function getSetting($v, $defualtField = 's_value', $defaultValue = '')
    {
        if ($this->settings && $s = $this->settings->where('setting_id',$v)->first() ) {
            return $s;
        } else {
            return $this->settings()->firstOrCreate(['setting_id' => $v], [$defualtField => $defaultValue]);
        }
    }

    public function updateSetting($setting_id, $value, $field = 's_value')
    {
        if ($field === 's_value') {
            $value = substr($value, 0, 191);
        } // limit to first 191 characters...
        return $this->settings()->updateOrCreate([
            'setting_id' => $setting_id
        ], [
            $field => $value,
        ]);
    }
}
