@extends('master')
@section('title', '| Set Items')
@section('admin')

    <div class="row mt-0">

        <div class="col-lg-12 grid-margin stretch-card mb-3">
            <div class="card">

                <div class="card-body px-4 py-2">
                    <form id="myValidForm" class="myForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" class="makeItemId" value="0">
                        <input type="hidden" name="total_cost_price" value="0">
                    <div class="row" >
                        <div class="mb-1 col-md-4">
                            @php
                                $categories = App\Models\SetCategory::all();
                            @endphp
                            <div  class="row">
                                <div class="col-md-10 form-valid-groups">
                                    <label for="ageSelect" class="form-label">Category name</label>
                                    <select class="js-example-basic-single form-select category_select" data-width="100%" name="make_category_id"
                                       >
                                        @if ($categories->count() > 0)
                                            <option selected disabled>Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" >{{ $category->name }} </option>
                                            @endforeach
                                        @else
                                            <option selected disabled>Please Select Category</option>
                                        @endif
                                    </select>
                                    <span class="text-danger product_select_error"></span>
                                </div>
                                <div class="col-md-2"  style="margin-top: 10px">
                                    <label for="ageSelect" class="form-label"> </label><br>
                                    <a href="" class="btn btn-sm btn-info"  data-bs-toggle="modal"
                                    data-bs-target="#exampleModalLongScollable">+</a>
                                </div>
                            </div>
                        </div>
                        <div class="mb-2 col-md-4 form-valid-groups">
                            <label for="ageSelect" class="form-label">Item Name</label>
                            <div class="">
                                <input type="text" name="item_name" value="{{ old('item_name') }}" class="form-control barcode_input" placeholder="Item Name"
                                     aria-describedby="btnGroupAddon">
                            </div>
                        </div>
                        <div class="mb-2 col-md-4 form-valid-groups">
                            <label for="ageSelect" class="form-label">Item Price</label>
                            <div class="">
                                <input type="number" name="sale_price" value="{{ old('sale_price') }}" class="form-control barcode_input" placeholder="Item Price"
                                     aria-describedby="btnGroupAddon">
                            </div>
                        </div>
                    </div>
                    {{-- <button type="submit" class="btn btn-primary ms-2"
                    >Add</button> --}}
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12 mb-1 grid-margin stretch-card">
            <div class="card">
                <div class="card-body px-4 py-2">
                    <div class="row">
                        <div class="mb-1 col-md-3 form-valid-groups">
                            @php
                                $products = App\Models\Product::where('stock', '>', 0)->get();
                            @endphp
                            <label for="ageSelect" class="form-label">Materials Name</label>
                            <select class="js-example-basic-single  form-select product_select" name="product_id" id ="productValid" data-width="100%"
                                onclick="errorRemove(this);" onblur="errorRemove(this);"  onchange="updateCost();">
                                @if ($products->count() > 0)
                                    <option selected disabled>Select Product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}"">{{ $product->name }} ({{ $product->stock }}
                                            {{ $product->unit->name }} Available )
                                        </option>
                                    @endforeach
                                @else
                                    <option selected disabled>Please Add Product</option>
                                @endif
                            </select>

                            <div id="productError" class="text-danger"></div>
                        </div>
                        <div class="mb-2 col-md-3 form-valid-groups">
                            <label for="ageSelect" class="form-label">Quantity</label>
                            <div class="">
                                <input type="number" id="quantity" class="form-control" name="quantity" placeholder="Quantity"
                                     aria-describedby="btnGroupAddon" oninput="updateCost();">
                                     {{--  min="1" if i use then call it --}}
                            </div>
                            <div id="quantityError" class="text-danger"></div>
                        </div>
                        <div class="mb-1 col-md-3 form-valid-groups">
                            <label for="password" class="form-label">Unit</label>
                            @php
                            $units = App\Models\unit::all();
                            @endphp
                        <label for="ageSelect" class="form-label">Materials Name</label>
                        <select class="js-example-basic-single form-select" id="unit" name="unit" data-width="100%"
                            onclick="errorRemove(this);" onblur="errorRemove(this);">
                            @if ($units->count() > 0)
                                <option selected disabled>Select Unit</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->name }} </option>                                </option>
                                @endforeach
                            @else
                                <option selected disabled>Please Add Unit</option>
                            @endif
                        </select>
                        <div id="unitError" class="text-danger"></div>
                        <span class="text-danger product_select_error"></span>
                        </div>
                        <div class="mb-1 col-md-3">
                            <label for="password" class="form-label">Total Cost</label>
                            <div class="d-flex g-3">
                                <input type="text" class="form-control barcode_input" id="itemCost" placeholder="Item Cost" name="apro_cost"
                                     aria-describedby="btnGroupAddon" readonly>
                                <button type="submit" class="btn btn-primary ms-2"
                                   >Add</button>
                            </div>
                        </div>
                    </div>
                </form>
                 {{-- //last --}}
                </div>
            </div>
        </div>

    </div>
   {{-- /////////////////Set Category Add Modal//////////////// --}}
<div class="modal fade" id="exampleModalLongScollable" tabindex="-1"
   aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title" id="exampleModalScrollableTitle">Add Set Category</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal"
                   aria-label="btn-close"></button>
           </div>
           <div class="modal-body">
               <form id="signupForm" class="categoryForm">
                  <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Category Name</label>
                            <input id="defaultconfig" class="form-control category_name"
                                maxlength="250" name="category_name" type="text">
                            <span class="text-danger category_name_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Discount Amount</label>
                            <input id="defaultconfig" class="form-control discount_amount"
                                maxlength="250" name="category_name" type="text">
                            <span class="text-danger category_name_error"></span>
                        </div>
                    </div>

                  </div>
                  <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Category Image</label>
                            <input type="file" class="categoryImage" name="picture" id="myDropify" />
                            <span class="text-danger category_name_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Note</label>
                           <textarea name="note" class="form-control" id="" cols="30" rows="9"></textarea>
                            <span class="text-danger category_name_error"></span>
                        </div>
                    </div>

                  </div>
           </div>
           <div class="modal-footer">
               <button type="button" class="btn btn-secondary"
                   data-bs-dismiss="modal">Close</button>
               <button type="button" class="btn btn-primary save_set_category
               ">Save</button>
           </div>
           </form>
       </div>
   </div>
</div>
<style>
    .modal.fade .modal-dialog {
        transition: transform 0.0s ease-out; /* Adjust duration (e.g., 0.2s for 200ms) */
    }
    .modal.fade.show .modal-dialog {
        transform: translateY(0);
    }
</style>
<!--------Category Modal-------->
    {{-- table  --}}
    <div class="row">
        <div class="col-md-12 mb-1 grid-margin stretch-card">
            <div class="card">
                <div class="card-body px-4 py-2">
                    <div class="mb-3">
                        <h6 class="card-title">Items</h6>
                    </div>

                    <div id="" class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Product Price</th>
                                    <th>Qty</th>
                                    <th>Unit</th>
                                    <th>Total Cost</th>
                                    <th>
                                        <i class="fa-solid fa-trash-can"></i>
                                    </th>
                                </tr>

                            </thead>
                            <tbody class="showData">
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3"></th>
                                    <th >Grand Total</th>
                                    <th id="totalCost">0.00</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

$(document).ready(function() {

$('#myValidForm').validate({
    rules: {

        item_name: {
            required: true,
        },
        sale_price: {
            required: true,
        },
        make_category_id: {
            required: true,
        },

    },
    messages: {

        item_name: {
            required: 'Item Name Required ',
        },
        sale_price: {
            required: 'Item price Required',
        },
        make_category_id: {
            required: 'Select Category Field Required',
        },

    },
    errorElement: 'span',
    errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-valid-groups').append(error);
    },
    highlight: function(element, errorClass, validClass) {
        $(element).addClass('is-invalid');
    },
    unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        $(element).addClass('is-valid');
    },
});
});
//form insert
$(document).ready(function() {
        //Category add
        const saveCategory = document.querySelector('.save_set_category');
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
                    url: '/set/item/catgoey',
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
                            const newOption = new Option(res.data.category_name, res.data.id);
                            document.querySelector('.category_select').append(newOption);
                            // Optionally refresh select2 if used
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
