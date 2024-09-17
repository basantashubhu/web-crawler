<?php

function is_url_ok($url)
{
    $headers = @get_headers($url);
    return $headers && strpos($headers[0], '200');
}