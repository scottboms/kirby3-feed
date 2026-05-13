<?php

test('renders atom feed as valid xml', function () {
    $response = \Bnomei\Feed::feed(page('blog')->children()->listed()->limit(1), [
        'title' => 'Latest articles',
        'link' => 'blog',
        'snippet' => 'feed/atom',
    ]);

    expect($response->code())->toBe(200)
        ->and($response->type())->toBe('text/xml')
        ->and($response->body())->toStartWith('<?xml version="1.0" encoding="utf-8"?>')
        ->and(simplexml_load_string($response->body()))->not->toBeFalse();
});
