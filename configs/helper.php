<?php

if (!function_exists('debug')) {
    function debug($data)
    {
        echo '<pre>';
        print_r($data);
        die;
    }
}

if (!function_exists('upload_file')) {
    function upload_file($folder, $file)
    {
        $targetFile = $folder . '/' . time() . '-' . $file["name"];

        if (move_uploaded_file($file["tmp_name"], PATH_ASSETS_UPLOADS . $targetFile)) {
            return $targetFile;
        }

        throw new Exception('Upload file không thành công!');
    }
}

if (!function_exists('redirect')) {
    function redirect($url)
    {
        header("Location: " . BASE_URL . $url);
        exit;
    }
}

if (!function_exists('url')) {
    function url($path = '')
    {
        return BASE_URL . ltrim($path, '/');
    }
}

if (!function_exists('asset')) {
    function asset($path = '')
    {
        return BASE_URL . 'assets/' . ltrim($path, '/');
    }
}

if (!function_exists('old')) {
    function old($key, $default = '')
    {
        return $_POST[$key] ?? $default;
    }
}

if (!function_exists('session_get')) {
    function session_get($key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }
}

if (!function_exists('session_set')) {
    function session_set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
}

if (!function_exists('session_flash')) {
    function session_flash($key, $value)
    {
        $_SESSION['_flash'][$key] = $value;
    }
}

if (!function_exists('session_get_flash')) {
    function session_get_flash($key, $default = null)
    {
        $value = $_SESSION['_flash'][$key] ?? $default;
        unset($_SESSION['_flash'][$key]);
        return $value;
    }
}

if (!function_exists('is_admin')) {
    function is_admin()
    {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }
}

if (!function_exists('is_logged_in')) {
    function is_logged_in()
    {
        return isset($_SESSION['user_id']);
    }
}

if (!function_exists('format_date')) {
    function format_date($date, $format = 'd/m/Y H:i')
    {
        return date($format, strtotime($date));
    }
}

if (!function_exists('format_price')) {
    function format_price($price)
    {
        return number_format($price, 0, ',', '.') . ' đ';
    }
}