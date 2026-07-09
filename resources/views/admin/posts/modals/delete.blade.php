             {{-- //Edit Modal --}}
              <div class="modal fade" id="delete-page{{$page->id}}">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Delete</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('delete-page',$page->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('DELETE')
                            <div class="card-body">
                              <p>Are you sure you want to delete this page</p>
                            </div>
                            <!-- /.card-body -->
            
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Delete</button>
                            </div>
                        </form>
                    </div>
                    
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              <!-- /.modal -->