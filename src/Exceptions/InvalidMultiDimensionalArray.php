<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Exceptions;

use LogicException;

/**
 * @internal
 *
 * This exception will be thrown if the array is one dimensional.
 */
final class InvalidMultiDimensionalArray extends LogicException {}
