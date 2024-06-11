@extends('master')
@section('title','|Set  Item List')
@section('admin')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card d-flex justify-content-end">
            <div class="">
                <h4 class="text-right"><a href="" class="btn btn-sm btn-info"  data-bs-toggle="modal"
                    data-bs-target="#exampleModalLongScollable11">+</a></h4>
            </div>
        </div>
        <div class="col-md-12 grid-margin stretch-card">

            <div class="card">
                <div class="card-body">
                    <h6 class="card-title text-info">View All Set Item </h6>
                    <div id="" class="table-responsive">
                        <table id="example" class="table">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Menu Name</th>
                                    <th>Barcode</th>
                                    <th>Cost Price</th>
                                    <th>Sale Price</th>
                                    <th>Discount</th>
                                    <th>Image</th>
                                    <th>Note</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="showData">
                                @if ($setMenu->count() > 0)
                                    @foreach ($setMenu as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                           {{$item->menu_name}}
                                            <td>
                                                {{$item->barcode}}
                                            </td>
                                            <td>
                                                {{$item->cost_price}}
                                            </td>
                                            <td> {{$item->sale_price}}</td>
                                            <td> {{$item->discount ?? '0'}}</td>
                                            <td>@if($item->image)
                                                <img src="{{ asset('uploads/menu_Items/'.$item->image) }}" alt="Image">
                                                @else
                                               <span>-</span>
                                                @endif
                                            </td>
                                           <td>
                                            @if($item->note)
                                            @php
                                                $noteChunks = str_split($item->note, 40);
                                            @endphp

                                            @foreach($noteChunks as $chunk)
                                                {{ $chunk }} <br>
                                            @endforeach
                                            @else
                                                -
                                            @endif
                                           </td>

                                            <td>
                                                <a class="btn btn-sm border text-warning" data-bs-toggle="modal"
                                                data-bs-target="#exampleModalLongScollable{{$item->id}}">

                                                    <i class="fas fa-edit"></i></a>

                                                <a class="btn btn-sm border delete-btn text-danger" href="{{route('set.menu.delete',$item->id)}}"><i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                          {{-- /////////////////Edit Set Menu  //////////////// --}}
       <div class="modal fade" id="exampleModalLongScollable{{$item->id}}" tabindex="-1"
       aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
       <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalScrollableTitle">Add Set Menu</h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal"
                       aria-label="btn-close"></button>
               </div>
               <div class="modal-body">
                   <form id="myFormIdUpdate" method="POST" action="{{route('update.menu.store',$item->id)}}" enctype="multipart/form-data">
                    @csrf
                    {{-- @csrf --}}
                      <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="menu_name" class="form-label">Menu Name</label>
                                <input id="menu_name" value="{{$item->menu_name}}" class="form-control menu_name"
                                    maxlength="250" name="menu_name" type="text">
                                <span class="text-danger menu_name_error"></span>
                            </div>
                        </div>


                      </div>
                      <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="Cost" class="form-label">Cost Price</label>
                                <input id="Cost" class="form-control cost_price"
                                     name="cost_price" value="{{$item->cost_price}}" type="number">
                                <span class="text-danger cost_price_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sale_price" class="form-label"  >Sale Price</label>
                                <input id="defaultconfig12" value="{{$item->sale_price}}" class="form-control sale_price"
                                     name="sale_price" type="number">
                                <span class="text-danger sale_price_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="discount" class="form-label"  >Discount Type</label>
                                <select class="form-control" name="discount_type" value="{{$item->discount_type}}" data-width="100%">
                            <option selected disabled>Select Discount Type</option>
                                <option value="percentage">Percentage</option>
                                    <option value="solid">Amount</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Discount Amount</label>
                                <input id="defaultconfigDiscount"  value="{{$item->discount}}" class="form-control discount"
                                    maxlength="250" name="discount" type="number">
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Menu Image</label>
                                <input type="file" class="image" id="myDropify" data-default-file="{{ $item->image ? asset('uploads/menu_Items/' . $item->image) : '' }}" name="images" />
                                @if($item->image)
                                    <img src="{{ asset('uploads/menu_Items/' . $item->image) }}" alt="Default Image" height="120" width="150" />
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Note</label>
                               <textarea name="note" class="form-control" cols="30" rows="9">{{$item->note}}</textarea>

                            </div>
                        </div>
                      </div>
               </div>
               <div class="modal-footer">
                   <button type="button" class="btn btn-secondary"
                       data-bs-dismiss="modal">Close</button>
                   <button type="submit" class="btn btn-primary update_set_menu">Update</button>
               </div>
               </form>
           </div>
       </div>
       </div>
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
       {{-- /////////////////Set Menu Add Modal//////////////// --}}
<div class="modal fade" id="exampleModalLongScollable11" tabindex="-1"
aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalScrollableTitle">Add Set Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"
                aria-label="btn-close"></button>
        </div>
        <div class="modal-body">
            <form id="myFormId" enctype="multipart/form-data">
             {{-- @csrf --}}
               <div class="row">
                 <div class="col-md-12">
                     <div class="mb-3">
                         <label for="menu_name" class="form-label">Menu Name</label>
                         <input id="menu_name" class="form-control menu_name"
                             maxlength="250" name="menu_name" type="text">
                         <span class="text-danger menu_name_error"></span>
                     </div>
                 </div>


               </div>
               <div class="row">
                 <div class="col-md-6">
                     <div class="mb-3">
                         <label for="Cost" class="form-label">Cost Price</label>
                         <input id="Cost" class="form-control cost_price"
                              name="cost_price" type="number">
                         <span class="text-danger cost_price_error"></span>
                     </div>
                 </div>
                 <div class="col-md-6">
                     <div class="mb-3">
                         <label for="sale_price" class="form-label">Sale Price</label>
                         <input id="defaultconfig12" class="form-control sale_price"
                              name="sale_price" type="number">
                         <span class="text-danger sale_price_error"></span>
                     </div>
                 </div>
                 <div class="col-md-6">
                     <div class="mb-3">
                         <label for="discount" class="form-label">Discount Type</label>
                         <select class="form-control" name="discount_type" data-width="100%">
                     <option selected disabled>Select Discount Type</option>
                     <option value="percentage">Percentage</option>
                             <option value="solid">Amount</option>
                         </select>

                     </div>
                 </div>
                 <div class="col-md-6">
                     <div class="mb-3">
                         <label for="name" class="form-label">Discount Amount</label>
                         <input id="defaultconfigDiscount" class="form-control discount"
                             maxlength="250" name="discount" type="number">

                     </div>
                 </div>
               </div>
               <div class="row">
                 <div class="col-md-6">
                     <div class="mb-3">
                         <label for="name" class="form-label">Menu Image</label>
                         <input type="file" class="image" name="image" id="myDropify" />

                     </div>
                 </div>
                 <div class="col-md-6">
                     <div class="mb-3">
                         <label for="name" class="form-label">Note</label>
                        <textarea name="note" class="form-control" cols="30" rows="9"></textarea>

                     </div>
                 </div>

               </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary"
                data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary save_set_menu">Save</button>
        </div>
        </form>
    </div>
</div>
</div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const saveMenu = document.querySelector('.save_set_menu');

    saveMenu.addEventListener('click', function(e) {
        e.preventDefault();
        $('.text-danger').text('');

        // Client-side validation
        let isValid = true;
        const menuName = document.getElementById('menu_name').value.trim();
        const costPrice = document.getElementById('Cost').value.trim();
        const salePrice = document.getElementById('defaultconfig12').value.trim();

        if (!menuName) {
            $('.menu_name_error').text('Menu Name is required.');
            isValid = false;
        }

        if (!costPrice) {
            $('.cost_price_error').text('Cost Price is required.');
            isValid = false;
        }

        if (!salePrice) {
            $('.sale_price_error').text('Sale Price is required.');
            isValid = false;
        }

        if (!isValid) {
            toastr.error('Please fill in all required fields.');
            return;
        }

        let formElement = document.getElementById('myFormId');
        if (!formElement || !(formElement instanceof HTMLFormElement)) {
            console.error('Form element not found or not of type HTMLFormElement');
            return;
        }

        let formData = new FormData(formElement);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "/set/menu/store",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status == 200) {
                    $('#exampleModalLongScollable11').modal('hide');
                    $('#myFormId')[0].reset();
                    window.location.reload();
                    toastr.success(response.message);
                    const newOption = new Option(response.data.menuItem.menu_name, response.data.menuItem.id);
                    document.querySelector('.menu_select').append(newOption);
                    // Optionally refresh select2 if used
                    $('.js-example-basic-single').select2();
                } else {
                    toastr.error(response.message || 'Validation Required');
                }
            },
            error: function(response) {
                if (response.status === 422) {
                    const errors = response.responseJSON.errors;
                    Object.keys(errors).forEach(function(key) {
                        $('.' + key + '_error').text(errors[key][0]);
                    });
                    toastr.error('Please correct the errors and try again.');
                } else {
                    toastr.error('An error occurred. Please try again.');
                }
            }
        });
    });

    $('#exampleModalLongScollable11').on('hidden.bs.modal', function() {
        $('#myFormId')[0].reset();
        $('.text-danger').text('');
    });
});//
// document.addEventListener('DOMContentLoaded', function() {
//     const updateButtons = document.querySelectorAll('.update_set_menu');

