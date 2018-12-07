<?php 
namespace App\Model\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use DB;

/**
 * 商品库存
 */
class ProductStock extends Model
{
	protected $table = 'erp_product_stock';
	public $timestamps = false;
}  