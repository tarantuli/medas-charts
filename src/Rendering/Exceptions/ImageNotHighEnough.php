<?php

declare(strict_types=1);

namespace Medas\Charts\Rendering\Exceptions;

use Medas\Core\Exceptions\BaseException;

class ImageNotHighEnough extends BaseException
{
    public function __construct(int $imageHeight, float $chartHeight)
    {
        parent::__construct(ceil($chartHeight), $imageHeight);
    }

    public function pattern(): string
    {
        return 'image not high enough, need %d more than the given height of %d';
    }
}
