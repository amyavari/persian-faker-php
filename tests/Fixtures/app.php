<?php

declare(strict_types=1);

// A non-Laravel project can have its own global app() function, which is not a Laravel container
function app(): stdClass
{
    return new stdClass;
}
