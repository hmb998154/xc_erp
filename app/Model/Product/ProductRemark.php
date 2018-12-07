<?php 
namespace App\Model\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use DB;

/**
 * 商品留言备注
 */
class ProductRemark extends Model
{
	protected $table = 'erp_product_remark';
	public $timestamps = false;
}  