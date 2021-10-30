<?php

// This won't work because of how the Localization plugin works
//it('redirects to language')->get('/')->assertStatus(302);

it('has a landing page')->get('/en')->assertStatus(200);
it('has a pricing page')->get('/en/pricing')->assertStatus(200);
it('has a features page')->get('/en/features')->assertStatus(200);


