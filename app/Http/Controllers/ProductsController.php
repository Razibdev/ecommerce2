<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
use Image;
use App\Products;
use App\Category;
use App\ProductsAttributes;
use App\ProductsImages;
use App\Coupons;
use DB;
use Session;
use Auth;
use App\User;
use App\Country;
use App\DeliveryAddress;
use App\Orders;
use App\OrdersProduct;


class ProductsController extends Controller
{
    public function addProduct(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            $product = new Products;
            $product->name = $data["product_name"];
            $product->category_id = $data["category_id"];
            $product->code = $data["product_code"];
            $product->color = $data["product_color"];
            if(!empty($data["product_description"])){
                $product->description = $data["product_description"];
            }else{
                $product->description = '';
            }

            $product->price = $data["product_price"];

            // Upload image

            if($request->hasFile('image')){
                echo $img_tmp = $request->file('image');
                if($img_tmp->isValid()){
                    // image path code
                    $extension = $img_tmp->getClientOriginalExtension();
                    $file_name = rand(111,9999).'.'.$extension;
                    $img_path = 'uploads/products/'.$file_name;

                    // img size

                    Image::make($img_tmp)->resize(500,500)->save($img_path);
                    $product->image = $file_name;
                }

            }
           
            $product->save();
            return redirect('/admin/view-products')->with('flash_message_success', 'Product has been added successfully');
            
        }
        // Categories dropdown menu code
        $categories = Category::where(['parent_id' => 0])->get();
        $categories_dropdown = '<option value=""selected disabled>Select</option>';
        foreach($categories as $cat){
            $categories_dropdown .= '<option value="'.$cat->id.'">'.$cat->name.'</option>';
            $sub_categories = Category::where(['parent_id' => $cat->id])->get();
            foreach($sub_categories as $sub_cat){
            $categories_dropdown .= '<option value="'.$sub_cat->id.'"> &nbsp;--&nbsp;'.$sub_cat->name.'</option>';
                
            }

        }

