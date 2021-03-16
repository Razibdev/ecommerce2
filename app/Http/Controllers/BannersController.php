<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use RealRashid\SweetAlert\Facades\Alert;

use Image;
use App\Banners;
class BannersController extends Controller
{   

    public function addBanner(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $banner = new Banners;
            $banner->name = $data["banner_name"];
            $banner->text_style = $data["text_style"];
            $banner->content = $data["banner_content"];
            $banner->link = $data["link"];
            $banner->sort_order = $data["sort_order"];
            
            // Upload image

            if($request->hasFile('image')){
                echo $img_tmp = $request->file('image');
                if($img_tmp->isValid()){
                    // image path code
                    $extension = $img_tmp->getClientOriginalExtension();
                    $file_name = rand(111,9999).'.'.$extension;
                    $img_path = 'uploads/banners/'.$file_name;

                    // img size

                    Image::make($img_tmp)->resize(500,500)->save($img_path);
                    $banner->image = $file_name;
                }

            }

            $banner->save();
            return redirect('/admin/banners')->with('flash_message_success', 'Banners has been uploaded successfully!!');

        }
        return view('admin.banner.add_banner');
    }

    public function banners(){
        $banners = Banners::get();
        return view('admin.banner.banners')->with(compact('banners'));
    }

    public function editBanner(Request $request, $id = null){
        if($request->isMethod('post')){
            $data = $request->all();

            // Upload Image

            if($request->hasFile('image')){
                echo $img_tmp = $request->file('image');
                if($img_tmp->isValid()){
                    // image path code
                    $extension = $img_tmp->getClientOriginalExtension();
                    $file_name = rand(111,9999).'.'.$extension;
                    $img_path = 'uploads/banners/'.$file_name;

                    // img size

                    Image::make($img_tmp)->resize(500,500)->save($img_path);
                }

            }else{
                $file_name = $data["current_image"];
            }

            Banners::where(['id' => $id])->update(['name' => $data["banner_name"], 'text_style' => $data["text_style"], 'content' => $data["banner_content"], 'link' => $data['link'], 'sort_order' => $data["sort_order"], 'image' => $file_name]);
            return redirect('/admin/banners/')->with('flash_message_success', 'Banner has been edited successfully');

        }
        $bannerDetails = Banners::where(['id' => $id])->first();
        return view('admin.banner.edit_banner')->with(compact('bannerDetails'));
    }


    public function deleteBanner($id=null){
        Banners::where(['id' => $id])->delete();
        Alert::success('Deleted Successfull', 'Success Message');
        return redirect()->back()->with('flash_message_error', 'Banner Deleted');
    }

    public function updateStatus(Request $request, $id = null){
        $data = $request->all();
        Banners::where('id', $data['id'])->update(['status' => $data['status']]);

    }


}
