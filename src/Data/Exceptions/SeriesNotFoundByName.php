<?php

declare(strict_types=1);

namespace Medas\Charts\Data\Exceptions;

use Medas\Core\Exceptions\BaseException;

class SeriesNotFoundByName extends BaseException
{
    public function __construct(string $name)
    {
        parent::__construct($name);
    }

    public function pattern(): string
    {
        return 'no series found named "%s"';
    }
}
