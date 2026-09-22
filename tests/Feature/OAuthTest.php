<?php

it('rejects unauthenticated client requests', function () {
    $this->getJson('/oauth/clients')->assertUnauthorized();
});
