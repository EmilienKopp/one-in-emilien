<?php

use Inertia\Testing\AssertableInertia as Assert;

test('talks index page renders the talk list', function () {
    $response = $this->get(route('talks.index'));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('talks/Index')
        ->has('talks', 1)
        ->where('talks.0.slug', 'views-are-great')
    );
});

test('views are great deck renders with the talks root view', function () {
    $response = $this->get(route('talks.views-are-great'));

    $response->assertOk();

    $response->assertViewIs('talks');

    $response->assertInertia(fn (Assert $page) => $page
        ->component('talks/deck/views-are-great/Index')
        ->has('surveyUrl')
    );
});
