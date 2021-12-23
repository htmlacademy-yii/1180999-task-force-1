<?php

namespace frontend\helpers;

/**
 * Класс для получения максимально разрешенного размера загружаемого файла
 */
class GetMaxFileSize
{
    /**
     * @return float|int Возвращает доступный размер файла в Мб
     */
    public static function getSizeLimits()
    {
        $maxSize = get_cfg_var( 'upload_max_filesize');
        return (preg_replace('/[^0-9]/', '', $maxSize)) * 1024 * 1024;
    }
}
