<?php

use Kirby\Cms\Page;
use Kirby\Cms\Pages;

test('renders sitemap video metadata', function () {
    $previous = Page::$methods['testVideos'] ?? null;

    Page::$methods['testVideos'] = function () {
        return [
            Page::factory([
                'slug' => 'video',
                'site' => $this->site(),
                'content' => [
                    'title' => 'Intro video',
                    'thumbnail' => 'https://cdn.example.test/thumb.jpg',
                    'description' => 'Watch the intro',
                    'videoUrl' => 'https://cdn.example.test/video.mp4',
                ],
            ]),
        ];
    };

    try {
        $pages = Pages::factory([
            [
                'slug' => 'video-page',
                'content' => [
                    'title' => 'Video page',
                ],
            ],
        ]);

        $response = sitemap(fn () => $pages, [
            'xsl' => false,
            'videos' => true,
            'videosfield' => 'testVideos',
            'videourlfield' => 'videoUrl',
        ]);

        expect($response->code())->toBe(200)
            ->and($response->body())->toContain('<video:video>')
            ->and($response->body())->toContain('<video:title>Intro video</video:title>')
            ->and(simplexml_load_string($response->body()))->not->toBeFalse();
    } finally {
        if ($previous === null) {
            unset(Page::$methods['testVideos']);
        } else {
            Page::$methods['testVideos'] = $previous;
        }
    }
});
