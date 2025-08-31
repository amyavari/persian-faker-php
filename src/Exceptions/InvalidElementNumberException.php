<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Exceptions;

use RuntimeException;

/**
 * @internal
 *
 * This exception will be thrown if the number of requested elements is not in the valid range.
 */
final class InvalidElementNumberException extends RuntimeException {}
