<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Contact;
use App\Models\County;
use App\Models\Option;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Notification;
use App\Models\Page;
use App\Models\Tag;
use App\Models\Post_tag;
use App\Models\Post;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Media;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Services\MpesaService;
use Illuminate\Support\Facades\Log;
use App\Models\ActivityLog; // Make sure this is the correct path
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected MpesaService $mpesaService)
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */



public function index()
{
    $orders = Order::orderBy('id', 'desc')->get();
    $users = User::orderBy('id', 'desc')->get();
    $invoices = Invoice::orderBy('id', 'desc')->get();
    $enquiries = Notification::orderBy('id', 'desc')->get();

    // Additional Metrics
    $totalRevenue = Order::whereStatus('paid')->sum('total_amount');
    $recentOrders = Order::whereStatus('paid')->where('created_at', '>=', now()->subDays(7))->count();
    $newUsers = User::where('created_at', '>=', now()->subDays(30))->count();
    $recentUsers = User::latest()->limit(5)->get();
 $recentActivities = ActivityLog::latest()->limit(5)->get(); 

    if (Auth::user()->is_admin()) {
        return view('admin.dashboard', compact(
            'orders',
            'users',
            'invoices',
            'enquiries',
            'totalRevenue',
            'recentOrders',
            'newUsers',
            'recentUsers',
            'recentActivities'
        ));
    } else {
        return redirect()->route('account.dashboard')->with('success', 'Login success');
    }
}



    public function product(){
        $posts  = Post::orderBy('id', 'desc')->paginate(20);
        $categories =Category::orderBy('id','desc')->get();
        return view('admin.products', compact('posts','categories'));
    }




    

    public function createJob(){
        $categories =Category::orderBy('id','desc')->get();
        return view('admin.create_job',compact('categories'));
    }


    //add tag

    public function saveTag(Request $request)
    {
        $data = [
            'name' => $request->name,
        ];
        Tag::create($data);


        return back()->withInput()->with('success', trans('Add success'));
    }



    public function savePost(Request $request)
    {
        $user_id = Auth::user()->id;

        //save post

        $data = [
            'title'       => $request->title,
            'description' => $request->description,
            'user_id'     => $user_id,

        ];

        $post_created = Post::create($data);

        //save tags
        $tags = serialize($request->tags);
        $tags = unserialize($tags);
        $all_tags = Tag::all();


        foreach ($all_tags as $all_tag) {
            if (array_key_exists($all_tag->id, $tags)) {

                $duplicate = Post_tag::wherePostId($all_tag->id)->count();
                if ($duplicate > 0) {
                } else {

                    $data = [
                        'tag_id'   => $all_tag->id,
                        'post_id'   => $post_created->id,

                    ];

                    Post_tag::create($data);
                }
            }
        }

        return back()->withInput()->with('success', trans('Add success'));
    }

    public function category(){
        $categories =Category::orderBy('id','desc')->paginate(20);
        return view('admin.categories', compact('categories'));
    }


    public function newPost(){

        return view('admin.posts.new');
    }

    public function saveCategory(Request $request){
        $validateData=$this->validate($request,['name'=>'required|string']);
        $slug = str_replace(' ', '-', $request->input('name'));

        // To make the slug lowercase (optional)
        $slugs = strtolower($slug);

        // $data=[
        //     'name'=>$validateData['name'],
        //     'slug'=>$slug,
        // ];
        // dd($data);
        $cat=new Category;
        $cat->name=$validateData['name'];
        $cat->slug=$slugs;
        $cat->save();
        
        return back()->with('success','Category created successfuly');
    }

    public function updateCategory(Request $request, $id){
        $validateData=$this->validate($request,['name'=>'required|string']);

        $slug = str_replace(' ', '-', $request->input('name'));

        // To make the slug lowercase (optional)
        $slug = strtolower($slug);

        $category=Category::findOrFail($id);
        $category->name=$request->name;
        $category->slug=$slug;



    if($request->hasFile('photo')) {

          

            $fileNameWithExt = $request->photo->getClientOriginalName();
            $fileName =  pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $Extension = $request->photo->getClientOriginalExtension();
            $filenameToStore = $fileName . '-' . time() . '.' . $Extension;
            $request->photo->storeAs('uploads/images/', $filenameToStore,'public');


        

            $category->photo = url('/').'/storage/uploads/images/'.$filenameToStore;
                       
        }


        // dd($category);
        $category->update();
        return back()->with('success','Category update successfuly');
    }
    public function updateLocation(Request $request, $id){
        
        $validateData=$this->validate($request,['name'=>'required|string']);

        $location=County::findOrFail($id);
        $location->name=$request->name;
        $location->update();
        return back()->with('success','Location update successfuly');
    }

    public function editPost($id){
        $post=Post::findOrFail($id);

        return view('admin.update_product',compact('post'));
    }


    public function updatePost(Request $request, $id){
        $slug = str_replace(' ', '-', $request->input('title'));

        // To make the slug lowercase (optional)
        $slug = strtolower($slug);

        // dd($slug);
        
        $post=Post::findOrFail($id);
        $post->title = $request->input('title');
        $post->job_type = $request->input('job_type');
        $post->location = $request->input('location');
        $post->company_name = $request->input('company_name');
        $post->description = $request->input('description');
        $post->category_id = $request->input('category_id');
        $post->slug = $slug;


        if($request->hasFile('photo')) {
            $file_path = normalizeFilePath(storage_path().'/app/public/'.$post->photo);

            if(File::exists($file_path)) {
                File::delete($file_path); //delete from storage
                // Storage::delete($file_path); //Or you can do it as well
            }

            $fileNameWithExt = $request->photo->getClientOriginalName();
            $fileName =  pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $Extension = $request->photo->getClientOriginalExtension();
            $filenameToStore = $fileName . '-' . time() . '.' . $Extension;
            $request->photo->storeAs('uploads/images/', $filenameToStore,'public');
            $post->photo = 'uploads/images/'.$filenameToStore;
        }


        // dd($post);
        $post->update();
        return redirect()->route('products')->with('success','Product update successfuly');
    }

    public function SavePosts(Request $request){
        $rule = [
            'name'=>['bail','required','max:255'],
            'price'=>['bail','required','max:255'],
            'description'=>['bail','required'],
            'category_id'=>['bail','required'],
        ];

        $this->validate($request, $rule);
        $user =Auth::user()->id;
        $name = $request->input('name');

        // Replace spaces with hyphens
        $slug = str_replace(' ', '-', $name);

        // To make the slug lowercase (optional)
        $slug = strtolower($slug);

        // dd($slug);
        $product = new Post;
        $product->title = $request->input('name');
        $product->price = $request->input('price');
        $product->description = $request->input('description');
        $product->category_id = $request->input('category_id');
        $product->user_id = $user;
        $product->slug = $slug;
        if($request->hasFile('photo')) {
            $fileNameWithExt = $request->photo->getClientOriginalName();
            $fileName =  pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $Extension = $request->photo->getClientOriginalExtension();
            $filenameToStore = $fileName . '-' . time() . '.' . $Extension;
            $path = $request->photo->storeAs('uploads/images/', $filenameToStore,'public');
            $product->photo = 'uploads/images/'.$filenameToStore;
            }
        // dd($product);
        $product->save();

        return redirect()->route('products')->with('success','Product update successfuly');
    }

    public function pages(){
        $pages  = Page::orderBy('id', 'desc')->paginate(20);
        return view('admin.pages',compact('pages'));
    }

    public function destroy($id){
        $page =Page::find($id);
        if(!$page){
            return back()->with('error', 'Page does not exist');
        }
        // Collect file paths before DB delete
        $mediaPaths = Media::where('page_id', $page->id)->pluck('file_path')->toArray();
        $pagePhoto  = $page->photo;

        // Delete related media then page to satisfy FK constraints
        DB::beginTransaction();
        try {
            Media::where('page_id', $page->id)->delete();
            $page->delete();
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete page: '.$e->getMessage());
        }

        // Best-effort: remove files from disk
        foreach ($mediaPaths as $fp) {
            $rel = $this->toPublicDiskPath($fp);
            if ($rel) {
                @Storage::disk('public')->delete($rel);
            }
        }
        if ($pagePhoto) {
            @Storage::disk('public')->delete($pagePhoto);
        }
        return back()->with('success','Page Deleted successfuly');
    }

    public function bulkPages(Request $request)
    {
        $action = $request->input('action') ?: $request->input('action2');
        $ids = $request->input('ids', []);

        if (!$ids || !is_array($ids)) {
            return back()->with('error', 'No pages selected.');
        }

        if ($action === 'delete') {
            try {
                DB::beginTransaction();
                // Collect files to remove
                $mediaPaths = Media::whereIn('page_id', $ids)->pluck('file_path')->toArray();
                $pagePhotos = Page::whereIn('id', $ids)->pluck('photo')->toArray();

                Media::whereIn('page_id', $ids)->delete();
                Page::whereIn('id', $ids)->delete();
                DB::commit();

                // Remove physical files after DB commit
                foreach ($mediaPaths as $fp) {
                    $rel = $this->toPublicDiskPath($fp);
                    if ($rel) {
                        @Storage::disk('public')->delete($rel);
                    }
                }
                foreach ($pagePhotos as $pp) {
                    if ($pp) {
                        @Storage::disk('public')->delete($pp);
                    }
                }
                return back()->with('success', 'Selected pages deleted successfully.');
            } catch (\Throwable $e) {
                DB::rollBack();
                return back()->with('error', 'Bulk delete failed: '.$e->getMessage());
            }
        }

        return back()->with('error', 'Please choose a valid bulk action.');
    }

    private function toPublicDiskPath(?string $filePath): ?string
    {
        if (!$filePath) return null;
        $path = $filePath;
        if (preg_match('#^https?://#i', $path)) {
            $u = parse_url($path, PHP_URL_PATH) ?: '';
            $path = ltrim($u, '/');
        }
        $path = ltrim($path, '/');
        if (\Illuminate\Support\Str::startsWith($path, 'storage/')) {
            $path = substr($path, strlen('storage/'));
        }
        // Keep only the part under uploads/ when present
        $pos = strpos($path, 'uploads/');
        if ($pos !== false) {
            $path = substr($path, $pos);
        }
        return $path ?: null;
    }
    public function location(){
        $pages  = County::orderBy('id', 'desc')->paginate(20);
        return view('admin.locations',compact('pages'));
    }

    public function SavePage(Request $request){
        $rule = [
            'title'=>['bail','required','max:255'],
            'meta_title'=>['bail','required','max:255'],
            'description'=>['bail','required'],
            'meta_description'=>['bail','required'],
        ];

        $this->validate($request, $rule);
        $user =Auth::user()->id;

        $title = $request->input('title');
        $slug = str_replace(' ', '-', $title);
        $slug = strtolower($slug);

        // Check if the slug already exists
        $slugExists = Page::where('slug', $slug)->exists();
        if ($slugExists) {
            return redirect()->back()->with(['error' => 'The title already exists. Please use a different title.'])->withInput();
        }
        $page = new Page;
        $page->title = $request->input('title');
        $page->meta_title = $request->input('meta_title');
        $page->type = $request->input('type');
        $page->description = $request->input('description');
        $page->meta_description = $request->input('meta_description');
        $page->alter_text = $request->input('alter_text');
        $page->head_2 = $request->input('head_2');
        $page->slug = $slug;
        if($request->hasFile('photo')) {
            $fileNameWithExt = $request->photo->getClientOriginalName();
            $fileName =  pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $Extension = $request->photo->getClientOriginalExtension();
            $filenameToStore = $fileName . '-' . time() . '.' . $Extension;
            $path = $request->photo->storeAs('uploads/images/', $filenameToStore,'public');
            $page->photo = 'uploads/images/'.$filenameToStore;
            }
        $page->save();

        return redirect()->route('pages')->with('success','Page Created successfuly');
    }
    public function saveLocation(Request $request){
        $rule = [
            'name'=>['bail','required','max:255'],
        ];

        $this->validate($request, $rule);

        $page = new County;
        $page->name = $request->input('name');
        $page->save();
        return redirect()->route('location')->with('success','County Created successfuly');
    }


    public function updatePage(Request $request,$id){
        $rule = [
            'title'=>['bail','required','max:255'],
            'meta_title'=>['bail','required','max:255'],
            'description'=>['bail','required'],
            'meta_description'=>['bail','required'],
        ];

        $this->validate($request, $rule);
        $user =Auth::user()->id;
        $title = $request->input('title');
        $slug = str_replace(' ', '-', $title);
        $slug = strtolower($slug);

        $page =Page::findOrFail($id);
        $page->title = $request->input('title');
        $page->meta_title = $request->input('meta_title');
        $page->type = $request->input('type');
        $page->description = $request->input('description');
        $page->meta_description = $request->input('meta_description');
        $page->alter_text = $request->input('alter_text');
        $page->head_2 = $request->input('head_2');
        $page->slug = $slug;
        if($request->hasFile('photo')) {
            $file_path = normalizeFilePath(storage_path().'/app/public/'.$page->photo);

            if(File::exists($file_path)) {
                File::delete($file_path); //delete from storage
                // Storage::delete($file_path); //Or you can do it as well
            }

            $fileNameWithExt = $request->photo->getClientOriginalName();
            $fileName =  pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $Extension = $request->photo->getClientOriginalExtension();
            $filenameToStore = $fileName . '-' . time() . '.' . $Extension;
            $request->photo->storeAs('uploads/images/', $filenameToStore,'public');
            $page->photo = 'uploads/images/'.$filenameToStore;
        }
        // dd($page);
        $page->update();


        return redirect()->route('pages')->with('success','Page updated successfuly');
    }

    public function enquiries(){
        $enquiries =Contact::orderBy('id','desc')->paginate(30);
        return view('admin.enquiries', compact('enquiries'));
    }


    public function Allusers(){
        $users =User::orderBy('id','desc')->paginate();
        return view('admin.users',compact('users'));
    }

    public function saveUser(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator)
                ->with('error', 'There was an error in your form submission.');
        }
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'user_type' => 'editor',
            'password' => Hash::make($request->password),
        ];
        User::create($data);
        return back()->withInput()->with('success', trans('Add success'));
    }
    public function updateUser(Request $request, $id)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator)
                ->with('error', 'There was an error in your form submission.');
        }
        $user=User::findOrFail($id);
        $user->name=$request->name;
        $user->email=$request->email;
        $user->user_type=$request->user_type;
        // dd($user);
        $user->save();
        return back()->withInput()->with('success', trans('Updated success'));
    }

    public function loginAs($id)
    {


        $admin = Auth::user()->id;
        $user = User::find($id);
        Auth::login($user);

        //  session()->put('admin_id', $admin);


        return redirect(route('home'))->with('success', 'login success');
    }

    public function settings (){
        $options =Option::all();
        
        return view('admin.settings',compact('options'));
    }


   public function pages_content (){
        $options =Option::all();
        
        return view('admin.pages_content',compact('options'));
    }


    //update options
    public function updateOptions(Request $request)
    {


        $inputs = Arr::except($request->input(), ['_token']);
        
        foreach ($inputs as $key => $value) {
            $option = Option::firstOrCreate(['option_key' => $key]);
            $option->option_value = $value;
            
            $option->save();
        }
        //check is request comes via ajax?
        if ($request->ajax()) {
            return ['success' => 1, 'msg' => 'update made successfully'];
        }


        if($request->hasFile('photo')) {

            $file_path = normalizeFilePath(storage_path().'/app/public/'.get_option('favicon'));

            if(File::exists($file_path)) {
                File::delete($file_path); //delete from storage
            }

            $fileNameWithExt = $request->photo->getClientOriginalName();
            $fileName =  pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $Extension = $request->photo->getClientOriginalExtension();
            $filenameToStore = $fileName . '-' . time() . '.' . $Extension;
            $request->photo->storeAs('uploads/images/', $filenameToStore,'public');

            $option               = Option::firstOrCreate(['option_key' => 'favicon']);
            $option->option_value = url('/').'/storage/uploads/images/'.$filenameToStore;
            $option->save();
            
        }



        if($request->hasFile('logo')) {

            $file_path = normalizeFilePath(storage_path().'/app/public/'.get_option('logo'));

            if(File::exists($file_path)) {
                File::delete($file_path); //delete from storage
            }

            $fileNameWithExt = $request->logo->getClientOriginalName();
            $fileName =  pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $Extension = $request->logo->getClientOriginalExtension();
            $filenameToStore = $fileName . '-' . time() . '.' . $Extension;
            $request->logo->storeAs('uploads/images/', $filenameToStore,'public');

            $option               = Option::firstOrCreate(['option_key' => 'logo']);
            $option->option_value = url('/').'/storage/uploads/images/'.$filenameToStore;
            $option->save();
            
        }


        if($request->hasFile('hero_image')) {

            $file_path = normalizeFilePath(storage_path().'/app/public/'.get_option('hero_image'));

            if(File::exists($file_path)) {
                File::delete($file_path); //delete from storage
            }

            $fileNameWithExt = $request->hero_image->getClientOriginalName();
            $fileName =  pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $Extension = $request->hero_image->getClientOriginalExtension();
            $filenameToStore = $fileName . '-' . time() . '.' . $Extension;
            $request->hero_image->storeAs('uploads/images/', $filenameToStore,'public');

            $option               = Option::firstOrCreate(['option_key' => 'hero_image']);
            $option->option_value = url('/').'/storage/uploads/images/'.$filenameToStore;
            $option->save();
            
        }



        return redirect()->back()->with('success', 'Update made successfully');
    }

    public function deleteCategory($id){
        $category =Category::findorFail($id);
        if(!$category){
            return redirect()->back()->with('error', 'No category found');
        }else{
            $category->delete();
            return redirect()->back()->with('success', 'Deleted successfully');
        }
    }



}
