@extends('master')
@section('title', '| Sale')
@section('admin')

    <div class="row mt-0">

        <div class="col-lg-12 grid-margin stretch-card mb-3">
            <div class="card">

                <div class="card-body px-4 py-2">
                    <form id="myValidForm" class="myForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="0" class="makeItemId">
                        <input type="hidden" name="total_cost_price" value="0">
                    <div class="row" >
                        <div class="mb-1 col-md-4">
                            @php
                                $categories = App\Models\ItemCategory::all();
                            @endphp
                            <div  class="row">
                                <div class="col-md-10 form-valid-groups">
                                    <label for="ageSelect" class="form-label">Category</label>
                                    <select class="js-example-basic-single  form-select category_select @error('make_category_id') is-invalid @enderror" data-width="100%" name="make_category_id"
                                        onclick="errorRemove(this);" onblur="errorRemove(this);">
                                        @if ($categories->count() > 0)
                                            <option selected disabled>Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" >{{ $category->category_name }} </option>
                                            @endforeach
                                        @else
                                            <option selected disabled>Please Select Category</option>
                                        @endif
                                    </select>
                                    @error('make_category_id')
                                    <div class="text-danger">{{ $message }}</div>
                                   @enderror
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
                        <div class="mb-2 col-md-6">
                            <h6 class="card-title">Product Image</h6>
                            <input type="file" class="categoryImage" name="picture" id="myDropify" />
                        </div>
                        <div class="mb-2 col-md-6">
                            <label for="" class="form-label">Item Note</label>
                            <textarea class="form-control" value="{{ old('note') }}" name="note" id="" rows="9"></textarea>
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
                            <select class="js-example-basic-single  form-select product_select @error('product_id') is-invalid @enderror" name="product_id" data-width="100%"
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
                            @error('product_id')
                            <div class="text-danger">{{ $message }}</div>
                          @enderror
                            {{-- <span class="text-danger product_select_error"></span> --}}
                        </div>
                        <div class="mb-2 col-md-3 form-valid-groups">
                            <label for="ageSelect" class="form-label">Quantity</label>
                            <div class="">
                                <input type="number" id="quantity" class="form-control @error('quantity') is-invalid @enderror" name="quantity" placeholder="Quantity"
                                     aria-describedby="btnGroupAddon" oninput="updateCost();">
                            </div>
                            @error('quantity')
                            <div class="text-danger">{{ $message }}</div>
                          @enderror
                        </div>
                        <div class="mb-1 col-md-3 form-valid-groups">
                            <label for="password" class="form-label">Unit</label>
                            @php
                            $units = App\Models\Unit::all();
                            @endphp
                        <label for="ageSelect" class="form-label">Materials Name</label>
                        <select class="js-example-basic-single form-select @error('unit') is-invalid @enderror" name="unit" data-width="100%"
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
                        @error('unit')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
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
   {{-- /////////////////Category Add Modal//////////////// --}}
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
        product_id: {
            required: true,
        },
        quantity: {
            required: true,
        },
        unit: {
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
        product_id: {
            required: 'Select Materials Name Required',
        },
        quantity: {
            required: 'Select Materials Name Required',
        },
        unit: {
            required: 'Please Select a Unit',
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
    $('.myForm').submit(function(event) {
        event.preventDefault(); // Prevent the default form submission

        var formData = new FormData(this); // Create a FormData object to send form data including files

        // Send an Ajax request
        $.ajax({
            type: 'POST',
            url: '/store/make/item',
            data: formData,
            processData: false, // Prevent jQuery from automatically processing the form data
            contentType: false, // Prevent jQuery from automatically setting the Content-Type header
            success: function(response) {
                var productName = response.material.product.name;
                var productPrice = response.material.product.price;
                var unitName = response.material.unit.name;
                var newRow = '<tr data-id="' + response.material.id + '">' +
                             '<td>' + productName + '</td>' +
                             '<td>' + productPrice + '</td>' +
                             '<td>' + response.material.quantity + '</td>' +
                             '<td>' + unitName + '</td>' +
                             '<td class="apro-cost">' + response.material.apro_cost + '</td>' +
                             '<td><a type="button" class="btn btn-sm text-danger deleteRow"><i class="fas fa-trash-alt"></i></a></td>' +
                             '</tr>';
                $('.showData').append(newRow); // Append the new row to the table body
                 calculateTotalCost();
                if (response.status === 200) {
                   document.querySelector('.makeItemId').value = response.makeItemId;
                    toastr.success(response.message);
                } else {
                    toastr.error('Failed to Create.');
                }

            },

            error: function(xhr, status, error) {
                // Handle errors
                console.error(xhr.responseText);
            }
        });
    });
// last calculate Grand Total Function
    function calculateTotalCost() {
        var totalCost = 0;
        $('.apro-cost').each(function() {
            totalCost += parseFloat($(this).text());
        });
        $('#totalCost').text(totalCost.toFixed(2)); // Update the total cost display
        // $('input[name="total_cost_price"]').val(totalCost);
    }

///Delete
$(document).on('click', '.deleteRow', function() {
        var row = $(this).closest('tr');
        var id = row.data('id');
        $.ajax({
            type: 'GET',
            url: '/delete/material/' + id,
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.status === 200) {
                    row.remove(); // Remove the row from the table
                    calculateTotalCost();
                    toastr.success(response.message);
                } else {
                    toastr.error('Failed to delete the item.');
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                toastr.error('Failed to delete the item.');
            }
        });
    });
});

//
        //Category add
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
    ///Item Cost // Show realtime update total cot
        function updateCost() {
        const productSelect = document.querySelector('.product_select');
        const quantityInput = document.getElementById('quantity');
        $('.product_select').change(function() {
        $('#quantity').val('');
          });
        const itemCostInput = document.getElementById('itemCost');

        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
        const quantity = parseFloat(quantityInput.value) || 0;
        const totalCost = price * quantity;
        itemCostInput.value = totalCost.toFixed(2);

    }
    </script>


@endsection
