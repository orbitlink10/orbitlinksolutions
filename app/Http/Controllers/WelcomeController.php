<?php

namespace App\Http\Controllers;

use App\Filters\CategoryFilter;
use App\Filters\JobTitleFilter;
use App\Filters\LocationFilter;
use App\Filters\PostFilter;
use App\Mail\AdminOrderNotification;
use App\Mail\NewUserAdminNotification;
use App\Mail\OrderReceived;
use App\Mail\WelcomeUserMail;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Option;
use App\Models\Slider;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Page;
use App\Models\Post_tag;
use App\Models\Post;
use App\Models\Product;
use App\Models\Sitemap;
use App\Models\Testimonial;
use App\Models\Service;
use App\Models\Media;
use App\Models\Tag;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Services\MpesaService;
use Illuminate\Support\Facades\Mail;
use SmoDav\Mpesa\Laravel\Facades\STK;

class WelcomeController extends Controller
{

    public function __construct(protected MpesaService $mpesaService)
    {
    }




    
    //post lists
    public function index(Request $request)
    {
        $posts  = Post::orderBy('id', 'desc')->paginate(30);
        $pages = Page::whereType('page')
            ->get();
            
        $new  = Post::orderBy('id', 'desc')->take(5)->get();
        $tags = Category::all();
        if ($request->search) {
            $posts  = Post::where('id', 'like', "%{$request->search}%")->orWhere('title', 'like', "%{$request->search}%")->paginate(4);
        }
        $jobTitle = $request->input('job_title');
        $location = $request->input('location');
        $category = $request->input('category');
        if ($jobTitle || $location || $category) {
            $query = Post::orderBy('id', 'desc');

            if ($jobTitle) {
                $query->where('title', 'like', "%$jobTitle%");
            }

            if ($location) {
                $query->where('location', $location);
            }
            if ($category) {
                $query->where('category_id', $category);
            }

            $posts = $query->paginate(4);
        }

        $options =Option::all();
        $sliders =Slider::all();

        $products = Product::with(['mediaFiles', 'category'])->whereProductType('product')->orderBy('id', 'desc')->limit(8)->get();

$testimonials = Testimonial::all();
$medias = Media::whereMediaType('installation')->limit(30)->get();
$medias2 = Media::whereMediaType('media')->limit(30)->get();
$services = Service::all();
$categories = Category::orderBy('id', 'desc')->get();


        return view('theme.'.get_option('theme').'.index', compact('pages','posts', 'tags', 'new','options', 'products','testimonials', 'services', 'medias','medias2', 'categories', 'sliders'));
    }



