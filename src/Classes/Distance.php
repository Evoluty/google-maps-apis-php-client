<?php

declare(strict_types=1);

namespace GoogleMapsClient\Classes;

class Distance
{
    /** @var string */
    private $text;

    /** @var int */
    private $value;

    public function __construct(string $text, int $value)
    {
        $this->text = $text;
        $this->value = $value;
    }

    public static function factory(\stdClass $stdDistance): self
    {
        return new self(
            $stdDistance->text,
            $stdDistance->value
        );
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
