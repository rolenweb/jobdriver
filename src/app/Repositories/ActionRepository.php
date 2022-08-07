<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\UuidInterface;
use Throwable;

class ActionRepository implements RepositoryInterface
{
    /**
     * @param  Action|Model  $model
     * @return Action|Model
     *
     * @throws Throwable
     */
    public function save(Action | Model $model): Action | Model
    {
        $model->saveOrFail();

        return $model;
    }

    /**
     * @param  UuidInterface  $uuid
     * @return Action
     */
    public function findById(UuidInterface $uuid): Action
    {
        return Action::findOrFail($uuid);
    }
}
