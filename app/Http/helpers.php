<?php

use App\Models\Category;
use App\Models\User;
use App\Models\County;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Log;




function price($ad){

  $user = User::whereId($ad->user_id)->first();
  return 'KES '.$ad->price;

}



function discount($id)
{

    // Find the product by its ID
    $product = Product::find($id);

    // Calculate discount and discount percentage
    $markedPrice = $product->marked_price;
    $sellingPrice = $product->price;

    if ($markedPrice && $sellingPrice) {
        $discount = $markedPrice - $sellingPrice;
        $discountPercentage = ($discount / $markedPrice) * 100;

     return round($discountPercentage, 2);
    }

  return 0;
  
}


//get user
function username($id){


 if (is_numeric($id)){
  $user = User::find($id);
  return $user;

}else{
  return $id;
}
}
function tag($id){
  $page = Page::find($id);
  return $page;
}
function homePath()
{
    return url('/');
}

// function post_path($id='')
// {
//  $post = Page::find($id);
//  $path = homePath()."/".$post->slug;

//  return $path;
// }

function post_path($id = '')
{
    $post = Page::find($id);

    if ($post === null) {
        Log::error("Post with id {$id} not found.");
        return homePath() . "/not-found";
    }

    return homePath() . "/" . $post->slug;
}


function job_path($id='')
{
 $post = Post::find($id);
 $path = homePath()."/job/".$post->slug;

 return $path;
}

function getJobtype($id){
  $type="";
  if($id == 1){
    $type="Full Time";
  }
  if($id == 2){
    $type="Part Time";
  }
  if($id == 3){
    $type="Contract";
  }
  if($id == 4){
    $type="Remote";
  }
  return $type;

}

function getCounty($id){
  $count=County::find($id);
  return $count;
}

function  category($id){
  $result =Category::find($id);
  return $result;
}
function  sub_category($id){
  $result =SubCategory::find($id);
  return $result;
}

function product($id=""){
  $product =Product::find($id);
  return $product;
}


?>