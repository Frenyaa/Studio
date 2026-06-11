<?php

$hero = \App\Models\HeroSlide::where('is_active', true)->orderBy('sort_order')->first()
    ?: \App\Models\HeroSlide::orderBy('sort_order')->first();

if ($hero) {
    $hero->slogan = 'KIẾN TẠO KHÔNG GIAN ĐẸP';
    $hero->save();
    echo 'OK -> ' . $hero->slogan . PHP_EOL;
} else {
    echo 'Khong tim thay hero slide nao.' . PHP_EOL;
}
