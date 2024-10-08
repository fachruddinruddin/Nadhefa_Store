<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Traits\UuidTrait;
use Modules\Shop\Database\Factories\AttributeOptionFactory;

class AttributeOption extends Model
{
    use HasFactory, UuidTrait;

    protected $table = 'shop_attribute_options';

    protected $fillable = [
        'code',
        'name',
        'attribute_type',
        'validation_rules',
    ];

    protected static function newFactory()
    {
        return \Modules\Shop\Database\factories\AttributeOptionFactory::new();
    }
}
