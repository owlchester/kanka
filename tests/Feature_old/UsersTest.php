<?php

it('has users page', function () {
    $response = $this->get('/community-events');

    $response->assertStatus(200);
});
