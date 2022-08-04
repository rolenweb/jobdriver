<?php

declare(strict_types=1);

namespace App\UseCases;

use Illuminate\Support\Collection;

class UseCaseResponse
{
    private Collection $data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = collect($data);
    }

    /**
     * @return Collection
     */
    public function getData(): Collection
    {
        return $this->data;
    }
}