        return view('admin.products.add_product')->with(compact('categories_dropdown'));

    }




    public function viewProducts(){
        $products = Products::get();
        return view('admin.products.view_products')->with(compact('products'));
    }





    public function editProduct(Request $request, $id=null){
        if($request->isMethod('post')){
            $data = $request->all();

             // Upload image

             if($request->hasFile('image')){
                echo $img_tmp = $request->file('image');
                if($img_tmp->isValid()){
                    // image path code
                    $extension = $img_tmp->getClientOriginalExtension();
                    $file_name = rand(111,9999).'.'.$extension;
                    $img_path = 'uploads/products/'.$file_name;

                    // img size

                    Image::make($img_tmp)->resize(500,500)->save($img_path);
                }

            }else{
                $file_name = $data["current_image"];

            }

            if(empty($data["product_description"])){
                $data["product_description"] = '';

            }

            Products::where(['id' => $id])->update(['name' => $data["product_name"], 'category_id' => $data["category_id"], 'code' => $data["product_code"], 'color' => $data["product_color"], 'description' => $data["product_description"], 'price' => $data["product_price"], 'image' => $file_name]);
            return redirect('/admin/view-products')->with('flash_message_success', 'Product has been updated!');
        }
        $productDetails = Products::where(['id' => $id])->first();
        // Category Dropdown code here
        $categories = Category::where(['parent_id' => 0])->get();
        $categories_dropdown = '<option value=""selected disabled>Select</option>';
        foreach($categories as $cat){
            if($cat->id == $productDetails->category_id){
                $select = 'selected';
            }else{
                $select = '';
            }
            $categories_dropdown .= '<option value="'.$cat->id.'" '.$select.'>'.$cat->name.'</option>';
        }

        $sub_categories = Category::where(['parent_id' => $cat->id])->get();
        foreach($sub_categories as $sub_cat){
            if($sub_cat->id == $productDetails->category_id){
                $select = 'selected';
            }else{
                $select = '';
            }
            $categories_dropdown .= '<option value="'.$sub_cat->id.'" '.$select.'> &nbsp;--&nbsp;'.$sub_cat->name.'</option>';
        }
           
        return view('admin.products.edit_product')->with(compact('productDetails', 'categories_dropdown'));
    }

    public function deleteProduct($id=null){
        Products::where(['id' => $id])->delete();
        Alert::success('Deleted Successfull', 'Success Message');
        return redirect()->back()->with('flash_message_error', 'Product Deleted');
    }

    public function updateStatus(Request $request, $id = null){
        $data = $request->all();
        Products::where('id', $data['id'])->update(['status' => $data['status']]);

    }


    public function products($id=null){
        $productDetails = Products::with('attributes')->where('id', $id)->first();
        $ProductAllImages = ProductsImages::where(['product_id' => $id])->get();
        $featuredProducts = Products::where(['featured_products' => 1])->get();
        return view('wayshop.product_detail')->with(compact('productDetails', 'ProductAllImages', 'featuredProducts'));
    }

    public function addAttributes(Request $request, $id = null){
        $productDetails = Products::with('attributes')->where(['id'=> $id])->first();

        if($request->isMethod('post')){
            $data = $request->all();
            foreach($data['sku'] as $key => $val){
                if(!empty($val)){
                    // Prevent Dublicate sku records
                    $attrCountSKU = ProductsAttributes::where(['sku' => $val])->count();
                    if($attrCountSKU > 0){
                        return redirect('/admin/add-attributes/'.$id)->with('flash_message_error', 'SKU is already exists Please select another sku');
                    }

                    $attrCountSize = ProductsAttributes::where(['product_id' => $id, 'size' =>$data["size"][$key]])->count();
                    if($attrCountSize > 0){
                        return redirect('/admin/add-attributes/'.$id)->with('flash_message_success', ''.$data['size'][$key].'Size is already exist please size another');  
                    }
                    $attribute = new ProductsAttributes;
                    $attribute->product_id = $id;
                    $attribute->sku = $val;
                    $attribute->size = $data["size"][$key];
                    $attribute->price = $data["price"][$key];
                    $attribute->stock = $data["stock"][$key];
                    $attribute->save();
                    
                }
                
            }
            return redirect('/admin/add-attributes/'.$id)->with('flash_message_success', 'Product attributes added successfully');
        }

        return view('admin.products.add_attributes')->with(compact('productDetails'));
    }


    public function deleteAttribute($id = null){
        ProductsAttributes::where(['id' => $id])->delete();
        return redirect()->back()->with('flash_message_error', 'Product Attribute has been deleted');
    }

    public function editAttribute(Request $request, $id=null){
        if($request->isMethod('post')){
            $data = $request->all();
            foreach($data["attr"] as $key => $attr){
                ProductsAttributes::where(['id'=>$data["attr"][$key]])->update(['sku' => $data["sku"][$key], 'size' => $data["size"][$key], 'price' => $data["price"][$key], 'stock' => $data['stock'][$key]]);
            }
            return redirect()->back()->with('flash_message_success', 'Products attributes has been updated');
        }
    }

    public function addImages(Request $request, $id = null){
        $productDetails = Products::where(['id'=>$id])->first();
        if($request->isMethod('post')){
            $data = $request->all();

            if($request->hasFile('image')){
                $files = $request->file('image');
                foreach($files as $file){
                    $image = new ProductsImages;
                    $extension = $file->getClientOriginalExtension();
                    $filename = rand(111, 99999).'.'.$extension;
                    $image_path = 'uploads/products/'.$filename;
                    Image::make($file)->resize(500,500)->save($image_path);
                    $image->image = $filename;
                    $image->product_id = $data["product_id"];
                    $image->save();
                }
            }
            return redirect('/admin/add-images/'.$id)->with('flash_message_success', 'Image has been updated');
        }
        $productImages = ProductsImages::where(['product_id' => $id])->get();
        return view('admin.products.add_images')->with(compact('productDetails', 'productImages'));
    }

    public function deleteAltImage($id=null){
        $productImage = ProductsImages::where(['id' => $id])->first();
        $image_path = 'uploads/products/';
        if(file_exists($image_path.$productImage->image)){
            unlink($image_path.$productImage->image);
        }
        ProductsImages::where(['id' => $id])->delete();
        Alert::success('Deleted', 'Success Message');
        return redirect()->back();
    }


    public function updateFeatured(Request $request, $id = null){
        $data = $request->all();
        Products::where('id', $data['id'])->update(['featured_products' => $data['status']]);

    }

    public function getPrice(Request $request){
        $data = $request->all();
        $proArr = explode("-", $data["idSize"]);
        $proAttr = ProductsAttributes::where(['product_id' => $proArr[0], 'size' => $proArr[1]])->first();
        echo $proAttr->price;
    }

    // Start Add to cart 
    public function addtoCart(Request $request){
        Session::forget('couponAmount');
        Session::forget('couponCode');
        $data = $request->all();
        if(empty(Auth::user()->email)){
            $data["user_email"] = '';
        }else{
            $data["user_email"] = Auth::user()->email;
        }
        $session_id = Session::get('session_id');
        if(empty($session_id)){
            $session_id = Str::random(40);
            Session::put('session_id', $session_id);
        }
        
        $sizeArr = explode("-", $data["size"]);
        $countProducts = DB::table('cart')->where(['product_id' => $data["product_id"], 'product_code' => $data["code"], 'product_color' => $data["color"], 'price' => $data["price"], 'size' => $sizeArr[1], 'session_id' => $session_id])->count();

        if($countProducts > 0){
            return redirect()->back()->with('flash_message_error', "Product already exists in cart");
        }else{
            DB::table('cart')->insert(['product_id' => $data["product_id"], 'product_name' => $data["product_name"], 'product_code' => $data["code"], 'product_color' => $data["color"], 'price' => $data["price"], 'size' => $sizeArr[1], 'quantity' => $data["quantity"], 'user_email' => $data["user_email"], 'session_id' => $session_id]);
       return redirect('/cart')->with('flash_message_success', 'Product has been added in cart');
        }

    }

    // End add to cart

    // Start cart
    public function Cart(Request $request){
        if(Auth::check()){
            $user_email = Auth::user()->email;
            $userCart = DB::table('cart')->where(['user_email'=>$user_email])->get();
            
        }
            $session_id = Session::get('session_id');
            $userCart = DB::table('cart')->where(['session_id' => $session_id])->get();
        
        
        foreach($userCart as $key => $product){
            $productDetails = Products::where(['id'=>$product->product_id])->first();
            $userCart[$key]->image = $productDetails->image;
        }
        return view('wayshop.products.cart')->with(compact('userCart'));
    }
    //end cart

    //Start delete cart
    public function deleteCartProduct($id = null){
        Session::forget('couponAmount');
        Session::forget('couponCode');
        DB::table('cart')->where(['id' => $id])->delete();
        return redirect('/cart')->with('flash_message_error', 'Product has been deleted');
    }
    //end delete cart

    //start update quantity
    public function updateCartQuantity($id = null, $quantity = null){
        Session::forget('couponAmount');
        Session::forget('couponCode');
        DB::table('cart')->where('id', $id)->increment('quantity', $quantity);
        return redirect('/cart')->with('flash_message_success', 'Product Quantity has been updated');
    }
    //end update quantity

    // start apply coupon
    public function applyCoupon(Request $request){
        Session::forget('couponAmount');
        Session::forget('couponCode');
        if($request->isMethod('post')){
            $data = $request->all();
            $couponCount = Coupons::where('coupon_code', $data["coupon_code"])->count();

            if($couponCount == 0){
                return redirect()->back()->with('flash_message_error', 'Coupons Code does not exists');

            }else{
                
                $couponDetails = Coupons::where('coupon_code', $data["coupon_code"])->first();
                // Coupons code Status
                if($couponDetails->status == 0){
                    return redirect()->back()->with('flash_message_success', 'Coupon Code is not active');
                }

                // Check coupon expiry data
                $expiry_date = $couponDetails->expiry_date;
                $current_date = date('Y-m-d');
                if($expiry_date < $current_date){
                    return redirect()->back()->with('flash_message_success', 'Coupon Code is expired');
                }
                if(Auth::check()){
                    $user_email = Auth::user()->email;
                    $userCart = DB::table('cart')->where(['user_email'=>$user_email])->get();
                    
                }else{
                // Coupon is ready for discount
                $session_id = Session::get('session_id');
                $userCart = DB::table('cart')->where(['session_id' => $session_id])->get();
                }
                $total_amount = 0;

                foreach($userCart as $item){
                    $total_amount = $total_amount + ($item->price * $item->quantity);
                }

                // Checkd if Coupon Amount fixed or percentage

                if($couponDetails->amount_type == 'Fixed'){
                    $couponAmount = $couponDetails->amount;
                }else{
                    $couponAmount = $total_amount * ($couponDetails->amount/ 100);
                }

                // Add Coupon code in session

                Session::put('couponAmount', $couponAmount);
                Session::put('couponCode', $data["coupon_code"]);

                return redirect()->back()->with('flash_message_success','Coupon code is successfully applied. You are availing discount');


            }
        }
    }
    // end apply coupon

    // start checkout
        public function checkout(Request $request){
            $user_id = Auth::user()->id;
            $user_email = Auth::user()->email;
            $userDetails = User::find($user_id);
            $countries = Country::get();
            // if shipping address exists
            $shippingCount = DeliveryAddress::where('user_id', $user_id)->count();
            $shippingDetails = array();

            if($shippingCount > 0){
                $shippingDetails = DeliveryAddress::where('user_id', $user_id)->first();
            }
            //UPDATE cart table with email
            $session_id = Session::get('session_id');
            DB::table('cart')->where(['session_id' => $session_id])->update(['user_email' => $user_email]);


            if($request->isMethod('POST')){
                $data = $request->all();
                // update user details
                User::where('id', $user_id)->update(['name' => $data["billing_name"], 'address' => $data['billing_address'], 'city' => $data["billing_city"], 'state' => $data['billing_state'], 'country' => $data["billing_country"], 'pincode' => $data['billing_pincode'], 'mobile' => $data["billing_mobile"]]);

                if($shippingCount > 0){
                    // update shipping address
                    DeliveryAddress::where('user_id', $user_id)->update(['name' => $data["shipping_name"], 'address' => $data['shipping_address'], 'city' => $data["shipping_city"], 'state' => $data['shipping_state'], 'country' => $data["shipping_country"], 'pincode' => $data['shipping_pincode'], 'mobile' => $data["shipping_mobile"]]);
                }else{
                    $shipping = new DeliveryAddress;
                    $shipping->user_id = $user_id;
                    $shipping->user_email = $user_email;
                    $shipping->name = $data["shipping_name"];
                    $shipping->address = $data["shipping_address"];
                    $shipping->city = $data["shipping_city"];
                    $shipping->state = $data["shipping_state"];
                    $shipping->country = $data["shipping_country"];
                    $shipping->pincode = $data["shipping_pincode"];
                    $shipping->mobile = $data["shipping_mobile"];
                    $shipping->save();

                }
                return redirect()->action('ProductsController@orderReview');
            }

            return view('wayshop.products.checkout')->with(compact('userDetails', 'countries','shippingDetails'));
        }

    //end checkout

    // start order review 
        public function orderReview(){
            $user_id = Auth::user()->id;
            $user_email = Auth::user()->email;
            $userDetails = User::find($user_id);
            $shippingDetails = DeliveryAddress::where('user_id', $user_id)->first();
            $userCart = DB::table('cart')->where(['user_email' => $user_email])->get();
            foreach($userCart as $key => $product){
                $productDetails = Products::where('id', $product->product_id)->first();
                $userCart[$key]->image = $productDetails->image;

            }
            return view('wayshop.products.order_review')->with(compact('userDetails',  'shippingDetails', 'userCart'));
        }
    // end order review

    // start place order

    public function placeOrder(Request $request){
        if($request->isMethod('post')){
            $user_id = Auth::user()->id;
            $user_email = Auth::user()->email;
            $data = $request->all();

            // Get Shipping Details of users
            $shippingDetails = DeliveryAddress::where(['user_email' => $user_email])->first();
            if(empty(Session::get('couponCode'))){
                $coupon_code = 'Not Use';
            }else{
                $coupon_code = Session::get('couponCode');
            }

            if(empty(Session::get('couponAmount'))){
                $coupon_amount = '0';
            }else{
                $coupon_amount = Session::get('couponAmount');
            }
            $order = new Orders;
            $order->user_id = $user_id;
            $order->user_email = $user_email;
            $order->name = $shippingDetails->name;
            $order->address = $shippingDetails->address;
            $order->city = $shippingDetails->city;
            $order->state = $shippingDetails->state;
            $order->country = $shippingDetails->country;
            $order->pincode = $shippingDetails->pincode;
            $order->mobile = $shippingDetails->mobile;
            $order->coupon_code = $coupon_code;
            $order->coupon_amount = $coupon_amount;
            $order->order_status = "New";
            $order->payment_method = $data["payment_method"];
            $order->grand_total = $data["grand_total"];
            $order->save();

            $order_id = DB::getPdo()->lastinsertID();
            $cartProducts = DB::table('cart')->where(['user_email'=>$user_email])->get();
            foreach($cartProducts as $pro){
                $cartPro = new OrdersProduct;
                $cartPro->order_id = $order_id;
                $cartPro->user_id = $user_id;
                $cartPro->product_id = $pro->product_id;
                $cartPro->product_name = $pro->product_name;
                $cartPro->product_code = $pro->product_code;
                $cartPro->product_size = $pro->size;
                $cartPro->product_price = $pro->price;
                $cartPro->product_qty = $pro->quantity;
                $cartPro->save();

            }
            Session::put('order_id', $order_id);
            Session::put('grand_total', $data['grand_total']);
            return redirect('/thanks');
        }
    }

    // end place order

    // start thanks

    public function thanks(){
        $user_email = Auth::user()->email;
        DB::table('cart')->where('user_email', $user_email)->delete();

        return view('wayshop.orders.thanks');
    }
    ///end thanks

    // start user orders
        public function userOrders(){
            $user_id = Auth::user()->id;
            $orders = Orders::with('orders')->where('user_id', $user_id)->orderBy('id', 'DESC')->get();
            
            return view('wayshop.orders.user_orders')->with(compact('orders'));
        }
    // end user orders

    public function userOrderDetails($order_id){
        $orderDetails = Orders::with('orders')->where('id', $order_id)->first();
        $user_id = $orderDetails->user_id;
        $userDetails = User::where('id', $user_id)->first();
        return view('wayshop.orders.user_order_details')->with(compact('orderDetails', 'userDetails'));

    }


    public function viewOrders(){
        $orders = Orders::with('orders')->orderBy('id', 'DESC')->get();
        return view("admin.orders.view_orders")->with(compact('orders'));

    }




}
