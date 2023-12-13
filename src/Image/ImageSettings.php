<?php

declare(strict_types=1);

namespace Medas\Charts\Image;

use Medas\Charts\General\FourSides;
use Medas\ImageManager\Color;

class ImageSettings
{
    public int $height;
    public int $width;
    public Color $backgroundColor;
    public FourSides $padding;
    public SizeLock $sizeLock;
}
