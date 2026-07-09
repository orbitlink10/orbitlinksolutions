@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                 <form method="POST" action="{{ url('save_post') }}">
                    @csrf

                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end">Title</label>

                        <div class="col-md-6">
                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>

                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">Description</label>

                        <div class="col-md-6">
                        <textarea class="form-control" name="description"></textarea>
                            <script>
                                ClassicEditor
                                .create( document.querySelector( '#editor' ) )
                                .catch( error => {
                                  console.error( error );
                              } );
                          </script>


                      </div>
                  </div>

                  <div class="row mb-3">
                    <label for="tags" class="col-md-4 col-form-label text-md-end">Tags</label>

                    <?php 
                    $tags = \App\Models\Tag::all();
                    ?>   

                    <div class="col-md-6">

                       @foreach($tags as $category)




                       <label> <input type="checkbox" value="{{ $category->id }}" name="tags[{{$category->id}}]"> {{ $category->name }} </label><br>




                       @endforeach

                   </div>
               </div>



               <div class="row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                     Save post
                 </button>
             </div>
         </div>
     </form>
 </div>
</div>


      <div class="card">
                <div class="card-header">Posts list</div>

                <div class="card-body">

                         @foreach($posts as $post)
     <h4><a target="_blank" href="{{ route('blog_single', $post->id)}}"  class="h4 text-dark">{{ $post->title}}</a></h4>  


    <p style="color: green;"><a href="{{ url('edit_post', $post->id) }}"> Edit</a></p>

    <hr>



    @endforeach


    <div class="d-flex justify-content-center">
        {!! $posts->links() !!}
    </div>

 
 </div>
</div>

</div>
<div class="col-md-4">
   <div class="card">
     <div class="card-header">
       <h4 class="card-title">Add New Tag</h4>
   </div>
   <div class="card-body">
       <form class="form-horizontal" action="{{ url('save_tag')}}" method="POST">
         @csrf
         <div class=" row mb-4">
           <label class="col-md-3 form-label">Name</label>
           <div class="col-md-9">
             <input type="text" class="form-control" name="name" placeholder="Typing tag name.....">
         </div>
     </div>




     <div class=" row mb-4">

       <div class="col-md-9">
          <input type="submit" value="Save" class="btn btn-primary">
      </div>


  </div>



</form>
</div>
</div>
</div>
</div>
</div>
@endsection
