<?php

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('registration screen can be rendered', function () {
    $this->markTestSkipped('Registration is disabled in this application.');
});

test('new users can register', function () {
    $this->markTestSkipped('Registration is disabled in this application.');
});
