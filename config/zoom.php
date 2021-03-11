<?php

return [
    'api_key' => 'cvW9HbB8RQuiGThsy0xpwg',
    'api_secret' => 'gE0Tnh58xPe6Rp8czEOMFyqAQoWCMUWeL7sO',
    'base_url' => 'https://api.zoom.us/v2/',
    'token_life' => 60 * 60 * 24 * 7, // In seconds, default 1 week
    'authentication_method' => 'jwt', // Only jwt compatible at present but will add OAuth2
    'max_api_calls_per_request' => '5' // how many times can we hit the api to return results for an all() request
];
