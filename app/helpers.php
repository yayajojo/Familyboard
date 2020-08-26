<?php

use Illuminate\Support\Facades\Hash;

function gravatar_url($email)
{
    $gravartar = ["identicon","monsterid","wavatar","robohash","retro","mp"];
    $data = [
        "s" => 40,
        "d" => $gravartar[array_rand($gravartar)]
    ];
    $query = http_build_query($data);
    return "https://www.gravatar.com/avatar/".Hash::make($email).'?'.$query;
}