<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = auth()->user()->id;
        $orders = Order::where('user_id', $id)->orderBy('created_at')->get();
        return OrderResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = auth()->user()->id;
        $order_id = Order::insertGetId(['user_id'=>$id,'created_at'=>now(),'updated_at'=>now()]);
        foreach($request->items as $order_item){
            $product_id = $order_item['item_id'];
            $stock = Product::where('id',$product_id)->value('stock_qty');
            $price =Product::where('id',$product_id)->value('sale_price');
            $qty = $order_item['qty'];
            if($stock>=$qty){
                DB::table('order_product')->insert(['created_at'=>now(),'updated_at'=>now(),'order_id'=>$order_id,'product_id'=>$product_id,'quantity'=>$qty,'price'=>$price]);
                Product::where('id',$product_id)->update(['stock_qty'=>($stock-$qty)]);
            }else{
                return response('no hay producto');
            }
        }
        return response('todo ok');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {

        if (auth()->user()->id == $order->user_id) {
            return new OrderResource($order);
        }
        return response('no maitro', 403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        if($order['status']=='active'){
            Order::where('id',$order['id'])->update(['status'=>'inactive']);
        }else{
            Order::where('id',$order['id'])->update(['status'=>'active']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
