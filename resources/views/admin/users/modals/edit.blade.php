        {{-- //Edit Modal --}}
                                                <div class="modal fade" id="edit-user{{ $user->id }}">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Edit User</h4>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('admin.update_user',$user->id) }}" method="POST"
                                                                enctype="multipart/form-data">@csrf
                                                                    <div class="row mb-3">
                                                                        <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                                            
                                                                        <div class="col-md-6">
                                                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>
                                            
                                                                            @error('name')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                            
                                                                    <div class="row mb-3">
                                                                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                                            
                                                                        <div class="col-md-6">
                                                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">
                                            
                                                                            @error('email')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                                            
                                                                        <div class="col-md-6">
                                                                            <select name="user_type" class="form-control">
                                                                                <option value="{{$user->user_type}}">{{$user->user_type ?? "Not Selected"}}</option>
                                                                                <option value="editor">Editor</option>
                                                                                <option value="admin">Admin</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                
                                                                <div class="modal-footer justify-content-between">
                                                                    <button type="button" class="btn btn-danger"
                                                                        data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                                </div>
                                                            </form>
                                                            </div>

                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                                <!-- /.modal -->