//     updateButtons.forEach(function(button) {
//         button.addEventListener('click', function(e) {
//             e.preventDefault();
//             $('.text-danger').text('');

//             // Client-side validation
//             let isValid = true;
//             const menuName = document.getElementById('menu_name').value.trim();
//             const costPrice = document.getElementById('Cost').value.trim();
//             const salePrice = document.getElementById('defaultconfig12').value.trim();

//             if (!menuName) {
//                 $('.menu_name_error').text('Menu Name is required.');
//                 isValid = false;
//             }

//             if (!costPrice) {
//                 $('.cost_price_error').text('Cost Price is required.');
//                 isValid = false;
//             }

//             if (!salePrice) {
//                 $('.sale_price_error').text('Sale Price is required.');
//                 isValid = false;
//             }

//             if (!isValid) {
//                 toastr.error('Please fill in all required fields.');
//                 return;
//             }

//             // Get the parent form element of the button clicked
//             const formElement = document.getElementById('myFormIdUpdate{{$item->id}}');

//             // Check if formElement is null (not found)
//             if (!formElement) {
//                 console.error('Form element not found for button:', button);
//                 toastr.error('An error occurred. Please try again.');
//                 return;
//             }

//             const formData = new FormData(formElement);

//             $.ajaxSetup({
//                 headers: {
//                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                 }
//             });

