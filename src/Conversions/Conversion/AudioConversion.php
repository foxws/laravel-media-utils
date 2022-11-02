<?php

namespace Foxws\MediaUtils\Conversions\Conversion;

use Foxws\MediaUtils\Conversions\Conversion;

class AudioConversion extends Conversion
{
    protected array $attributes = [];

    /** @var callable|null */
    protected $callableAttributes;

    public function path(string $path): self
    {
        $this->attributes(['path' => $path]);

        return $this;
    }

    public function toArray(): array
    {
        return [
            $this->attributes,
        ];
    }
}