       //post lists
    public function allcategories(Request $request)
    {

$categories = Category::orderBy('id', 'desc')->get();
return view('theme.'.get_option('theme').'.allcategories', compact('categories'));


    }

public function reviews()
{
    try {
        // Fetch testimonials with pagination and default to the latest first
        $testimonials = Testimonial::latest()->paginate(10);

        // Fetch the theme, defaulting to 'default' if no theme is set
        $theme = get_option('theme') ?? 'default';

        // Return the view with testimonials
        return view('theme.' . $theme . '.reviews', compact('testimonials'));
    } catch (\Exception $e) {
        // Handle exceptions gracefully
        return back()->with('error', 'Unable to fetch testimonials at this time. Please try again later.');
    }
}

public function speedTest()
{
    $presets = [
        'quick' => [
            'label' => 'Quick',
            'download' => 4 * 1024 * 1024,
            'upload' => 2 * 1024 * 1024,
        ],
        'standard' => [
            'label' => 'Standard',
            'download' => 16 * 1024 * 1024,
            'upload' => 8 * 1024 * 1024,
        ],
        'detailed' => [
            'label' => 'Detailed',
            'download' => 32 * 1024 * 1024,
            'upload' => 16 * 1024 * 1024,
        ],
    ];
    $theme = get_option('theme') ?: 'orbit';
    $view = 'theme.' . $theme . '.speed_test';

    if (!view()->exists($view)) {
        $view = 'theme.orbit.speed_test';
    }

    return view($view, compact('presets'));
}

public function speedTestDownload(Request $request)
{
    $bytes = (int) $request->query('bytes', 16 * 1024 * 1024);
    $bytes = max(1024, min($bytes, 64 * 1024 * 1024));

    return response()->stream(function () use ($bytes) {
        if (function_exists('set_time_limit')) {
            @set_time_limit(120);
        }

        $remaining = $bytes;
        $chunkSize = 64 * 1024;

        while ($remaining > 0 && !connection_aborted()) {
            $size = min($chunkSize, $remaining);
            echo random_bytes($size);
            $remaining -= $size;

            if (ob_get_level() > 0) {
                @ob_flush();
            }

            flush();
        }
    }, 200, [
        'Content-Type' => 'application/octet-stream',
        'Content-Length' => (string) $bytes,
        'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0, no-transform',
        'Pragma' => 'no-cache',
        'Content-Encoding' => 'identity',
        'Accept-Ranges' => 'none',
        'X-Accel-Buffering' => 'no',
    ]);
}

public function speedTestUpload(Request $request)
{
    $bytes = $request->headers->get('Content-Length');

    if ($bytes === null) {
        $bytes = strlen($request->getContent());
    }

    return response()->json([
        'bytes' => (int) $bytes,
        'received_at' => now()->toIso8601String(),
    ])->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
}

public function calculators()
{
    $theme = get_option('theme') ?: 'orbit';
    $view = 'theme.' . $theme . '.calculators';

    if (!view()->exists($view)) {
        $view = 'theme.orbit.calculators';
    }

    return view($view);
}



    
    public function storeUser(Request $request)
    {
        // Define validation rules
        $rules = [
            'first_name'    => 'required',
            'last_name'     => 'required', // Assuming last_name is also required
            'phone'         => 'required',
        ];

        // Validate request data
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Create email and password
        $email = $request->email;;
        $password = $request->password; // Use raw phone number for initial password, as bcrypt will hash it later

        // Check if the user already exists
        if (User::whereEmail($email)->exists()) {
            return back()->withInput($request->input())->with('error', trans('app.email_exists'));
        }

        // Prepare user data
        $data = [
            'name'              => $request->first_name . ' ' . $request->last_name,
            'email'             => $email,
            'password'          => bcrypt($password), 
            'phone'             => $request->phone,
            'user_type'         => 'buyer',
            'active_status'     => 1
        ];

        // Create the user
        $user_create = User::create($data);

        if ($user_create) {

 
            // Attempt to authenticate the user
            if (Auth::attempt(['email' => $email, 'password' => $password, 'active_status' => '1'])) {

                // Send welcome email to user
                Mail::to($user_create->email)->send(new WelcomeUserMail($user_create));

                // Send notification email to admin
                $adminEmail = get_option('contact_email');  // Set this to your admin's email address
                Mail::to($adminEmail)->send(new NewUserAdminNotification($user_create));
                // Redirect to dashboard if authentication is successful

                return redirect()->route('cart.checkout')->with('success', "Account created successfully!!");  
            



            } else {
                return back()->with('error', trans('app.auth_failed'));
            }
        } else {
            return back()->withInput()->with('error', trans('app.error_msg'));
        }
    }


    public function loginPostUsers(Request $request)
    {
        $rules = [
            'email'    => 'required',
        ];
        //$this->validate($request, $rules);

        //Manually creating validation
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {

            return redirect(route('login'))->withErrors($validator)->withInput();
        }

        //Get input value
        $email      = $request->email;
        $password   = $request->password;

        //Authenticating
        if (Auth::attempt(['email' => $email, 'password' => $password, 'active_status' => '1'])) {
            // Authentication passed...
            return redirect()->back();
        } else {
            return redirect()->back()->with('error', trans('app.email_password_error'));
        }
    }


