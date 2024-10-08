<?php

namespace Modules\Shop\Entities;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductAttribute extends Model
{
    use HasFactory, UuidTrait;

    protected $table = 'shop_product_attributes';
    protected $fillable = [
        'product_id',
        'attribute_id',
        'string_value',
        'text_value',
        'boolean_value',
        'integer_value',
        'float_value',
        'datetime_value',
        'date_value',
        'json_value',
    ];

    protected static function newFactory()
    {
        return \Modules\Shop\Database\Factories\ProductAttributeFactory::new();
    }

    public function product()
    {
        return $this->belongsTo('Modules\Shop\Entities\Product');
    }

    public function attribute()
    {
        return $this->belongsTo('Modules\Shop\Entities\Attribute');
    }
}
