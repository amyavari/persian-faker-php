<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Exceptions;

use Exception;

/**
 * @internal
 *
 * This exception will be thrown if the path for the filename and array key is not in a valid format.
 */
final class InvalidDataPathException extends Exception {}
