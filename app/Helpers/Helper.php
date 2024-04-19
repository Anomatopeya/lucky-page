<?php

if (! function_exists('generateRandomToken')) {
    function generateRandomToken(): string
    {
        return bin2hex(random_bytes(32));
    }
}
