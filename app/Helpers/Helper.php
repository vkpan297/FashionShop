<?php

function getConfigValue($configKey){
    $setting=\App\Models\setting::where('config_key',$configKey)->first();
    if(!empty($setting)){
        return $setting->config_value;
    }
    return null;
}
