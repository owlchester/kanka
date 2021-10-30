<?php


it('has a public campaigns page')->get('/en/public-campaigns')->assertStatus(200);
