<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Exceptions;

use LogicException;

/**
 * @internal
 *
 * This exception will be thrown if the specified key is not found in the array data.
 */
final class InvalidDataKeyException extends LogicException {}
