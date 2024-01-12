<?php

declare(strict_types=1);

namespace Medas\Charts\Text;

use Medas\Charts\ConfigOptions\FontDirectory;
use Medas\Core\Attributes\{ConfigValue, Service};

#[Service]
class FontResolver
{
    private array $locations = [];

    public function __construct(
        #[ConfigValue(FontDirectory::class)]
        private readonly string $fontDirectory,
    )
    {
    }

    public function resolve(string $identifier): string
    {
        if (isset($this->locations[$identifier])) {
            return $this->locations[$identifier];
        }

        if (file_exists($path = $this->fontDirectory . DIRECTORY_SEPARATOR . $identifier . '.ttf')) {
            return $this->locations[$identifier] = $path;
        }

        if (file_exists($identifier)) {
            return $this->locations[$identifier] = $identifier;
        }

        if (file_exists($path = $this->fontDirectory . DIRECTORY_SEPARATOR . $identifier)) {
            return $this->locations[$identifier] = $path;
        }

        throw new \Exception('unknown font ' . $identifier);
    }
}
