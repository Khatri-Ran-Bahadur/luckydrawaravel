<?php
if (!function_exists('getOrdinal')) {
    function getOrdinal($n)
    {
        if ($n >= 11 && $n <= 13) {
            return $n . 'th';
        }
        switch ($n % 10) {
            case 1:
                return $n . 'st';
            case 2:
                return $n . 'nd';
            case 3:
                return $n . 'rd';
            default:
                return $n . 'th';
        }
    }
}

if (!function_exists('get_product_image')) {
    function get_product_image($image_path)
    {
        if (empty($image_path)) {
            return asset('placeholder.jpg');
        }
        return asset('storage/products/' . $image_path);
    }
}
