@extends('master')
@section('title','| Item Category List')
@section('admin')

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card d-flex justify-content-end">
            <div class="">
                <h4 class="text-right"><a href="" class="btn btn-sm btn-info"  data-bs-toggle="modal"
                    data-bs-target="#exampleModalLongScollable">+</a></h4>
            </div>
        </div>
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title text-info">View Item List</h6>
                    <div  class="table-responsive">
                        <table id="example" class="table">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Item Category Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="showData">
                                @if ($allCat->count() > 0)
                                    @foreach ($allCat as $key => $itemCat)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>

                                            <td>{{ $itemCat->category_name ?? '-' }}</td>
                                            <td>
                                                <a class="btn btn-sm border text-warning" href="{{route('make.item.category.edit',$itemCat->id)}}"><i class="fas fa-edit"></i></a>

                                                <a class="btn btn-sm border delete-btn text-danger" href="{{route('make.item.category.delete',$itemCat->id)}}"><i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="12">
                                            <div class="text-center text-warning mb-2">Data Not Found</div>
                                        </td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModalLongScollable" tabindex="-1"
   aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title" id="exampleModalScrollableTitle">Add  Category</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal"
                   aria-label="btn-close"></button>
           </div>
           <div class="modal-body">
               <form id="signupForm" class="categoryForm">
                   <div class="mb-3">
                       <label for="name" class="form-label">Category Name</label>
                       <input id="defaultconfig" class="form-control category_name"
                           maxlength="250" name="category_name" type="text"
                           onkeyup="errorRemove(this);" onblur="errorRemove(this);">
                       <span class="text-danger category_name_error"></span>
                   </div>
           </div>
           <div class="modal-footer">
               <button type="button" class="btn btn-secondary"
                   data-bs-dismiss="modal">Close</button>
               <button type="button" class="btn btn-primary save_category">Save</button>
           </div>
           </form>
       </div>
   </div>
</div>


<script>
$(document).ready(function() {
     const saveCategory = document.querySelector('.save_category');
        saveCategory.addEventListener('click', function(e) {
                e.preventDefault();
                // alert('ok')
                let formData = new FormData($('.categoryForm')[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/add/make/item/catgoey',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.status == 200) {
                            // console.log(res);
                            $('#exampleModalLongScollable').modal('hide');
                            $('.categoryForm')[0].reset();
                            toastr.success(res.message);
                            window.location.reload();
                            $('.js-example-basic-single').select2();
                        } else {
                            // console.log(res);
                            console.log('Validation errors:', res.error);
                            toastr.error(res.error,'Category Unique Name Required');
                            if (res.error.category_name) {
                                showError('.category_name_error', res.error.category_name);
                            }
                        }
                    }
                });
            })
            });
</script>
@endsection
