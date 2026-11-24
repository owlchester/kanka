<?php

use App\Facades\Mentions;

test('repeated headings across multiple mapText calls receive unique ids', function () {
    $this->asUser()->withCampaign();

    $first = Mentions::mapText('<h1>Hello World</h1>');
    $second = Mentions::mapText('<h1>Hello World</h1>');
    $third = Mentions::mapText('<h2>Hello World</h2>');

    expect($first)->toBe('<h1 id="hello-world">Hello World</h1>')
        ->and($second)->toBe('<h1 id="hello-world-1">Hello World</h1>')
        ->and($third)->toBe('<h2 id="hello-world-2">Hello World</h2>');
});

test('table of contents in a later block links to its deduplicated heading id', function () {
    $this->asUser()->withCampaign();

    $entry = Mentions::mapText('<h1>Hello World</h1>');
    $post = Mentions::mapText('{table-of-contents}<h1>Hello World</h1>');

    expect($entry)->toBe('<h1 id="hello-world">Hello World</h1>')
        ->and($post)->toContain('<h1 id="hello-world-1">Hello World</h1>')
        ->and($post)->toContain('href="#hello-world-1"')
        ->and($post)->not->toContain('href="#hello-world"');
});
