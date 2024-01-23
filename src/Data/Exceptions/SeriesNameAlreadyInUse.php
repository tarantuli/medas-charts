<?php

declare(strict_types=1);

namespace Medas\Charts\Data\Exceptions;

use Medas\Core\Exceptions\BaseException;

class SeriesNameAlreadyInUse extends BaseException
{
    public function __construct(string $name)
    {
        parent::__construct($name);
    }

    public function pattern(): string
    {
        return 'chart already contains a series named "%s" and an overwrite was not allowed';
    }
}
