@extends('layouts.appbar')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>General Settings</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">General Settings</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">General Settings</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('save_settings') }}" method="POST" enctype="multipart/form-data"> 
                                    @csrf

                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <div class="form-group">
                                        <label for="site_name">Site Name</label>
                                        <input type="text" class="form-control" name="site_name" value="{{ optional($options->where('option_key', 'site_name')->first())->option_value }}" id="site_name" placeholder="Website name">
                                    </div>


                                      <?php

  $path = base_path();
  $path = $path.'/resources/views/theme';

  $dirs = array();

// directory handle
  $dir = dir($path);

  while (false !== ($entry = $dir->read())) {
    if ($entry != '.' && $entry != '..') {
     if (is_dir($path . '/' .$entry)) {
      $dirs[] = $entry; 
    }
  }
}



?>
<div class=" row mb-4">
 <label class="col-md-4 form-label">Select Theme</label>
 <div class="col-md-8">

   <select name="theme" class="form-control">
    <option value="{{ get_option('theme') }}" selected="">{{ get_option('theme') }}</option>
    @foreach ($dirs as $path => $value) 
    <option value="{{ $value }}">{{ $value }}</option>
    @endforeach


  </select>
</div>
</div>


                                    <div class="form-group" style="display: none;">
                                        <label for="trending_jobs">Trending Jobs Content</label>
                                        <input type="text" class="form-control" name="trending_jobs" value="{{ optional($options->where('option_key', 'trending_jobs')->first())->option_value }}" id="trending_jobs" placeholder="Enter the Home Page Content">
                                    </div>

                                    <div class="form-group" style="display: none;">
                                        <label for="kenya_jobs">Kenya No.1 Jobs Site</label>
                                        <input type="text" class="form-control" name="kenya_jobs" value="{{ optional($options->where('option_key', 'kenya_jobs')->first())->option_value }}" id="kenya_jobs" placeholder="Enter the Home Page Content">
                                    </div>

                                    <div class="form-group">
                                        <label for="contact_description">Contact Description Content</label>
                                        <input type="text" class="form-control" name="contact_description" value="{{ optional($options->where('option_key', 'contact_description')->first())->option_value }}" id="contact_description" placeholder="Enter Content">
                                    </div>

                                    <div class="form-group">
                                        <label for="contact_title">Contact Title</label>
                                        <input type="text" class="form-control" name="contact_title" value="{{ optional($options->where('option_key', 'contact_title')->first())->option_value }}" id="contact_title" placeholder="Enter Contact Title">
                                    </div>

                                    <div class="form-group">
                                        <label for="contact_phone">Contact Phone</label>
                                        <input type="text" class="form-control" name="contact_phone" value="{{ optional($options->where('option_key', 'contact_phone')->first())->option_value }}" id="contact_phone" placeholder="Enter Contact Phone">
                                    </div>

                                    <div class="form-group">
                                        <label for="top_notice">Top Bar Notice</label>
                                        <input type="text" class="form-control" name="top_notice" id="top_notice" value="{{ optional($options->where('option_key', 'top_notice')->first())->option_value }}" placeholder="e.g. We do shipping at a small fee">
                                        <small class="form-text text-muted">Short message shown in the header top bar. Leave blank to show the default shipping message.</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="currency_symbol">Currency Symbol</label>
                                        <input type="text" class="form-control" name="currency_symbol" id="currency_symbol" value="{{ optional($options->where('option_key', 'currency_symbol')->first())->option_value ?? 'KSh' }}" placeholder="e.g. KSh, $, EUR">
                                    </div>

                                    <div class="form-group">
                                        <label for="currency_code">Currency Code (ISO 4217)</label>
                                        <input type="text" class="form-control" name="currency_code" id="currency_code" value="{{ optional($options->where('option_key', 'currency_code')->first())->option_value ?? 'KES' }}" placeholder="e.g. KES, USD, EUR">
                                        <small class="form-text text-muted">Used for structured data and payment metadata. Example: KES.</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="free_shipping_threshold">Free Shipping Threshold</label>
                                        <input type="number" min="0" step="1" class="form-control" name="free_shipping_threshold" id="free_shipping_threshold" value="{{ optional($options->where('option_key', 'free_shipping_threshold')->first())->option_value ?? 10000 }}" placeholder="Amount without currency symbol">
                                        <small class="form-text text-muted">Shown in the top bar notice (e.g., Free delivery for orders over {{ optional($options->where('option_key', 'currency_symbol')->first())->option_value ?? 'KSh' }} {{ number_format(optional($options->where('option_key', 'free_shipping_threshold')->first())->option_value ?? 10000, 0) }}).</small>
                                    </div>


                                     <div class="form-group">
                                        <label for="whatsapp_phone">WhatsApp Number</label>
                                        <input type="text" class="form-control" name="whatsapp_phone" value="{{ optional($options->where('option_key', 'whatsapp_phone')->first())->option_value }}" id="whatsapp_phone" placeholder="Enter whatsapp phone">
                                    </div>



                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control" name="address" value="{{ optional($options->where('option_key', 'address')->first())->option_value }}" id="address" placeholder="Enter address">
                                    </div>



                                    <div class="form-group">
                                        <label for="contact_email">Email</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            </div>
                                            <input type="email" class="form-control" name="contact_email" value="{{ optional($options->where('option_key', 'contact_email')->first())->option_value }}" placeholder="Email">
                                        </div>
                                    </div>



                                        <div class="form-group">
                                        <label for="twitter">Embend map</label>

                                        <textarea class="form-control" name="map">{{ optional($options->where('option_key', 'map')->first())->option_value }}</textarea>
                                    </div>


                                    <div class="form-group">
                                        <label for="twitter">Chat script</label>

                                        <textarea class="form-control" name="chat">{{ optional($options->where('option_key', 'chat')->first())->option_value }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="twitter">Twitter</label>
                                        <input type="text" class="form-control" name="twitter" value="{{ optional($options->where('option_key', 'twitter')->first())->option_value }}" id="twitter" placeholder="Enter Twitter Link">
                                    </div>

                                    <div class="form-group">
                                        <label for="facebook">Facebook</label>
                                        <input type="text" class="form-control" name="facebook" value="{{ optional($options->where('option_key', 'facebook')->first())->option_value }}" id="facebook" placeholder="Enter Facebook Link">
                                    </div>

                                    <div class="form-group">
                                        <label for="linkedin">LinkedIn</label>
                                        <input type="text" class="form-control" name="linkedin" value="{{ optional($options->where('option_key', 'linkedin')->first())->option_value }}" id="linkedin" placeholder="Enter LinkedIn Link">
                                    </div>

                                    <div class="form-group">
                                        <label for="instagram">Instagram</label>
                                        <input type="text" class="form-control" name="instagram" value="{{ optional($options->where('option_key', 'instagram')->first())->option_value }}" id="instagram" placeholder="Enter Instagram Link">
                                    </div>


                                    <div class="form-group">
                                        <label for="twitter">Twiter(X)</label>
                                        <input type="text" class="form-control" name="twitter" value="{{ optional($options->where('option_key', 'twitter')->first())->option_value }}" id="twitter" placeholder="Enter twitter Link">
                                    </div>

                                    <div class="form-group">
  <label for="tiktok">TikTok</label>
  <input
    type="text"
    class="form-control"
    name="tiktok"
    id="tiktok"
    value="{{ optional($options->where('option_key', 'tiktok')->first())->option_value }}"
    placeholder="Enter TikTok Link"
  >
</div>


                                    <div class="form-group">
                                        <label for="photo">Upload favicon</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="photo" name="photo">
                                                <label class="custom-file-label" for="photo">Choose file</label>
                                            </div>
                                        </div>
                                    </div>


                                           <div class="form-group">
                                        <label for="photo">Upload logo</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="logo" name="logo">
                                                <label class="custom-file-label" for="logo">Choose file</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Save Settings</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
