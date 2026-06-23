<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class Sites {

    public function __construct(private readonly ParameterBagInterface $parameterBag)
    {
    }

    public function list(): ?array
    {
        return $this->parameterBag->get('sites');
    }
}
