<?php
namespace Constants;


class Tools
{
    public static function active($v1, $v2)
    {
        if ($v1 == $v2) {
            return 'active';
        }
    }

    public static function checked($isChecked)
    {
        if ($isChecked) {
            return 'checked';
        }
    }
} 