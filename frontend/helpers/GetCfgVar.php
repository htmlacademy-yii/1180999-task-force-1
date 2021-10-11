<?php

namespace frontend\helpers;

class GetCfgVar
{
    public static function getSizeLimits()
    {
        $maxSize = get_cfg_var( 'upload_max_filesize');
        return (preg_replace('/[^0-9]/', '', $maxSize)) * 1024 * 1024;
    }
}
