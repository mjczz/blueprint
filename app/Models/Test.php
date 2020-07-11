<?php

namespace App\Models;

use App\Traits\HasSchemalessAttributes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\SchemalessAttributes\SchemalessAttributes;

class Test extends BaseModel
{
    use HasSchemalessAttributes;

    public $casts = [
        'extra_attributes' => 'array',
    ];

}
