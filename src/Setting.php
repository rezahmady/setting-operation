<?php

namespace Rezahmady\SettingOperation;

class Setting
{
    public static function get($name, $default)
    {
        $model = config('setting-operation.setting_model_class', \Rezahmady\SettingOperation\app\Models\SettingOperation::class);
        $arr = explode('.',$name);
        $key = $arr[0];
        $field = $arr[1];
        $settings = $model::where('key', $key)->first();
        $fields = json_decode($settings->fields);
        if(property_exists($fields,$field)) {
            return $fields->{$field};
        }
        return $default;
    }
}