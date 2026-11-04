<?php

declare(strict_types=1);

// The words, sentences, paragraphs and slug methods accept a count from 1 to 100
dataset('counts out of range', [
    'zero' => ['count' => 0],
    'more than 100' => ['count' => 101],
]);
