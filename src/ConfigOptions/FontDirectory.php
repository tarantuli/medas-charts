<?php

declare(strict_types=1);

namespace Medas\Charts\ConfigOptions;

use Medas\Core\{Attributes\Service, Interfaces\ConfigGroup, Interfaces\ConfigOption};

#[Service]
readonly class FontDirectory implements ConfigOption
{
    public function __construct(
        private RootGroup $group,
    )
    {
    }

    public function group(): ConfigGroup
    {
        return $this->group;
    }

    public function name(): string
    {
        return 'font-directory';
    }

    public function description(): string
    {
        return 'The directory where font files live';
    }

    public function hasDefault(): bool
    {
        return true;
    }

    public function default(): string
    {
        return 'fonts';
    }
}
