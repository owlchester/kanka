<?php

it('has users page', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
