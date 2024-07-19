<?php
declare(strict_types=1);

namespace PTag;

interface SerializeableInterface
{
    public function serialize(): string;
}
