<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Exceptions;

use LogicException;

/**
 * @internal
 *
 * This exception will be thrown if the array elements are not of string type.
 */
final class InvalidStringArrayException extends LogicException {}
