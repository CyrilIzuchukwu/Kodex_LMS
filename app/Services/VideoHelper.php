<?php

namespace App\Services;

class VideoHelper
{
    /**
     * Determine the video host from a URL.
     *
     * @param string $url
     * @return string|null
     */
    public static function getHost(string $url): ?string
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return null;
        }

        $host = strtolower(parse_url($url, PHP_URL_HOST) ?? '');

        $supportedHosts = [
            'youtube.com',
            'www.youtube.com',
            'youtu.be',
            'www.youtu.be',
            'vimeo.com',
            'player.vimeo.com',
        ];

        return in_array($host, $supportedHosts, true) ? $host : null;
    }

    /**
     * Extract the YouTube video ID from the URL.
     *
     * @param string $url
     * @return string|false
     */
    public static function getYoutubeId(string $url): string|false
    {
        $pattern = '%^
            (?:https?://)?        # Optional scheme
            (?:www\.)?            # Optional www
            (?:                  # Either...
              youtu\.be/         # youtu.be/
            | youtube\.com        # or youtube.com
              (?:/embed/|/v/|.*v=)
            )
            ([\w-]{10,12})        # Video ID
            %x';

        return preg_match($pattern, $url, $matches) ? $matches[1] : false;
    }

    /**
     * Extract the Vimeo video ID from the URL.
     *
     * @param string $url
     * @return string|false
     */
    public static function getVimeoId(string $url): string|false
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }

        $path = trim(parse_url($url, PHP_URL_PATH) ?? '', '/');
        $segments = explode('/', $path);

        return end($segments) ?: false;
    }

    /**
     * Parse the video URL and return host and video ID.
     *
     * @param string $url
     * @return array|null
     */
    public static function parse(string $url): ?array
    {
        $host = self::getHost($url);

        if (in_array($host, ['youtube.com', 'www.youtube.com', 'youtu.be', 'www.youtu.be'])) {
            return [
                'host' => 'youtube',
                'id' => self::getYoutubeId($url),
            ];
        }

        if (in_array($host, ['vimeo.com', 'player.vimeo.com'])) {
            return [
                'host' => 'vimeo',
                'id' => self::getVimeoId($url),
            ];
        }

        return null;
    }
}