    public function services()
    {
        return view('theme.'.get_option('theme').'.services');
    }

    
    public function products(Request $request)
    {
        // Start with the query builder
        $query = Product::with(['mediaFiles', 'category'])->where('product_type', 'product');

        // Apply search filter if a query exists
        if ($request->filled('q')) {
            $searchTerm = $request->q;
            $query->where(function ($subQuery) use ($searchTerm) {
                $subQuery->where('name', 'like', "%{$searchTerm}%")
                         ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        $activeCategory = null;
        if ($request->filled('category')) {
            $categoryValue = $request->category;
            $activeCategory = Category::where('slug', $categoryValue)
                ->orWhere('id', $categoryValue)
                ->first();
            if ($activeCategory) {
                $query->where('category_id', $activeCategory->id);
            }
        }

        if ($request->filled('availability')) {
            if ($request->availability === 'in') {
                $query->where('quantity', '>', 0);
            } elseif ($request->availability === 'out') {
                $query->where('quantity', '<=', 0);
            }
        }

        if ($request->filled('min_price')) {
            $query->where('has_price', 1)
                ->whereNotNull('price')
                ->where('price', '>=', (float) $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('has_price', 1)
                ->whereNotNull('price')
                ->where('price', '<=', (float) $request->max_price);
        }

        if ($request->boolean('sale')) {
            $query->where('has_price', 1)
                ->whereNotNull('marked_price')
                ->whereColumn('marked_price', '>', 'price');
        }

        $sort = $request->input('sort', 'newest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        $priceRange = Product::where('product_type', 'product')
            ->where('has_price', 1)
            ->selectRaw('MIN(price) as min_price, MAX(price) as max_price')
            ->first();

        $categories = Category::orderBy('name')->get();

        // Pagination for better performance
        $products = $query->paginate(12);

        // Pass the results to the view
        return view(
            'theme.' . get_option('theme') . '.products',
            compact('products', 'categories', 'activeCategory', 'priceRange')
        );
    }





  public function showProductCategory($slug)
{
    // Attempt to find category by slug
    $category = Category::where('slug', $slug)->first();

    // If no category is found, redirect to homepage
    if (! $category) {
        return redirect()->route('blog_home');
    }

    // Otherwise, load and paginate products in that category
    $products = Product::with(['mediaFiles', 'category'])
        ->where('product_type', 'product')
        ->where('category_id', $category->id)
        ->orderBy('id', 'desc')
        ->paginate(12);

    return view(
        'theme.' . get_option('theme') . '.categories',
        compact('products', 'category')
    );
}




    public function product_details($slug){
        $product = Product::with(['mediaFiles', 'category'])->where('slug',$slug)->first();
        if(!$product){
            abort(404);
        }

              $mediafiles  = $product->mediaFiles;
        return view('theme.'.get_option('theme').'.product_details', compact('product', 'mediafiles'));
    }


    public function product_details_preview($slug){
        $product = Product::with(['mediaFiles', 'category'])->where('slug',$slug)->first();
        if(!$product){
            abort(404);
        }

        $mediafiles  = $product->mediaFiles;
        $themeView = 'theme.' . get_option('theme') . '.product_details';

        return view()->exists($themeView)
            ? view($themeView, compact('product', 'mediafiles'))
            : view('designs.preview', compact('product', 'mediafiles'));
    }


    public function serviceSingle($slug){
    $service = Service::where('slug',$slug)->first();
        if(!$service){

            return back()->with('error','Not Found');

        }

    $mediaFiles  = Media::whereProductId($service->id)->get();
        return view('theme.'.get_option('theme').'.service_single', compact('service', 'mediaFiles'));
    }

    public function about(){
        return view('theme.'.get_option('theme').'.about');
    }
    

    public function faq(){
        return view('theme.'.get_option('theme').'.faq');
    }
    

        public function terms(){
        return view('theme.'.get_option('theme').'.terms');
    }
    
   
    public function contacts(){
        $page = Page::whereSlug("contact")->first();
        return view('theme.'.get_option('theme').'.contact');
    }


    public function blogs(){
        $posts  = Page::whereType('Post')->orderBy('id', 'desc')->paginate(20);
        $categories = Category::all();
        $options =Option::all();
        return view('theme.'.get_option('theme').'.blogs',compact('posts', 'categories', 'options'));
    }
    // public function index(Request $request)
    // {
    //     $postsQuery = Post::orderBy('id', 'desc');
    //     if ($request->search) {
    //         $posts  = Post::where('id', 'like', "%{$request->search}%")->orWhere('title', 'like', "%{$request->search}%")->paginate(4);
    //     }
    //     $posts = app(Pipeline::class)
    //         ->send($postsQuery)
    //         ->through([
    //             JobTitleFilter::class,
    //             LocationFilter::class,
    //             CategoryFilter::class,
    //         ])
    //         ->thenReturn()
    //         ->get();
    //     if($posts->count() > 0){
    //         $posts= $posts->get();
    //     }
    //     $posts=Post::orderBy('id','desc')->paginate(4);

    //     $new = Post::orderBy('id', 'desc')->take(5)->get();
    //     $tags = Category::all();

    //     return view('blog', compact('posts', 'tags', 'new'));
    // }

    public function allPosts()
    {
        $posts  = Post::orderBy('id', 'desc')->paginate(20);
        $new  = Post::orderBy('id', 'desc')->take(5)->get();
        $tags = Category::all();
        $options =Option::all();
        return view('all_blogs', compact('posts', 'new', 'tags','options'));
    }
    public function allArticles()
    {
        $posts  = Page::whereType('Post')->orderBy('id', 'desc')->paginate(20);
        $categories = Category::all();
        $options =Option::all();
        return view('articles', compact('posts', 'categories', 'options'));
    }

    public function show($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $categoryPosts = $category->posts;
        $new  = Post::orderBy('id', 'desc')->take(5)->get();
        $tags = Category::all();
        $options =Option::all();
        // dd($categoryPosts);
        return view('show', compact('category', 'categoryPosts', 'new', 'tags','options'));
    }

    //show single blog
    public function blogSingle($slug)
    {

        $post = Page::where('slug', $slug)->first();
        $title = $post->title;
        $new  = Page::orderBy('id', 'desc')->take(5)->get();
        $category = Category::all();
        $options =Option::all();
        $medias = Media::wherePageId($post->id)->limit(30)->get();
        return view('theme.'.get_option('theme').'.blog_single', compact('new', 'title', 'post', 'category','options', 'medias'));
    }
    public function viewArticle($slug)
    {


        $post = Page::where('slug', $slug)->first();
        $title = $post->title;
        $new  = Post::orderBy('id', 'desc')->take(5)->get();
        $tags = Category::all();
        $options =Option::all();
        return view('view_article', compact('new', 'title', 'post', 'tags','options'));
    }

    //show post for tag selected
    public function tagSelect($id)
    {

        $wpost_count = \App\Models\Post_tag::whereTagId($id)->select('post_id')->distinct()->count();
        if ($wpost_count > 0) {

            $posts_id = \App\Models\Post_tag::whereTagId($id)->select('post_id')->distinct()->get();
        } else {
            return back()->withInput()->with('success', trans('No post with selected tag'));
        }

        $tags = Tag::all();
        return view('blog', compact('posts', 'tags'));
    }
    

    public function viewPage($slug)
    {


        $page = Page::where('slug', $slug)->first();
        $new  = Post::orderBy('id', 'desc')->take(5)->get();
        $tags = Category::all();
        $options =Option::all();
        // dd($post);
        return view('page_single', compact('page', 'new', 'tags','options'));
    }
    public function saveMessage(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);

        DB::beginTransaction();
        try {
            //code...
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'message' => $request->message,
            ];
            Contact::create($data);

            DB::commit();
            return back()->with('success', "Your message has been sent successfully! Will feedback you shortly");
        } catch (\Throwable $th) {
            DB::rollBack();
            $errorMessage = $th->getMessage();
            return back()->with('error', $errorMessage);
        }
    }

    public function sitemap()
    {
        $posts = Sitemap::all();
        // dd("testing");
        return response()->view('sitemap', [
            'posts' => $posts
        ])->header('Content-Type', 'text/xml');
    }

    public function categoriesSitemap()
    {
        $categories = Category::whereNotNull('slug')
            ->orderBy('updated_at', 'desc')
            ->get();

        return response()->view('category_sitemap', [
            'categories' => $categories,
        ])->header('Content-Type', 'text/xml');
    }

    public function productSitemap()
    {
        $products = Product::whereNotNull('slug')
            ->where('product_type', 'product')
            ->orderBy('updated_at', 'desc')
            ->get();

        return response()->view('product', [
            'posts' => $products,
            'sitemaps' => (object) [
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ],
        ])->header('Content-Type', 'text/xml');
    }


    public function sitemaps($sitemap)
    {
        $count = Sitemap::whereUrl($sitemap)->count();
        
        if ($count == '0') {
            $count = Page::whereSlug($sitemap)->whereType('page')->count();

            if ($count == '0') {
                $count = Page::whereSlug($sitemap)->whereType('post')->count();
                
                if ($count == '0') {
                    return redirect(url('/'));
                } else{
                    $page = Page::where('slug', $sitemap)->first();
                    $new  = Post::orderBy('id', 'desc')->take(5)->get();
                    $tags = Category::all();
                    $post = Page::whereSlug($sitemap)->first();
                    $title = $post->title;
                    $categories  = Category::all();
                    $medias = Media::wherePageId($page->id)->limit(30)->get();
                    return view('theme.'.get_option('theme').'.blog_single', compact('page', 'new', 'tags', 'title', 'post', 'categories', 'medias'));


                }


            } else {

                $page = Page::where('slug', $sitemap)->first();
                $new  = Post::orderBy('id', 'desc')->take(5)->get();
                $tags = Category::all();
                $post = Page::whereSlug($sitemap)->first();
                $title = $post->title;
                $categories  = Category::all();
                $medias = Media::wherePageId($page->id)->limit(30)->get();
                return view('theme.'.get_option('theme').'.blog_single', compact('page', 'new', 'tags', 'title', 'post', 'categories', 'medias'));
            }
        } else {

            $sitemaps = Sitemap::whereUrl($sitemap)->first();
           
            if ($sitemaps->type == 'product') {
                // $posts = Page::all();
                $posts = Product::whereNotNull('slug')->get();
                return response()->view('product', [
                    'posts' => $posts,
                    'sitemaps' => $sitemaps
                ])->header('Content-Type', 'text/xml');
            }elseif($sitemaps->type == 'post'){
                $posts = Page::whereNotNull('slug')->whereType($sitemaps->type)->get();
                return response()->view('index', [
                    'posts' => $posts,
                    'sitemaps' => $sitemaps
                ])->header('Content-Type', 'text/xml');
            }
            elseif($sitemaps->type == 'page') {
                $posts = Page::whereNotNull('slug')->whereType($sitemaps->type)->get();
                return response()->view('index', [
                    'posts' => $posts,
                    'sitemaps' => $sitemaps
                ])->header('Content-Type', 'text/xml');
            }
        }
    }

    public function app(){
        $options=Option::all();
        return view('layouts.app',compact('options'));
    }

    // the-landscape-of-translation-services-in-nairobi-kenya



    public function registerUrl(Request $request)
    {
        $registerUrl = 'https://api.safaricom.co.ke/mpesa/c2b/v2/registerurl';

        try {
            $accessToken = $this->generateAccessToken();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        $registerData = $this->prepareRegisterData();

        try {
            $registerResponse = $this->sendRegisterRequest($registerUrl, $accessToken, $registerData);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json(json_decode($registerResponse), 200);
    }

    private function prepareRegisterData()
    {
        return [
            'ShortCode' => '4092475', //8728622
            'ResponseType' => 'Completed',
            'ConfirmationURL' => 'https://starlinkkenya.co.ke/confirmation-url',
            'ValidationURL' => 'https://starlinkkenya.co.ke/validation-url',
        ];
    }

    private function sendRegisterRequest($url, $accessToken, $data)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type:application/json',
            'Authorization:Bearer ' . $accessToken,
        ]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($curl);

        if ($response === false) {
            $error_message = curl_error($curl);
            curl_close($curl);
            throw new Exception("Error: Failed to register URL. Error: $error_message");
        }

        curl_close($curl);

        return $response;
    }




    public function stkPush(Request $request)
    {
        $phoneNumber = $request->input('phone');
        $amount = 1;
        // $amount = $request->input('amount');

        $phone = $request->input('phone');
        $phone = ltrim($phone, '0'); ///phone remove 0
        $phone = ltrim($phone, '+'); //phone remove +
        if (substr($phone, 0, 3) != '254') {
            $phone = "254" . $phone; ///add 254 in the beginning
        } else {
            $phone = $phone;
        }

        $phone  = $phone;
        // $amount = (int)$amount;
        $amount = 1;

        $accessToken = $this->generateAccessToken();

        if (!$accessToken) {
            return response()->json(['error' => 'Unable to get access token'], 500);
        }

        $stkPushUrl = 'https://starlinkkenya.co.ke/mpesa/stkpush/v1/processrequest';
        $shortcode = '4092475';
        $passkey = '8f62a516b3e1e68a7120bb499b078e20d88520af53401d3589e4e7a7e288ed83';
        $partB = '4092475';
        $timestamp = date('YmdHis');
        $password = base64_encode($shortcode . $passkey . $timestamp);

        $callbackUrl = 'https://starlinkkenya.co.ke/stkpush/callback';

        $response = Http::withToken($accessToken)->post($stkPushUrl, [
            'BusinessShortCode' => $shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $amount,
            'PartyA' => $phone,
            'PartyB' => '8858918',
            'PhoneNumber' => $phone,
            'CallBackURL' => $callbackUrl,
            'AccountReference' => 'Webstam',
            'TransactionDesc' => 'Payment for order',
        ]);

        if ($response->successful()) {
            // return response()->json(['message' => 'STK Push request sent successfully', 'data' => $response->json()]);
            return redirect()->back()->with('message', 'STK Push request sent successfully.');
        }
        // Log the response for debugging
        // Log::error('STK Push request failed', ['response' => $response->body()]);

        // return response()->json(['error' => 'STK Push request failed', 'data' => $response->json()], 500);
        return redirect()->back();
    }

    public function initiateStkPush(Request $request)
    {
        $phoneNumber = $request->input('phone');
        $amount = 1;
        // $amount = $request->input('amount');

        $phone = $request->input('phone');
        $phone = ltrim($phone, '0'); ///phone remove 0
        $phone = ltrim($phone, '+'); //phone remove +
        if (substr($phone, 0, 3) != '254') {
            $phone = "254" . $phone; ///add 254 in the beginning
        } else {
            $phone = $phone;
        }

        $phone  = $phone;
        // $amount = (int)$amount;
        $amount = 1;

        $AccountReference = '2345';
        $TransactionDesc = 'payment';

        $response = $this->mpesaService->initiateStkPush($phone, $amount, $AccountReference, $TransactionDesc);

        return redirect()->route('product')->with('success', "Your payment has been received. Your order is being processed.");
    }




    public function storeOrder(Request $request)
    {
    

        // Create and save order to database
        $order = new Order();
        $order->company_name = $request->company_name;
        $order->user_id = Auth::user()->id;
        $order->county_id = $request->county_id;
        $order->address = $request->address;
        $order->total_amount = $request->total;

        // Save the order
        $order->save();

        // Save order items
        foreach ($request->session()->get('cart', []) as $item) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $item['id'];
            $orderItem->quantity = $item['quantity'];
            $orderItem->price = $item['price'];
            $orderItem->size_id = $item['size_id'];
            $orderItem->save();
        }

        // Clear the cart after placing the order
        $request->session()->forget('cart');



        return redirect()->route('account.orders')->with('success', 'Your order has been placed successfully! Please proceed to make the payments');

    }




    public function storeOrder1(Request $request)
{
    $validated = $request->validate([
        'subtotal' => 'required|numeric',
        'total' => 'required|numeric',
        'product_ids' => 'sometimes|array',
        'product_ids.*' => 'exists:products,id',
        'quantities' => 'sometimes|array',
        'quantities.*' => 'integer|min:1'
    ]);

    // Assuming you have already validated the request data
    $orderData = $request->all();
    $subtotal = $orderData['subtotal'];
    $total = $orderData['total'];
    $product_id = $orderData['product_ids'];
    $quantity= $orderData['quantities'];

    // Generate a unique order reference
    $order = Order::create([
        'subtotal' => $validated['subtotal'],
        'total_amount' => $validated['total'],
        'status' => 'pending',
        'user_id' => Auth::user()->id,
    ]);

    // Check if products are provided before trying to attach them
    if (isset($validated['product_ids']) && isset($validated['quantities'])) {
        foreach ($validated['product_ids'] as $index => $productId) {
            $quantity = $validated['quantities'][$index];
            $price = Product::find($productId)->price; // Assuming you have price in the product table
            $order->products()->attach($productId, [
                'quantity' => $quantity,
                'price' => $price
            ]);
        }
    }


    $orderReference = $order->id;

    // Store the order reference in the session
    session(['order_reference' => $orderReference]);

    Mail::to('info@starlinkkenya.co.ke')->send(new AdminOrderNotification($order));

    Mail::to(Auth::user()->email)->send(new OrderReceived($order));

    return redirect()->route('pay_now', ['total' => $orderData['total']]);


}


public function payNow($total){
        $order = Order::find($total);
        return view('theme.'.get_option('theme').'.pay_now', ['order' => $order]);
    }


    public function payNowInvoice($total){
        $order = Invoice::find($total);
        return view('invoices.pay_now', ['order' => $order]);
    }


public function confirmation(Request $request)
{
    $response = $request->all();

    // Log the information to a file
    Log::info($response);

    // Retrieve the order reference from the session
    $orderReference = session('order_reference');

    // Find the order using the order reference stored in the session
    $order = Order::where('order_reference', $orderReference)->first();

    if ($order) {
        // Save the transaction details regardless of amount match
        $transaction = new Transaction();
        $transaction->trans_id = $response['TransID'];
        $transaction->msisdn = $response['MSISDN'];
        $transaction->trans_amount = $response['TransAmount'];
        $transaction->bill_ref = $response['BillRefNumber'];
        $transaction->first_name = $response['FirstName'];
        $transaction->last_name = $response['LastName'];
        $transaction->trans_type = $response['TransactionType'];
        $transaction->businesss_code = $response['BusinessShortCode'];
        $transaction->order_id = $order->id;
        $transaction->save();

        // Check if the transaction amount matches the order total
        if ($order->total_amount == $response['TransAmount']) {
            // Update the order status to 'paid'
            $order->status = 'paid';
            $order->save();

            // Destroy the order_reference session
            session()->forget('order_reference');

            // Return a success response to MPESA
            return response()->json([
                'ResultCode' => "0",
                'ResultDesc' => 'Accepted'
            ]);
        } else {
            // Log the error for amount mismatch
            Log::error('Payment amount does not match order total.', [
                'order_total' => $order->total_amount,
                'transaction_amount' => $response['TransAmount']
            ]);

            // Still destroy the order_reference session
            session()->forget('order_reference');

            // Return a response indicating amount mismatch
            return response()->json([
                'ResultCode' => "1",
                'ResultDesc' => 'Amount Mismatch'
            ]);
        }
    } else {
        // Log the error if order is not found
        Log::error('Order not found for Order Reference: ' . $orderReference);

        // Still destroy the order_reference session
        session()->forget('order_reference');

        // Return an error response if the order is not found
        return response()->json([
            'ResultCode' => "1",
            'ResultDesc' => 'Order Not Found'
        ]);
    }
}     






    // public function confirmation(Request $request)
    // {
    //     $response = $request->all();

    //     // Log the information to a file
    //     Log::info($response);

    //     // Uncomment the following lines when you want to save the data to the database
    //     $transaction = new Transaction();
    //     $transaction->trans_id = $response['TransID'];
    //     $transaction->msisdn = $response['MSISDN'];
    //     $transaction->trans_amount = $response['TransAmount'];
    //     $transaction->bill_ref = $response['BillRefNumber'];
    //     $transaction->first_name = $response['FirstName'];
    //     $transaction->last_name = $response['LastName'];
    //     $transaction->trans_type = $response['TransactionType'];
    //     $transaction->businesss_code = $response['BusinessShortCode'];
    //     $transaction->save();

    //     // Move the return statement to the end
    //     return response()->json([
    //         'ResultCode' => "0",
    //         'ResultDesc' => 'Accepted'
    //     ]);
    // }


    public function generateAccessToken()
    {
        $consumerKey = 'zNZWo4pXCeaJxHPLvmJvA7Ut6AkZvXXT';
        $consumerSecret = 'IXnZXRzqUvgI5kVh';
        $accessTokenUrl = 'https://api.safaricom.co.ke/oauth/v2/generate?grant_type=client_credentials';

        $curl = curl_init($accessTokenUrl);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json; charset=utf8']);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_USERPWD, $consumerKey . ':' . $consumerSecret);

        $response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($status != 200) {
            $error_message = curl_error($curl);
            curl_close($curl);
            throw new Exception("Error: Failed to generate access token. Status Code: $status. Error: $error_message");
        }

        $result = json_decode($response);
        curl_close($curl);

        if (!isset($result->access_token)) {
            throw new Exception("Error: Access token not found in the response.");
        }

        return $result->access_token;
    }

    // public function MpesaRes(Request $request)
    // {
    //     $postData = file_get_contents('php://input');
    //     // error_log("STK Push Result ".$postData);
    //     $array = json_decode($postData, true);
    //     // Log::info($array);
    //     $trn = new Transaction();
    //     // $trn->response = json_encode($array);
    //     $trn->trans_id = $array['Body']['stkCallback']['CallbackMetadata']['Item'][1]['Value'];
    //     // $trn->trans_id = $array['Body']['stkCallback']['MerchantRequestID'];
    //     // $trn->checkoutrequestid = $array['Body']['stkCallback']['CheckoutRequestID'];
    //     // $trn->resultdesc = $array['Body']['stkCallback']['ResultDesc'];
    //     $trn->trans_amount = $array['Body']['stkCallback']['CallbackMetadata']['Item'][0]['Value'];
    //     $trn->bill_ref = $array['Body']['stkCallback']['CallbackMetadata']['Item'][1]['Value'];
    //     // $trn->balance = $content['Body']['stkCallback']['CallbackMetadata']['Item'][2]['Value'];
    //     $trn->msisdn = $array['Body']['stkCallback']['CallbackMetadata']['Item'][4]['Value'];
    //     // $trn->status = 1;
    //     $trn->save();
    // }

    public function MpesaRes(Request $request)
{
    // Get the raw post data from the input stream
    $postData = file_get_contents('php://input');
    $array = json_decode($postData, true);

    // Log the incoming STK Push callback data
    Log::info($array);

    // Retrieve necessary data from the callback
    $transactionId = $array['Body']['stkCallback']['CallbackMetadata']['Item'][1]['Value'];
    $transactionAmount = $array['Body']['stkCallback']['CallbackMetadata']['Item'][0]['Value'];
    $msisdn = $array['Body']['stkCallback']['CallbackMetadata']['Item'][4]['Value'];
    $billRefNumber = $array['Body']['stkCallback']['CallbackMetadata']['Item'][1]['Value'];

    // Retrieve the order reference from the session
    $orderReference = session('order_reference');

    // Find the order using the order reference stored in the session
    $order = Order::where('order_reference', $orderReference)->first();

    if ($order) {
        // Save the transaction details regardless of amount match
        $transaction = new Transaction();
        $transaction->trans_id = $transactionId;
        $transaction->msisdn = $msisdn;
        $transaction->trans_amount = $transactionAmount;
        $transaction->bill_ref = $billRefNumber;
        $transaction->order_id = $order->id;
        $transaction->save();

        // Check if the transaction amount matches the order total
        if ($order->total_amount == $transactionAmount) {
            // Update the order status to 'paid'
            $order->status = 'paid';
            $order->save();

            // Destroy the order_reference session
            session()->forget('order_reference');

            // Return a success response to M-Pesa
            return response()->json([
                'ResultCode' => "0",
                'ResultDesc' => 'Accepted'
            ]);
        } else {
            // Log the error for amount mismatch
            Log::error('Payment amount does not match order total.', [
                'order_total' => $order->total_amount,
                'transaction_amount' => $transactionAmount
            ]);

            // Still destroy the order_reference session
            session()->forget('order_reference');

            // Return a response indicating amount mismatch
            return response()->json([
                'ResultCode' => "1",
                'ResultDesc' => 'Amount Mismatch'
            ]);
        }
    } else {
        // Log the error if order is not found
        Log::error('Order not found for Order Reference: ' . $orderReference);

        // Still destroy the order_reference session
        session()->forget('order_reference');

        // Return an error response if the order is not found
        return response()->json([
            'ResultCode' => "1",
            'ResultDesc' => 'Order Not Found'
        ]);
    }
}

    public function validation(Request $request)
    {
        $response = file_get_contents('php://input');

        $data = json_decode($response, true);
        Log::info('The service request is processed successfully', $data);

        return response()->json([
            'ResultCode' => "0",
            'ResultDesc' => 'Accepted'
        ]);
    }



                  //mpesa payments
                  public function bmpesa(Request $request)
                  {
                  
                   $local_transaction_id    = $request->account;
                   $amount                  = $request->amount;
                   $pay_type                = $request->pay_type;
                   $this->validate($request,[
                     'phone' => 'required',
                   ]);
                  
                   $phone = $request->phone;
                   $phone = ltrim($phone,'0');///phone remove 0 
                   $phone = ltrim($phone,'+');//phone remove +
                   if(substr($phone,0,3)!='254'){
                      $phone = "254".$phone; ///add 254 in the beginning 
                    }else{
                      $phone=$phone;
                    }
                  
                    $phone  =$phone;
                    $amount =$amount;
                  
                  
                  
                  
                    $response         = STK::push($amount, $phone, $local_transaction_id, 'Order Payment');
                    $resultCode       = $response->ResponseDescription;
                    $transactionId    = $response->CheckoutRequestID;
                  
                  
                  $response = STK::validate($transactionId);
                  
                   if (isset($response->errorMessage)) { 
                    if ($request->ajax()){
                      return ['success'=>1, 'msg'=>$response->errorMessage, 'transactionId'=>$transactionId];
                    }
                    
                  
                  }
                  
                  if (isset($response->ResultDesc)) {
                  
                    if($response->ResultDesc == "The service request is processed successfully."){
                     return ['success'=>1, 'msg'=>$response->ResultDesc, 'transactionId'=>$transactionId];
                   } else{
                  
                    if ($request->ajax()){
                      return ['success'=>1, 'msg'=>$response->ResultDesc, 'transactionId'=>$transactionId];
                    }
                  
                  
                  
                  }
                  
                  } else{
                  
                  
                    $ResultDesc = "Check your phone and enter the password";
                  
                    if ($request->ajax()){
                      return ['success'=>1, 'msg'=>$ResultDesc, 'transactionId'=>$transactionId];
                    }
                  
                  }
                  
                  
                  
                  
                  
                  }
            
            
                    public function bconfirmPayment($id){
            
                        $response = STK::validate($id);
                       
                       if (isset($response->errorMessage)) {
                       
                           return ['success'=>1, 'msg'=>$response->errorMessage, 'transactionId'=>$id];
                       
                        
                       
                       }
                       
                       if (isset($response->ResultDesc)) {
                       
                         if($response->ResultDesc == "The service request is processed successfully."){
                          return ['success'=>1, 'msg'=>$response->ResultDesc, 'transactionId'=>$id];
                        } else{
                       
                       
                           return ['success'=>1, 'msg'=>$response->ResultDesc, 'transactionId'=>$id];
                       
                       
                       }
                       
                       } else{
                         $ResultDesc = "Check your phone and enter the password";
                         return ['success'=>1, 'msg'=>$ResultDesc, 'transactionId'=>$id];
                       }
                       
                       
                       
                       }
            
            
                       public function successDeposit($id)
                       {
                           // Retrieve the invoice
                           $invoice = Order::find($id);
                       
                           // Generate a unique transaction ID
                           do {
                               $transaction_id = 'tran_' . time() . Str::random(6);
                           } while (Payment::where('local_transaction_id', $transaction_id)->exists());
                           
                           $transaction_id = strtoupper($transaction_id);
                       
                           // Get the currency sign
                           $currency = "KES";
                       
                           // Prepare payment data
                           $payments_data = [
                               'invoice_id'             => $id,
                               'user_id'                => $invoice->user_id,
                               'amount'                 => $invoice->total_amount,
                               'payment_method'         => 'mpesa',
                               'status'                 => 'success',
                               'currency'               => $currency,
                               'local_transaction_id'   => $transaction_id
                           ];
                       
                           // Create the payment record
                           $payment_created = Payment::create($payments_data);
                       
                           // Check if the invoice total is zero or negative
                           if ($payment_created) {
                               $invoice->status = 'paid';
                               $invoice->save();
                           }
                       


             return redirect()->route('account.orders')->with('success', "Your payment has been received. Your order is being processed. you will receive a call from our sale team in a few");

             
                       }



                public function successDepositInvoice($id)
                       {
                           // Retrieve the invoice
                           $invoice = Invoice::find($id);
                       
                           // Generate a unique transaction ID
                           do {
                               $transaction_id = 'tran_' . time() . Str::random(6);
                           } while (Payment::where('local_transaction_id', $transaction_id)->exists());
                           
                           $transaction_id = strtoupper($transaction_id);
                       
                           // Get the currency sign
                           $currency = "KES";
                       
                           // Prepare payment data
                           $payments_data = [
                               'invoice_id'             => $id,
                               'user_id'                => $invoice->user_id,
                               'amount'                 => $invoice->total_amount,
                               'payment_method'         => 'mpesa',
                               'status'                 => 'success',
                               'currency'               => $currency,
                               'local_transaction_id'   => $transaction_id
                           ];
                       
                           // Create the payment record
                           $payment_created = Payment::create($payments_data);
                       
                           // Check if the invoice total is zero or negative
                           if ($payment_created) {
                               $invoice->status = 'paid';
                               $invoice->save();
                           }
                       


             return redirect()->route('invoices.open', $invoice->slug)->with('success', "Your payment has been received. Your order is being processed. you will receive a call from our sale team in a few");

             
                       }

}
