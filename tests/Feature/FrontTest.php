<?php

it('redirects to user locale')->get('/')->assertStatus(302);
it('has a landing page')->get('/en')->assertStatus(200);
it('has a pricing page')->get('/en/pricing')->assertStatus(200);
it('has a features page')->get('/en/features')->assertStatus(200);
