<?php

if (!function_exists('getYoutubeId')) {
    function getYoutubeId($url) {
        if (empty($url)) return null;
        $patterns = [
            '/youtube\.com\/watch\?v=([^&]+)/',
            '/youtu\.be\/([^?]+)/',
            '/youtube\.com\/embed\/([^?]+)/'
        ];
        foreach ($patterns as $pattern) {
            preg_match($pattern, $url, $matches);
            if (isset($matches[1])) return $matches[1];
        }
        return null;
    }
}

if (!function_exists('getYoutubeEmbedUrl')) {
    function getYoutubeEmbedUrl($url) {
        $id = getYoutubeId($url);
        return $id ? 'https://www.youtube.com/embed/' . $id : $url;
    }
}