<?php

namespace Application\Util\Git;

interface AbstractFactoryInterface
{
    public function createServiceWithName(string $service);
}
