<?php

declare(strict_types=1);

namespace Medas\Charts\Rendering\Exceptions;

use Medas\Core\Exceptions\BaseException;

class ImageNotWideEnough extends BaseException
{
    public function __construct(int $imageWidth, float $chartWidth)
    {
        parent::__construct(ceil($chartWidth), $imageWidth);
    }

    public function pattern(): string
    {
        return 'image not wide enough, need %d more than the given width of %d';
    }
}
