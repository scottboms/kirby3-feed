<?php

use Kirby\Cms\Pages;

test('renders sitemap urls with escaped query strings', function () {
    $pages = Pages::factory([
        [
            'slug' => 'query-url',
            'content' => [
                'title' => 'Query URL',
                'sitemapUrl' => 'https://example.test/?a=1&b=2',
            ],
        ],
    ]);

    $response = sitemap(fn () => $pages, [
        'xsl' => false,
        'urlfield' => 'sitemapUrl',
    ]);

    expect($response->code())->toBe(200)
        ->and($response->body())->toContain('https://example.test/?a=1&#38;b=2')
        ->and(simplexml_load_string($response->body()))->not->toBeFalse();
});

test('escapes sitemap url markup instead of emitting xml nodes', function () {
    $pages = Pages::factory([
        [
            'slug' => 'injected-url',
            'content' => [
                'title' => 'Injected URL',
                'sitemapUrl' => 'https://good.test/</loc><evil>owned</evil><loc>',
            ],
        ],
    ]);

    $response = sitemap(fn () => $pages, [
        'xsl' => false,
        'urlfield' => 'sitemapUrl',
    ]);

    expect($response->code())->toBe(200)
        ->and($response->body())->not->toContain('<evil>owned</evil>')
        ->and($response->body())->toContain('https://good.test/&#60;/loc&#62;&#60;evil&#62;owned&#60;/evil&#62;&#60;loc&#62;')
        ->and(simplexml_load_string($response->body()))->not->toBeFalse();
});
