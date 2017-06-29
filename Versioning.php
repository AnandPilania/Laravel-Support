<?php

namespace AP\Support;

class Versioning
{
    public static function modify($file)
    {
        return file_exists($file) ? $file . '?v=' . filemtime($file) : $file;
    }
}