


<!DOCTYPE html>
<html lang="en-us">

<head>
  <meta charset="utf-8">
  <title>@section('title') Ikokazikenya | Ikokazikenya.com @show</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
  <meta name="description" content="This is meta description">
  <meta name="author" content="Themefisher">
  <link rel="shortcut icon" href="{{ asset('assets2/images/favconk.png')}}" type="image/x-icon">
  <link rel="icon" href="{{asset ('assets2/images/favconk.png')}}" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  
  <!-- theme meta -->
  <meta name="theme-name" content="reporter" />

  <!-- # Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Neuton:wght@700&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- # CSS Plugins -->
  <link rel="stylesheet" href="{{ asset('assets2/plugins/bootstrap/bootstrap.min.css')}}">

  <!-- # Main Style Sheet -->
  <link rel="stylesheet" href="{{ asset('assets2/css/style.css')}}">

  <style>
    /* CSS styles for job listing cards */
    .card {
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 20px;
        overflow: hidden;
    }

    .card-image img {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }

    .card-body {
        padding: 0;
    }

    .post-title {
        font-size: 18px;
        font-weight: bold;
        margin: 10px 0;
    }

    .card-text {
        margin: 0;
        padding: 10px;
    }

    .content a {
        text-decoration: none;
        color: #007bff;
        font-weight: bold;
    }

    .search-container {
      display: flex;
      align-items: center;
    }

    .search-container input {
      flex-grow: 1;
      margin-right: 10px; 
    }


</style>
</head>

<body>

<header class="navigation">
  <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light px-0">
      <a class="navbar-brand order-1 py-0" href="/">
        <img loading="prelaod" decoding="async" class="img-fluid" src="{{ asset('assets2/images/Logo-main.png')}}" alt="ikokazikenya">
      </a>
      <div class="navbar-actions order-3 ml-0 ml-md-4">
        <button aria-label="navbar toggler" class="navbar-toggler border-0" type="button" data-toggle="collapse"
          data-target="#navigation"> <span class="navbar-toggler-icon"></span>
        </button>
      </div>

      <form action="{{ route('blog') }}" method="GET" class="search order-lg-3 order-md-2 order-3 ml-auto">
        <div class="search-container">
          <input name="search" type="search" placeholder="Search..." autocomplete="off" style="margin-right: 0px;">
          <button  class="btn btn-success" style="padding: 13px;"><i class="fe fe-search" aria-hidden="true"></i>Search</button>
        </div>
      </form>
      <div class="collapse navbar-collapse text-center order-lg-2 order-4" id="navigation">
        <ul class="navbar-nav mx-auto mt-3 mt-lg-0">
          <li class="nav-item"> <a class="nav-link" href="/">Home</a>
          </li>
          <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="{{route ('all_jobs')}}" role="button" >
              Jobs
            </a>
          </li>
          <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="{{route ('all_articles')}}" role="button" >
              Articles
            </a>
          </li>
          <li class="nav-item"> <a class="nav-link" href="{{route ('contact')}}">Contact</a>
          </li>
          
          @if(auth()->check())
            <li class="nav-item" style="margin-left: 20%;"><a class="btn btn-primary" href="{{ route('home') }}">Dashboard</a></li>
          @else
          <li class="nav-item"> <a class="nav-link" class="btn btn-primary" href="{{route ('login')}}"style="display:none;">Login</a>
          </li>
          @endif
        </ul>
      </div>
    </nav>
  </div>
</header>

<main>
            @include('flash_msg')
            @yield('content')
</main>

<footer class="bg-dark mt-5">
  <div class="container section">
    <div class="row">
      <div class="col-lg-10 mx-auto text-center">
        <a class="d-inline-block mb-4 pb-2" href="/">
          <img loading="prelaod" decoding="async" class="img-fluid" src="{{asset ('assets2/images/logo.png')}}" alt="Reporter Hugo">
        </a>
        <?php 
            $pages=\App\Models\Page::whereType('Page')->get(); 
            $options=\App\Models\Option::all(); 
        ?>
        
        <ul class="p-0 d-flex navbar-footer mb-0 list-unstyled">
          @foreach ($pages as $page)
          <li class="nav-item my-0"> <a class="nav-link" href="{{route ('view_page',$page->slug)}}">{{$page->title}}</a></li>
          @endforeach
          {{-- <li class="nav-item my-0"> <a class="nav-link " href="#"><i class="fab fa-whatsapp" style="color: white;"></i></a></li> --}}
          <li class="nav-item my-0"> <a class="nav-link " href="{!! $options->where('option_key', 'twiter')->first()->option_value ??" "!!}"><i class="fab fa-twitter" style="color: white;"></i></a></li>
          <li class="nav-item my-0"> <a class="nav-link" href="{!! $options->where('option_key', 'facebook')->first()->option_value ??" "!!}"><i class="fab fa-facebook" style="color: white;"></i></a></li>
          <li class="nav-item my-0"> <a class="nav-link" href="{!! $options->where('option_key', 'linkedin')->first()->option_value ??" "!!}"><i class="fab fa-linkedin" style="color: white;"></i></a></li>
          <li class="nav-item my-0"> <a class="nav-link" href="{!! $options->where('option_key', 'instagram')->first()->option_value ??" "!!}"><i class="fab fa-instagram" style="color: white;"></i></a></li>

        </ul>
        
      </div>
    </div>
  </div>
  <div class="copyright bg-dark content">© Copyright 2023 Ikokazikenya.com</div>
</footer>


<!-- # JS Plugins -->
<script src="{{ asset('assets2/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{ asset('assets2/plugins/bootstrap/bootstrap.min.js')}}"></script>

<!-- Main Script -->
<script src="{{ asset('assets2/js/script.js')}}"></script>

</body>
</html>
