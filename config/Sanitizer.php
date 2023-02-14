<?php

/**
 * A class to clean user inputs
 */
class Sanitizer
{
    /**
     * A methods to safe handle script and white spaces
     * @param $data
     * @return string
     */
    static function sanitize($data): string
    {
        return htmlspecialchars(strip_tags($data));
    }
}