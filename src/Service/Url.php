<?php namespace App\Service;

class Url
{
    public function getCleanUrl(string $url): string
    {
        $parts = parse_url($url);
        return "{$parts['scheme']}://{$parts['host']}{$parts['path']}";
    }
}
