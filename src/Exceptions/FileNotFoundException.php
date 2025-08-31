<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Exceptions;

use LogicException;

/**
 * @internal
 *
 * This exception will be thrown if the specified file is not found in the directory.
 */
final class FileNotFoundException extends LogicException {}
