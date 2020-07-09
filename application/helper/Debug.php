<?php
namespace application\helper;

/**
 * Вспомогательный класс для вывода отладочной информации
 *
 * @author toyrik
 */
class Debug
{
    public static function pre($param)
    {
        echo '<pre>';
        print_r($param);
        echo '</pre>';
    }
}
