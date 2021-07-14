<?php


namespace App\Models;


class CacheFile
{
    private static $dir = __DIR__ . "/../../Cache/slugs/";

    public static function remember($key, $callback)
    {
        if (file_exists(self::$dir . $key)) {
            $result = file_get_contents(self::$dir . $key);
            return unserialize($result);
        } else {
            $result = call_user_func($callback);
            if (count($result)) {
                file_put_contents(self::$dir . $key, serialize($result));
            }
            return $result;
        }
    }

    public static function flush()
    {
        $files = scandir(self::$dir);
        foreach ($files as $file) {
            if ($file == "." || $file == "..") continue;

            @unlink(self::$dir . $file);
        }
    }

}