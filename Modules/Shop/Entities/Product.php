<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Shop\Database\Factories\ProductFactory;
use App\Traits\UuidTrait;

class Product extends Model
{
    use HasFactory, UuidTrait;

    protected $fillable = [
        'parent_id',
        'user_id',
        'sku',
        'type',
        'name',
        'slug',
        'price',
        'featured_image',
        'sale_price',
        'status',
        'stock_status',
        'manage_stock',
        'publish_date',
        'excerpt',
        'body',
        'metas',
    ];

    protected $table = 'shop_products';

    // Status produk
    public const DRAFT = 'DRAFT';
    public const ACTIVE = 'ACTIVE';
    public const INACTIVE = 'INACTIVE';

    public const STATUSES = [
        self::DRAFT => 'Draft',
        self::ACTIVE => 'Active',
        self::INACTIVE => 'Inactive',
    ];

    // Status stok produk
    public const STATUS_IN_STOCK = 'IN_STOCK';
    public const STATUS_OUT_OF_STOCK = 'OUT_OF_STOCK';

    public const STOCK_STATUSES = [
        self::STATUS_IN_STOCK => 'In Stock',
        self::STATUS_OUT_OF_STOCK => 'Out of Stock',
    ];

    // Tipe produk
    public const SIMPLE = 'SIMPLE';
    public const CONFIGURABLE = 'CONFIGURABLE';

    public const TYPES = [
        self::SIMPLE => 'Simple',
        self::CONFIGURABLE => 'Configurable',
    ];

    protected static function newFactory()
    {
        return ProductFactory::new();
    }

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    // Relasi ke inventory
    public function inventory()
    {
        return $this->hasOne('Modules\Shop\Entities\ProductInventory');
    }

    // Relasi ke varian produk (jika produk merupakan produk induk)
    public function variants()
    {
        return $this->hasMany('Modules\Shop\Entities\Product', 'parent_id')->orderBy('price', 'ASC');
    }

    // Relasi ke kategori produk
    public function categories()
    {
        return $this->belongsToMany('Modules\Shop\Entities\Category', 'shop_categories_products', 'product_id', 'category_id');
    }

    // Relasi ke tag produk
    public function tags()
    {
        return $this->belongsToMany('Modules\Shop\Entities\Tag', 'shop_products_tags', 'product_id', 'tag_id');
    }

    // Relasi ke atribut produk
    public function attributes()
    {
        return $this->hasMany('Modules\Shop\Entities\ProductAttribute', 'product_id');
    }

    // Relasi ke gambar produk
    public function images()
    {
        return $this->hasMany('Modules\Shop\Entities\ProductImage', 'product_id');
    }

    public function getPriceLabelAttribute(){
        return number_format($this->price);
    }
}
