<?php

namespace Spatie\Searchable;

class SearchableAttribute
{
    /** @var string */
    protected $attribute;

    /** @var bool */
    protected $partial;

    /** @var bool */
    protected $mixed;

    public function __construct(string $attribute, bool $partial = true, bool $mixed = false)
    {
        $this->attribute = $attribute;

        $this->partial = $partial;

        $this->mixed = $mixed;
    }

    public static function create(string $attribute, bool $partial = true, bool $mixed = false): self
    {
        return new self($attribute, $partial, $mixed);
    }

    public static function createExact(string $attribute): self
    {
        return static::create($attribute, false);
    }

    public static function createMixed(string $attribute): self
    {
        return static::create($attribute,false,true);
    }

    public static function createMany(array $attributes): array
    {
        return collect($attributes)
            ->map(function ($attribute) {
                return new self($attribute);
            })
            ->toArray();
    }

    public function getAttribute(): string
    {
        return $this->attribute;
    }

    public function isPartial(): bool
    {
        return $this->partial;
    }

    public function isMixed(): bool
    {
        return $this->mixed;
    }
}
