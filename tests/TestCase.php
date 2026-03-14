<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function siteUrl(string $path = '/'): string
    {
        $rootDomain = (string) config('app.root_domain');
        $normalizedPath = '/'.ltrim($path, '/');

        return sprintf('http://%s%s', $rootDomain, $normalizedPath);
    }

    protected function adminUrl(string $path = '/'): string
    {
        $adminDomain = (string) config('app.admin_domain');
        $normalizedPath = '/'.ltrim($path, '/');

        return sprintf('http://%s%s', $adminDomain, $normalizedPath);
    }
}
