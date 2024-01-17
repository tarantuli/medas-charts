<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Markers\Exceptions;

use Medas\Charts\Graphs\Markers\Types\MarkerType;
use Medas\Core\Exceptions\BaseException;

class NoHandlerForMarkerTypeFound extends BaseException
{
    public function __construct(MarkerType $type)
    {
        parent::__construct($type::class);
    }

    public function pattern(): string
    {
        return 'No handler found for marker type %s';
    }
}
