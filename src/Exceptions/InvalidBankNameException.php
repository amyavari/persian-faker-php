<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Exceptions;

use RuntimeException;

/**
 * @internal
 *
 * This exception will be thrown if the bank name is not valid in Iran.
 */
final class InvalidBankNameException extends RuntimeException {}
