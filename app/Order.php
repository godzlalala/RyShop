<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = ['no', 'model', 'price', 'user_id', 'end_at', 'payout', 'target', 'aff_id'];

    public static function checkout($price,$id,$no)
    {

        // 第三方接口 API

        $apiid = '13370';
        $apikey = md5('6ce72252d6962a926a26fa2c6d685f6c');
        $showurl = Setings::whereRaw('name="domain"')->first()->value.'/order/new/result';
        $addnum =  'alip'.$apiid.'00'.$no;
        //dd($showurl);

        echo "
		<form name='form1' action='https://api.jsjapp.com/plugin.php?id=add:alipay' method='POST'>
			<input type='hidden' name='uid' value='".$id."'>
			<input type='hidden' name='total' value='".$price."'>
			<input type='hidden' name='apiid' value='".$apiid."'>
			<input type='hidden' name='showurl' value='".$showurl."'>
			<input type='hidden' name='apikey' value='".$apikey."'>
			<input type='hidden' name='addnum' value='".$addnum."'>
		</form>
		<script>window.onload=function(){document.form1.submit();}</script> 
	";
    }

    public static function renew($price,$id,$no)
    {

        // 第三方接口 API

        $apiid = '13370';
        $apikey = md5('6ce72252d6962a926a26fa2c6d685f6c');
        $showurl = Setings::whereRaw('name="domain"')->first()->value.'/order/renew/result';
        $addnum =  'alip'.$apiid.'00'.$no;

        echo "
		<form name='form1' action='https://api.jsjapp.com/plugin.php?id=add:alipay' method='POST'>
			<input type='hidden' name='uid' value='".$id."'>
			<input type='hidden' name='total' value='".$price."'>
			<input type='hidden' name='apiid' value='".$apiid."'>
			<input type='hidden' name='showurl' value='".$showurl."'>
			<input type='hidden' name='apikey' value='".$apikey."'>
			<input type='hidden' name='addnum' value='".$addnum."'>
		</form>
		<script>window.onload=function(){document.form1.submit();}</script> 
	";
    }

    public static function is_succeed($apikey,$price,$cur_order)
    {

        //支付回调

        if($apikey!=md5('6ce72252d6962a926a26fa2c6d685f6c'.$cur_order->no)) {
            if($cur_order->price == $price){
                return true;
            }
        }
        return false;
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
