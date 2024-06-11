@extends('master')
@section('title', '| Make Item Edit')
@section('admin')

    <div class="row mt-0">

        <div class="col-lg-12 grid-margin stretch-card mb-3">
            <div class="card">

                <div class="card-body px-4 py-2">
                    <form id="myValidForm" class="myForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" class="makeItemId" value="{{$itemEditId->id ?? 0}}">
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
                                                <option value="{{ $category->id }}" {{ $itemEditId->make_category_id == $category->id ? 'selected' : '' }} >{{ $category->category_name }} </option>
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
                                <input type="text" name="item_name"  class="form-control barcode_input" value="{{$itemEditId->item_name}}" placeholder="Item Name"
                                     aria-describedby="btnGroupAddon">
                            </div>
                        </div>
                        <div class="mb-2 col-md-4 form-valid-groups">
                            <label for="ageSelect" class="form-label">Item Price</label>
                            <div class="">
                                <input type="number" name="sale_price" value="{{$itemEditId->sale_price}}" class="form-control barcode_input" placeholder="Item Price"
                                     aria-describedby="btnGroupAddon">
                            </div>
                        </div>
                        <div class="mb-2 col-md-6">
                            <h6 class="card-title">Product Image</h6>
                            <input type="file" class="categoryImage" name="picture" id="myDropify" data-default-file="{{ $itemEditId->picture ? asset($itemEditId->picture) : '' }}" />
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
                            <select class="js-example-basic-single  form-select product_select" name="product_id" id ="productValid" data-width="100%"
                                onclick="errorRemove(this);" onblur="errorRemove(this);"  onchange="updateCost();">
                                @if ($products->count() > 0)
                                    <option selected disabled>Select Product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }} ({{ $product->stock }}
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
                            </div>
                            <div id="quantityError" class="text-danger"></div>
                        </div>
                        <div class="mb-1 col-md-3 ">
                            <label for="password" class="form-label">Unit</label>
                            @php
                            $units = App\Models\unit::all();
                            @endphp
                        <label for="ageSelect" class="form-label">Materials Name</label>
                        <select id="unit" class="js-example-basic-single form-select" name="unit" data-width="100%"
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

                        </div>
                        <div class="mb-1 col-md-3">
                            <label for="password" class="form-label">Total Cost</label>
                            <div class="d-flex g-3">
                                <input type="text" class="form-control barcode_input" id="itemCost" placeholder="Item Cost" name="apro_cost"
                                     aria-describedby="btnGroupAddon" readonly>
                                <button type="submit" class="btn btn-primary ms-2"
                                   >add</button>
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
    $('.myForm').submit(function(event) {
        event.preventDefault(); // Prevent the default form submission
        var formData = new FormData(this); // Create a FormData object to send form data including files
        //validation
        $('#quantityError').text('');
        $('#productError').text('');
        var quantity = $('#quantity').val();
        var product = $('#productValid').val();
        $('#unitError').text('');
        var unit = $('#unit').val();
        if (!product) {
            $('#productError').text('Product is required.');
            return;
        }
        if (!quantity) {
            $('#quantityError').text('Quantity is required.');
            return;
        }
        if (!unit) {
            $('#unitError').text('Unit is required.');
            return;
        }
        //validation End
        $.ajax({
            type: 'POST',
            url: '/update/make/item',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                var productName = response.material.product.name;
                var productPrice = response.material.product.price;
                var unitName = response.material.unit.name;
                var productId = response.material.id;
                var aproCost = response.material.apro_cost;
                var newQuantity = response.material.quantity;
                var newAproCost = parseFloat(aproCost);
                var existingRow = $('.showData tr[data-id="' + productId + '"]');

                if (existingRow.length) {
                    // Update existing row
                    // var existingQuantity = parseFloat(existingRow.find('#quantity').text());
                    var existingAproCost = parseFloat(existingRow.find('.apro-cost').text());
                    var updatedQuantity =newQuantity;
                    var updatedAproCost = newAproCost;

                    existingRow.find('.quantity').text(newQuantity);
                    existingRow.find('.apro-cost').text(updatedAproCost.toFixed(2));
                } else {
                    // Add new row if product does not exist
                    var newRow = '<tr data-id="' + productId + '">' +
                                 '<td>' + productName + '</td>' +
                                 '<td>' + productPrice + '</td>' +
                                 '<td class="quantity">' + newQuantity + '</td>' +
                                 '<td>' + unitName + '</td>' +
                                 '<td class="apro-cost">' + aproCost + '</td>' +
                                 '<td><a type="button" class="btn btn-sm text-danger deleteRow"><i class="fas fa-trash-alt"></i></a></td>' +
                                 '</tr>';
                    $('.showData').append(newRow); // Append the new row to the table body
                }
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
    //validation
    $('#quantity').on('input', function() {
        $('#quantityError').text('');
    });
    $('#unit').change(function() {
        $('#unitError').text('');
    });
    $('#productValid').change(function() {
        $('#productError').text('');
    });
    // Selected Product Show Start
    function showSelectedItems() {
                let id = '{{ $itemEditId->id }}';
                $.ajax({
                    url: '/make/item/find/' + id,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(res) {
                        if (res.status == 200) {
                            const items = res.materialsItems;
                            // console.log(items);
                            items.forEach(item => {
                                // console.log(item)
                                var ItemId = item.id;
                                var ProductId = item.product_id;
                                const productName = item.product.name;
                                const productPrice = item.product.price;
                                const unitName = item.unit.name;
                                const quantity = item.quantity;
                                const aproCost = item.apro_cost;
                                var newRow = `
                            <tr data-id="${ItemId}">
                                <td>${productName}</td>
                                <td>${productPrice}</td>
                                <td class="quantity">${quantity}</td>

                                <td>${unitName}</td>
                                <td class="apro-cost">${aproCost}</td>
                                <td><a type="button" class="btn btn-sm text-danger deleteRow"><i class="fas fa-trash-alt"></i></a></td>
                            </tr>`;
                    $('.showData').append(newRow);
                            });

                            calculateTotalCost();
                        } else {
                            toastr.warning(res.error);
                        }
                    }
                });
            }
        showSelectedItems();
    //
    //Selected Product Show End
    $(document).on('click', '.deleteRow', function() {
        var row = $(this).closest('tr');
        var id = row.data('id');
        $.ajax({
            type: 'get',
            url: '/delete/material/' + id,
            data: {
                _token: '{{ csrf_token() }}',
            },
            success: function(response) {
                if (response.status === 200) {
                    row.remove();
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

    function calculateTotalCost() {
        var totalCost = 0;
        $('.apro-cost').each(function() {
            totalCost += parseFloat($(this).text());
        });
        $('#totalCost').text(totalCost.toFixed(2)); // Update the total cost display in the footer
        $('input[name="total_cost_price"]').val(totalCost.toFixed(2)); // Set the calculated total cost as the value of the input field
    }
});



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