//             const itemId = formElement.dataset.itemId;

//             $.ajax({
//                 url: "/update/menu/store/" + itemId,
//                 method: "POST",
//                 data: formData,
//                 contentType: false,
//                 processData: false,
//                 success: function(response) {
//                     if (response.status == 200) {
//                         $('#exampleModalLongScollable' + itemId).modal('hide');
//                         formElement.reset();
//                         window.location.reload();
//                         toastr.success(response.message);
//                         const newOption = new Option(response.data.menuItem.menu_name, response.data.menuItem.id);
//                         document.querySelector('.menu_select').append(newOption);
//                         // Optionally refresh select2 if used
//                         $('.js-example-basic-single').select2();
//                     } else {
//                         toastr.error(response.message || 'Validation Required');
//                     }
//                 },
//                 error: function(xhr, textStatus, errorThrown) {
//                     if (xhr.status === 422) {
//                         const errors = xhr.responseJSON.errors;
//                         Object.keys(errors).forEach(function(key) {
//                             $('.' + key + '_error').text(errors[key][0]);
//                         });
//                         toastr.error('Please correct the errors and try again.');
//                     } else {
//                         toastr.error('An error occurred. Please try again.');
//                     }
//                 }
//             });
//         });
//     });

//     $('#exampleModalLongScollable').on('hidden.bs.modal', function() {
//         $('#myFormId')[0].reset();
//         $('.text-danger').text('');
//     });
// });

    </script>
@endsection
