<?php

namespace Rezahmady\SettingOperation;

use Illuminate\Support\Facades\Cache;

class Setting
{
    public static function get($name, $default = '')
    {
        $arr = explode('.',$name);
        $key = $arr[0];
        $field = $arr[1];
        $settings = Cache::rememberForever("settingOperation::$key", function () use ($key) {
            $model = config('setting-operation.setting_model_class', \Rezahmady\SettingOperation\app\Models\SettingOperation::class);
            return $model::where('key', $key)->first();
        });
        if($settings) {
            $fields = json_decode($settings->fields) ?? [];
            if(property_exists($fields,$field)) {
                return $fields->{$field};
            }
        }
        return $default;
    }

    public static function set($name, $value)
    {
        $arr = explode('.',$name);
        $key = $arr[0];
        $field = $arr[1];
        $settings = Cache::rememberForever("settingOperation::$key", function () use ($key) {
            $model = config('setting-operation.setting_model_class', \Rezahmady\SettingOperation\app\Models\SettingOperation::class);
            return $model::where('key', $key)->first();
        });
        if($settings) {
            $fields = json_decode($settings->fields) ?? [];
            $fields->{$field} = $value;
        }
        return $settings->update(['fields' => json_encode($fields)]);
    }
}
