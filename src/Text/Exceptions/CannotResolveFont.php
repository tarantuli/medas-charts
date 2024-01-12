<?php

declare(strict_types=1);

namespace Medas\Charts\Text\Exceptions;

use Medas\Core\Exceptions\BaseException;

class CannotResolveFont extends BaseException
{
    public function __construct(string $identifier)
    {
        parent::__construct($identifier);
    }

    public function pattern(): string
    {
        return 'cannot resolve font identified by "%s"';
    }
}
