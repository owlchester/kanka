<?php

it('can register', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
