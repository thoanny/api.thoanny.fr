<?php namespace App\Service;

class Url
{
    public function getCleanUrl(string $url): string
    {
        $parts = parse_url($url);
        $path = $parts['path']??'';
        return "{$parts['scheme']}://{$parts['host']}$path";
    }
}
