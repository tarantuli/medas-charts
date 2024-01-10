<?php

declare(strict_types=1);

namespace Medas\Charts\Rendering\Exceptions;

use Medas\Core\Exceptions\BaseException;

class ImageNotWideEnough extends BaseException
{
    public function pattern(): string
    {
        // TODO
        return 'image not wide enough';
    }
}
