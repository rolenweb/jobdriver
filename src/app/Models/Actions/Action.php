<?php

namespace App\Models\Actions;

use App\Enums\ActionHandlerEnum;
use App\Enums\ActionStatusEnum;
use App\Models\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

/**
 * @property Uuid $id
 * @property string $name
 * @property ActionHandlerEnum $handler
 * @property ActionStatusEnum $status
 */
class Action extends Model
{
    use HasFactory, UsesUuid, SoftDeletes;

    protected $casts = [
        'handler' => ActionHandlerEnum::class,
        'status' => ActionStatusEnum::class,
    ];

    public static function create(): self
    {
        return new self();
    }
}
