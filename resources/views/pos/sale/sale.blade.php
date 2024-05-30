@extends('master')
@section('title', '| Sale')
@section('admin')
<style>
    .mybtn_white {
  display: flex;
  align-items: center;
  justify-content: center;
  outline: none;
  cursor: pointer;
  width: 100px;
  height: 40px;
  background-image: linear-gradient(to top, #D8D9DB 0%, #fff 80%, #FDFDFD 100%);
  border-radius: 30px;
  border: 1px solid #00a9f1;
  transition: all 0.2s ease;
  font-family: "Source Sans Pro", sans-serif;
  font-size: 14px;
  font-weight: 400;
  color: #00a9f1;
  text-shadow: 0 1px #00a9f1;
}

.mybtn_white:hover {
  box-shadow: 0 3px 3px 1px #FCFCFC, 0 4px 6px #D6D7D9, 0 -2px 2px #CECFD1, 0 -2px 2px #FEFEFE, inset 0 0 2px 2px #CECFD1;
}
.mybtn_dark {
  display: flex;
  align-items: center;
  justify-content: center;
  outline: none;
  cursor: pointer;
  width: 100px;
  height: 40px;
  background-image: linear-gradient(to top, #172340 0%, #172340 80%, #172340 100%);
  border-radius: 30px;
  border: 1px solid #00a9f1;
  transition: all 0.2s ease;
  font-family: "Source Sans Pro", sans-serif;
  font-size: 14px;
  font-weight: 400;
  color: #fff;
  text-shadow: 0 1px #000;
}

.mybtn_dark:hover {
  box-shadow: 0 3px 3px 1px #172340, 0 4px 6px #172340, 0 -2px 2px #172340, 0 -2px 2px #666, inset 0 0 2px 2px #000;
}
/* .mybtn_white:active {
  box-shadow: 0 4px 3px 1px #00a9f1, 0 6px 8px #00a9f1, 0 -4px 4px #00a9f1, 0 -6px 4px #00a9f1, inset 0 0 5px 3px #00a9f1, inset 0 0 30px #00a9f1;
}

.mybtn_white:focus {
  box-shadow: 0 4px 3px 1px #FCFCFC, 0 6px 8px #D6D7D9, 0 -4px 4px #CECFD1, 0 -6px 4px #FEFEFE, inset 0 0 5px 3px rgba(0,169,241, .2), inset 0 0 30px rgba(0,169,241, .2);
} */

</style>
    <div class="row mt-0">
        <div class="col-lg-12 grid-margin stretch-card mb-3">
            <div class="card">
                <div class="card-body px-4 py-2">
                    <div class="row">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="neworder-tab" data-bs-toggle="tab" href="#neworder"
                                    role="tab" aria-controls="neworder" aria-selected="true">New Order</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab"
                                    aria-controls="profile" aria-selected="false">Order Queue</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled" id="disabled-tab" data-bs-toggle="tab" href="#disabled"
                                    role="tab" aria-controls="disabled" aria-selected="false">Details</a>
                            </li>
                        </ul>
                        <div class="tab-content border border-top-0 p-3" id="myTabContent">
                            {{-- New Order Start --}}
                            <div class="tab-pane fade show active" id="neworder" role="tabpanel"
                                aria-labelledby="neworder-tab">
                                <div class="row">
                                    <div class="col-md-2 pe-0">
                                        <div class="nav nav-tabs nav-tabs-vertical" id="v-tab" role="tablist"
                                            aria-orientation="vertical">
                                            @php
                                                $categories = App\Models\ItemCategory::all();
                                            @endphp
                                            @if ($categories->count() > 0)
                                                @foreach ($categories as $key => $category)
                                                    <a class="nav-link {{ $key == 0 ? 'active' : '' }}"
                                                        id="v-mytab{{ $category->id }}-tab" data-bs-toggle="pill"
                                                        href="#v-mytab{{ $category->id }}" role="tab"
                                                        aria-controls="v-mytab{{ $category->id }}"
                                                        aria-selected="true">{{ $category->category_name }}</a>
                                                @endforeach
                                            @else
                                                Note Found
                                            @endif
                                            {{-- <a class="nav-link active" id="v-home-tab" data-bs-toggle="pill" href="#v-home" role="tab" aria-controls="v-home" aria-selected="true">Home</a>
                                        <a class="nav-link" id="v-profile-tab" data-bs-toggle="pill" href="#v-profile" role="tab" aria-controls="v-profile" aria-selected="false">Profile</a>
                                        <a class="nav-link" id="v-messages-tab" data-bs-toggle="pill" href="#v-messages" role="tab" aria-controls="v-messages" aria-selected="false">Messages</a>
                                        <a class="nav-link" id="v-settings-tab" data-bs-toggle="pill" href="#v-settings" role="tab" aria-controls="v-settings" aria-selected="false">Settings</a> --}}
                                        </div>
                                    </div>
                                    <div class="col-md-5 ps-0">
                                        <div class="tab-content tab-content-vertical border p-3" id="v-tabContent">
                                            @php
                                                $categories = App\Models\ItemCategory::all();
                                            @endphp
                                            @if ($categories->count() > 0)
                                                @foreach ($categories as $key => $category)
                                                    <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}"
                                                        id="v-mytab{{ $category->id }}" role="tabpanel"
                                                        aria-labelledby="v-mytab{{ $category->id }}-tab">
                                                        @php
                                                            $items = App\Models\MakeItem::where(
                                                                'make_category_id',
                                                                $category->id,
                                                            )->get();
                                                        @endphp
                                                        @if ($items->count() > 0)
                                                            <div class="row">
                                                                <style>
                                                                    .product_image {
                                                                        position: relative;
                                                                        /* z-index: -1; */
                                                                    }

                                                                    /* .product_image::after {
                                                                        content: "";
                                                                        position: absolute;
                                                                        bottom: 4px;
                                                                        left: 4px;
                                                                        right: 4px;
                                                                        top: 4px;
                                                                        background: rgba(0, 0, 0, .3);
                                                                        z-index: 1;
                                                                    } */
                                                                </style>
                                                                @foreach ($items as $key => $item)
                                                                    <div class="col-lg-4 col-md-6 p-1 my-1 product_image"
                                                                        style="boder:1px solid red">
                                                                        <div class="Item__div w-100" product_id="{{ $item->id }}"
                                                                            style="cursor: pointer; ">
                                                                            <img class="w-100" height="120" style="border-radius:5px 5px 0 0;border-left: 1px solid;border-top: 1px solid;border-right: 1px solid;border-color:#00a9f1"
                                                                                src="https://images.unsplash.com/photo-1561154464-82e9adf32764?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=800&q=60">
                                                                            <div class="info"
                                                                                style="border-radius:0 0 5px 5px;color:black;background: rgba(255,255,255,.7);text-align:center;border-left: 1px solid;border-bottom: 1px solid;border-right: 1px solid;border-color:#00a9f1">
                                                                                <p>{{ Str::limit($item->item_name, 16, '') }}
                                                                                </p>
                                                                                <p>৳{{ $item->sale_price }}</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @else
                                                            <div class="row text-center">
                                                                <div class="col-lg-12">
                                                                    <div class="card" style="width:18rem;">
                                                                        <div class="card-body">
                                                                            <h5 class="card-title">Product Not Found</h5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            @else
                                                Note Found
                                            @endif


                                            {{-- <div class="tab-pane fade" id="v-profile" role="tabpanel" aria-labelledby="v-profile-tab">
                                          <h6 class="mb-1">Profile</h6>
                                          <p>Nulla est ullamco ut irure incididunt nulla Lorem Lorem minim irure officia enim reprehenderit. Magna duis labore cillum sint adipisicing
                                          exercitation ipsum. Nostrud ut anim non exercitation velit laboris fugiat cupidatat. Commodo esse dolore fugiat sint velit ullamco magna
                                          consequat voluptate minim amet aliquip ipsum aute laboris nisi.</p>
                                        </div>
                                        <div class="tab-pane fade" id="v-messages" role="tabpanel" aria-labelledby="v-messages-tab">
                                          <h6 class="mb-1">Messages</h6>
                                          <p>Nulla est ullamco ut irure incididunt nulla Lorem Lorem minim irure officia enim reprehenderit. Magna duis labore cillum sint adipisicing
                                          exercitation ipsum. Nostrud ut anim non exercitation velit laboris fugiat cupidatat. Commodo esse dolore fugiat sint velit ullamco magna
                                          consequat voluptate minim amet aliquip ipsum aute laboris nisi.</p>
                                        </div>
                                        <div class="tab-pane fade" id="v-settings" role="tabpanel" aria-labelledby="v-settings-tab">
                                          <h6 class="mb-1">Settings</h6>
                                          <p>Nulla est ullamco ut irure incididunt nulla Lorem Lorem minim irure officia enim reprehenderit. Magna duis labore cillum sint adipisicing
                                          exercitation ipsum. Nostrud ut anim non exercitation velit laboris fugiat cupidatat. Commodo esse dolore fugiat sint velit ullamco magna
                                          consequat voluptate minim amet aliquip ipsum aute laboris nisi.</p>
                                        </div> --}}
                                        </div>
                                    </div>
                                    <div class="col-md-5 ps-0" style="position: relative">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Product Information</th>
                                                    <th>Qty</th>
                                                    <th>Price</th>
                                                    <th><i class="fas fa-sliders"></i></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Americano (S/D) | 545412 | Dis: 10%</td>
                                                    <td>x 2</td>
                                                    <td>৳50000</td>
                                                    <td><i class="fa fa-trash"></i></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <div class="payment-footer" style="position: absolute;bottom:0;left:0;right:0">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <td>Total (Iteems: 2, Quantity: 10)</td>
                                                        <td>৳50000</td>
                                                    </tr>
                                                </thead>
                                            </table><table class="table">
                                                <tbody>
                                                    @php
                                                        $mode = App\models\PosSetting::all()->first();
                                                    @endphp
                                                    <tr>
                                                        <td><button class="{{ ($mode->dark_mode == 1) ? 'mybtn_white' : 'mybtn_dark' }}">Cash</button></td>
                                                        <td><button class="{{ ($mode->dark_mode == 1) ? 'mybtn_white' : 'mybtn_dark' }}">Cash</button></td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- New Order End --}}
                            {{-- Order Queue Start --}}
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">Order
                                Queue</div>
                            {{-- Order Queue End --}}
                            {{-- Details Start --}}
                            <div class="tab-pane fade" id="disabled" role="tabpanel" aria-labelledby="disabled-tab">Details
                            </div>
                            {{-- Details End --}}
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    {{-- table  --}}
    <div class="row">
        <div class="col-md-7 mb-1 grid-margin stretch-card">
            <div class="card">
                <div class="card-body px-4 py-2">
                    <div class="mb-3">
                        <h6 class="card-title">Items</h6>
                    </div>

                    <div id="" class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Discount</th>
                                    <th>Sub Total</th>
                                    <th>
                                        <i class="fa-solid fa-trash-can"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="showData">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5 mb-1 grid-margin stretch-card">
            <div class="card">
                <div class="card-body px-4 py-2">
                    <div class="row align-items-center mb-2">
                        <div class="col-sm-4">
                            Grand Total :
                        </div>
                        <div class="col-sm-8">
                            <input type="number" class="form-control grandTotal border-0 " name="" readonly
                                value="0.00" />
                        </div>

                        <input type="hidden" class="form-control total border-0 " name="total" readonly
                            value="0.00" />

                    </div>
                    <div class="row align-items-center mb-2">
                        <div class="col-sm-4">
                            Discount :
                        </div>
                        <div class="col-sm-8">
                            {{-- @php
                                $promotions = App\Models\Promotion::get();
                            @endphp --}}
                            {{-- <input type="number" class="form-control discount_field border-0 " name="discount_field"
                                readonly value="0.00" /> --}}
                            {{-- <span class="ms-3 discount_field">00</span> --}}
                            <select class="form-select discount_field" name="discount_field">

                            </select>
                        </div>
                    </div>

                    <div class="row align-items-center">
                        <div class="col-sm-8">
                            <input type="hidden" class="form-control grand_total border-0 " name="grand_total" readonly
                                value="0.00" />
                        </div>
                    </div>
                    <div class="row align-items-center mb-2">
                        <div class="col-sm-4">
                            <label for="name" class="form-label">Tax:</label>
                        </div>
                        <div class="col-sm-8">
                            @php
                                $taxs = App\Models\Tax::get();
                            @endphp
                            <select class="form-select tax" data-width="100%" onclick="errorRemove(this);"
                                onblur="errorRemove(this);" value="">
                                @if ($taxs->count() > 0)
                                    <option selected disabled>0%</option>
                                    @foreach ($taxs as $taxs)
                                        <option value="{{ $taxs->percentage }}">
                                            {{ $taxs->percentage }} %
                                        </option>
                                    @endforeach
                                @else
                                    <option selected disabled>Please Add Transaction</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="row align-items-center mb-2">
                        <div class="col-sm-4">
                            <label for="name" class="form-label">Pay Amount <span
                                    class="text-danger">*</span>:</label>
                        </div>
                        <div class="col-sm-8">
                            <input class="form-control total_payable" name="total_payable" type="number" value=""
                                onkeyup="errorRemove(this);">
                            <span class="text-danger total_payable_error"></span>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-sm-4">
                            Due/Return :
                        </div>
                        <div class="col-sm-8">
                            <input type="number" class="form-control total_due border-0 " name="" readonly
                                value="0.00" />
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-sm-4">
                            <label for="name" class="form-label">Transaction Method <span
                                    class="text-danger">*</span>:</label>
                        </div>
                        <div class="col-sm-8">
                            @php
                                $payments = App\Models\Bank::get();
                            @endphp
                            <select class="form-select payment_method" data-width="100%" onclick="errorRemove(this);"
                                onblur="errorRemove(this);">
                                @if ($payments->count() > 0)
                                    @foreach ($payments as $payemnt)
                                        <option value="{{ $payemnt->id }}">
                                            {{ $payemnt->name }}
                                        </option>
                                    @endforeach
                                @else
                                    <option selected disabled>Please Add Transaction</option>
                                @endif
                            </select>
                            <span class="text-danger payment_method_error"></span>
                        </div>
                    </div>

                    <div class="my-3">
                        <button class="btn btn-primary payment_btn"><i class="fa-solid fa-money-check-dollar"></i>
                            Payment</button>
                        <button id="printButton" class="btn btn-primary print_btn"><i
                                class="fa-solid fa-money-check-dollar"></i>
                            print</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        #printFrame {
            display: none;
            /* Hide the iframe */
        }
    </style>
    <iframe id="printFrame" src="" width="0" height="0"></iframe>
    <!-- Modal -->
    <div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="exampleModalScrollableTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Add Customer Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form class="customerForm row">
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Customer Name <span
                                    class="text-danger">*</span></label>
                            <input id="defaultconfig" class="form-control customer_name" maxlength="255" name="name"
                                type="text" onkeyup="errorRemove(this);" onblur="errorRemove(this);">
                            <span class="text-danger customer_name_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Phone Nnumber <span
                                    class="text-danger">*</span></label>
                            <input id="defaultconfig" class="form-control phone" maxlength="39" name="phone"
                                type="tel" onkeyup="errorRemove(this);" onblur="errorRemove(this);">
                            <span class="text-danger phone_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Email</label>
                            <input id="defaultconfig" class="form-control email" maxlength="39" name="email"
                                type="email">
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Address</label>
                            <input id="defaultconfig" class="form-control address" maxlength="39" name="address"
                                type="text">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Opening Receivable</label>
                            <input id="defaultconfig" class="form-control opening_receivable" maxlength="39"
                                name="opening_receivable" type="number">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Opening Payable</label>
                            <input id="defaultconfig" class="form-control opening_payable" maxlength="39"
                                name="opening_payable" type="number">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save_new_customer">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Select Product Start
            const Item__divs = document.querySelectorAll('.Item__div')
            console.log(Item__divs)
            Item__divs.forEach(function(item) {
                item.addEventListener('click', function(e) {
                const product_id = this.getAttribute('product_id');
                alert(product_id);
            });
            });
            // Select Product End
            $('#printButton').on('click', function() {
                var printFrame = $('#printFrame')[0];
                var printContentUrl =
                    '{{ route('sale.invoice', 102049) }}'; // Specify the URL of the content to be printed
                console.log('{{ route('sale.invoice', 102049) }}');
                $('#printFrame').attr('src', printContentUrl);

                printFrame.onload = function() {
                    printFrame.contentWindow.focus();
                    printFrame.contentWindow.print();
                };
            });
        });
    </script>



    <script>
        // error remove
        function errorRemove(element) {
            if (element.value != '') {
                $(element).siblings('span').hide();
                $(element).css('border-color', 'green');
            }
        }

        $(document).ready(function() {
            $('.barcode_input').focus();
            // var currentDate = new Date().toISOString().split('T')[0];
            // $('.purchase_date').val(currentDate);
            // show error
            function showError(name, message) {
                $(name).css('border-color', 'red');
                $(name).focus();
                $(`${name}_error`).show().text(message);
            }

            // customer view function
            function viewCustomer() {
                $.ajax({
                    url: '/get/customer',
                    method: 'GET',
                    success: function(res) {
                        const customers = res.allData;
                        // console.log(customers);
                        $('.select-customer').empty();
                        if (customers.length > 0) {
                            $.each(customers, function(index, customer) {
                                $('.select-customer').append(
                                    `<option value="${customer.id}">${customer.name}(${customer.phone})</option>`
                                );
                            })
                        } else {
                            $('.select-customer').html(`
                            <option selected disable>Please add Customer</option>`)
                        }
                    }
                })
            }
            viewCustomer();

            const saveCustomer = document.querySelector('.save_new_customer');
            saveCustomer.addEventListener('click', function(e) {
                e.preventDefault();
                // alert('ok')
                let formData = new FormData($('.customerForm')[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/add/customer',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.status == 200) {
                            // console.log(res);
                            $('#customerModal').modal('hide');
                            $('.customerForm')[0].reset();
                            viewCustomer();
                            toastr.success(res.message);
                        } else {
                            // console.log(res);
                            if (res.error.name) {
                                showError('.customer_name', res.error.name);
                            }
                            if (res.error.phone) {
                                showError('.phone', res.error.phone);
                            }
                        }
                    }
                });
            })


            // calculate quantity
            let totalQuantity = 0;

            // Function to update total quantity
            // function updateTotalQuantity() {
            //     totalQuantity = 0;
            //     $('.quantity').each(function() {
            //         let quantity = parseFloat($(this).val());
            //         if (!isNaN(quantity)) {
            //             totalQuantity += quantity;
            //         }
            //     });
            //     // console.log(totalQuantity);
            // }
            // Function to update total quantity
            function updateTotalQuantity() {
                totalQuantity = 0;
                $('.quantity').each(function() {
                    let quantity = parseFloat($(this).val());
                    if (!isNaN(quantity)) {
                        totalQuantity += quantity;
                    }
                });
            }



            // show Product function
            function showAddProduct(product, promotion) {
                // Check if a row with the same product ID already exists
                let existingRow = $(`.data_row${product.id}`);

                if (existingRow.length > 0) {
                    // If the row exists, update the quantity
                    let quantityInput = existingRow.find('.quantity');
                    let currentQuantity = parseInt(quantityInput.val());
                    let newQuantity = currentQuantity + 1;
                    quantityInput.val(newQuantity);
                } else {
                    // If the row doesn't exist, add a new row
                    $('.showData').append(
                        `<tr class="data_row${product.id}">

                <td>
                    <input type="text" class="form-control product_name${product.id} border-0 "  name="product_name[]" readonly value="${product.name ?? ""}" />
                </td>
                <td>
                    <input type="hidden" class="product_id" name="product_id[]" readonly value="${product.id ?? 0}" />
                    <input type="number" class="form-control product_price${product.id} border-0 "  name="unit_price[]" readonly value="${product.price ?? 0}" />
                </td>
                <td>
                    <input type="number" product-id="${product.id}" class="form-control quantity" name="quantity[]" value="1" />
                </td>
                <td style="padding-top: 20px;">

                    ${promotion && promotion.discount_type ?
                        promotion.discount_type == 'percentage' ?
                            `<span class="discount_percentage${product.id} mt-2">${promotion.discount_value}</span>%` :
                            `<span class="discount_amount${product.id} mt-2">${promotion.discount_value}</span>Tk` :
                        (promotion ? `<span class="mt-2">00</span>` : `<span class="mt-2">00</span>`)
                    }
                </td>
                <td>
                    ${
                        promotion ?
                            promotion.discount_type == 'percentage' ?
                                `<input type="number" class="form-control product_subtotal${product.id} border-0 " name="total_price[]" id="productTotal" readonly value="${product.price - (product.price * promotion.discount_value / 100)}" />`
                                :
                                `<input type="number" class="form-control product_subtotal${product.id} border-0" name="total_price[]" id="productTotal" readonly value="${product.price - promotion.discount_value}" />`
                            :
                            `<input type="number" class="form-control product_subtotal${product.id} border-0" name="total_price[]" id="productTotal" readonly value="${product.price}" />`
                    }
                </td>
                <td style="padding-top: 20px;">
                    <a href="#" class="btn btn-sm btn-danger btn-icon purchase_delete" style="font-size: 8px; height: 25px; width: 25px;" data-id=${product.id}>
                        <i class="fa-solid fa-trash-can" style="font-size: 0.8rem; margin-top: 2px;"></i>
                    </a>
                </td>
            </tr>`
                    );
                }
            }


            // Function to calculate the subtotal for each product
            function calculateTotal() {
                $('.quantity').each(function() {
                    let $quantityInput = $(this);
                    let productId = $quantityInput.attr('product-id');
                    let quantity = parseInt($quantityInput.val());
                    let price = parseFloat($('.product_price' + productId).val());
                    let productSubtotal = $('.product_subtotal' + productId);
                    let subtotal = quantity * price;

                    // Apply discount if available
                    $.ajax({
                        url: '/product/find/' + productId,
                        type: 'GET',
                        dataType: 'JSON',
                        success: function(res) {
                            const promotion = res.promotion;
                            if (promotion) {
                                if (promotion.discount_type == 'percentage') {
                                    let discountPercentage = promotion.discount_value;
                                    subtotal = subtotal - (subtotal * discountPercentage / 100);
                                } else {
                                    let discountAmount = promotion.discount_value;
                                    subtotal = subtotal - discountAmount;
                                }
                            }
                            productSubtotal.val(subtotal.toFixed(2));
                            calculateProductTotal();
                        }
                    });
                });
            }


            // Function to calculate the grand total from all products
            function calculateProductTotal() {
                let allProductTotal = document.querySelectorAll('#productTotal');
                let allTotal = 0;
                allProductTotal.forEach(product => {
                    let productValue = parseFloat(product.value);
                    if (!isNaN(productValue)) {
                        allTotal += productValue;
                    }
                });
                $('.grandTotal').val(allTotal.toFixed(2));
                $('.total').val(allTotal.toFixed(2));
                $('.grand_total').val(allTotal.toFixed(2));
            }
            calculateProductTotal();

            // Function to update grand total when a product is added or deleted
            function updateGrandTotal() {
                calculateTotal();
                calculateGrandTotal();
                updateTotalQuantity();
                calculateProductTotal();
            }


            // //  product add  with barcode
            // $('.barcode_input').change(function() {
            //     let barcode = $(this).val();
            //     // alert(barcode);
            //     $.ajax({
            //         url: '/product/barcode/find/' + barcode,
            //         type: 'GET',
            //         dataType: 'JSON',
            //         success: function(res) {
            //             if (res.status == 200) {
            //                 const product = res.data;
            //                 const promotion = res.promotion;
            //                 // console.log(res);
            //                 // console.log(promotion);
            //                 showAddProduct(product, promotion);
            //                 // Update SL numbers
            //                 calculateTotal();
            //                 calculateProductTotal();
            //                 updateGrandTotal();
            //                 // allProductTotal();
            //                 $('.barcode_input').val('');
            //                 // calculateGrandTotal();
            //             } else if (res.status == 300) {
            //                 // console.log(300)
            //                 toastr.warning(res.error);
            //                 $('.barcode_input').val('');
            //             } else {
            //                 // console.log(500)
            //                 toastr.warning(res.error);
            //                 $('.barcode_input').val('');
            //             }
            //         }
            //     })
            // })

            // // select product
            // $('.product_select').change(function() {
            //     let id = $(this).val();

            //     // alert(id);
            //     if ($(`.data_row${id}`).length === 0 && id) {
            //         $.ajax({
            //             url: '/product/find/' + id,
            //             type: 'GET',
            //             dataType: 'JSON',
            //             success: function(res) {
            //                 const product = res.data;
            //                 const promotion = res.promotion;
            //                 // console.log(promotion);
            //                 showAddProduct(product, promotion);
            //                 // Update SL numbers

            //                 updateGrandTotal();
            //                 calculateProductTotal();
            //                 // allProductTotal();
            //                 // calculateGrandTotal();
            //             }
            //         })
            //     }
            // })


            // Product add with barcode
            $('.barcode_input').change(function() {
                let barcode = $(this).val();
                $.ajax({
                    url: '/product/barcode/find/' + barcode,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(res) {
                        if (res.status == 200) {
                            const product = res.data;
                            const promotion = res.promotion;
                            showAddProduct(product, promotion);
                            updateGrandTotal();
                            $('.barcode_input').val('');
                        } else {
                            toastr.warning(res.error);
                            $('.barcode_input').val('');
                        }
                    }
                });
            });

            // Select product
            $('.product_select').change(function() {
                let id = $(this).val();
                if ($(`.data_row${id}`).length === 0 && id) {
                    $.ajax({
                        url: '/product/find/' + id,
                        type: 'GET',
                        dataType: 'JSON',
                        success: function(res) {
                            const product = res.data;
                            const promotion = res.promotion;
                            showAddProduct(product, promotion);
                            updateGrandTotal();
                        }
                    });
                }
            });

            // Purchase delete
            $(document).on('click', '.purchase_delete', function(e) {
                let id = $(this).attr('data-id');
                let dataRow = $('.data_row' + id);
                dataRow.remove();
                updateGrandTotal();
                updateTotalQuantity();
            });
            // Function to recalculate total
            // function calculateTotal() {
            //     $('.quantity').each(function() {
            //         let $quantityInput = $(this);
            //         let productId = $quantityInput.attr('product-id');

            //         $.ajax({
            //             url: '/product/find/' + productId,
            //             type: 'GET',
            //             dataType: 'JSON',
            //             success: function(res) {
            //                 const promotion = res.promotion;
            //                 let qty = parseInt($quantityInput
            //                     .val());
            //                 let price = parseFloat($('.product_price' + productId).val());
            //                 let product_subtotal = $('.product_subtotal' + productId);

            //                 if (promotion) {
            //                     if (promotion.discount_type == 'percentage') {
            //                         let discount_percentage = parseFloat($(
            //                             '.discount_percentage' +
            //                             productId).text());
            //                         let disPrice = price - (price * discount_percentage) / 100;
            //                         product_subtotal.val(disPrice * qty);
            //                     } else {
            //                         let discount_amount = parseFloat($('.discount_amount' +
            //                             productId).text());
            //                         let disPrice = price - discount_amount;
            //                         product_subtotal.val(disPrice * qty);
            //                     }
            //                 } else {
            //                     product_subtotal.val(qty * price);
            //                 }
            //             }
            //         });
            //     });
            // }


            // function calculateProductTotal() {
            //     let allProductTotal = document.querySelectorAll('#productTotal');
            //     let allTotal = 0;
            //     allProductTotal.forEach(product => {
            //         let productValue = parseFloat(product.value);
            //         allTotal += productValue;
            //         console.log(allTotal);
            //     });
            //     console.log(allTotal);
            //     $('.grandTotal').val(allTotal.toFixed(2));
            //     $('.total').val(allTotal.toFixed(2));
            //     $('.grand_total').val(allTotal.toFixed(2));
            // }




            // grandTotalCalulate
            function calculateGrandTotal() {
                let id = $('.select-customer').val();
                // let total = parseFloat($('.total').val());
                // console.log(id);
                if (id) {
                    $.ajax({
                        url: `/sale/customer/${id}`,
                        type: 'GET',
                        dataType: 'JSON',
                        success: function(res) {
                            // console.log(res)
                            const promotions = res.promotions;
                            // console.log(promotions);
                            if (promotions) {
                                $('.discount_field').html(
                                    `<option selected disabled>Select a Discount</option>`);
                                $.each(promotions, function(index, promotion) {
                                    $('.discount_field').append(
                                        `<option value="${promotion.id}">${promotion.promotion_name}(${promotion.discount_value} / ${promotion.discount_type})</option>`
                                    );
                                })
                            } else {
                                const total = $('.total').val();
                                $('.grand_total').val(total);
                                $('.grandTotal').val(total);
                                // console.log($('.total').val());
                                // $('.total_payable').val(total);
                                $('.discount_field').html(
                                    `<option>No Discount</option>`
                                );
                            }
                        }
                    })
                } else {
                    let total = $('.total').val();
                    $('.grand_total').val(total);
                    $('.discount_field').html(
                        `<option>No Discount</option>`
                    );
                    $('.grandTotal').val(total);
                    // $('.total_payable').val(total);
                }
            }
            calculateGrandTotal();
            // let id = $('.select-customer').val();
            // console.log(id);
            $(document).on('change', '.discount_field', function() {
                let id = $(this).val();
                $.ajax({
                    url: `/sale/promotions/${id}`,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(res) {
                        // console.log(res)
                        const promotion = res.promotions;
                        if (promotion) {
                            if (promotion.discount_type == 'percentage') {
                                let total = $('.total').val();
                                let grandTotalAmount = parseFloat(total - ((total * promotion
                                    .discount_value) / 100)).toFixed(2);
                                $('.grand_total').val(grandTotalAmount);
                                $('.grandTotal').val(grandTotalAmount);
                                // $('.total_payable').val(grandTotalAmount);
                            } else {
                                let total = $('.total').val();
                                let grandTotalAmount = parseFloat(total - promotion
                                        .discount_value)
                                    .toFixed(2);
                                $('.grand_total').val(grandTotalAmount);
                                $('.grandTotal').val(grandTotalAmount);
                                // $('.total_payable').val(grandTotalAmount);
                            }
                        } else {
                            let total = $('.total').val();
                            $('.grand_total').val(total);
                            $('.grandTotal').val(total);
                            // $('.total_payable').val(total);

                        }

                    }
                })
            })

            // Function to update grand total when a product is added or deleted
            // function updateGrandTotal() {
            //     calculateTotal();
            //     calculateGrandTotal();
            //     updateTotalQuantity();
            //     calculateProductTotal();
            // }


            $(document).on('click', '.quantity', function(e) {
                e.preventDefault();
                let id = $(this).attr("product-id")
                let quantity = $(this).val();
                quantity = parseInt(quantity);
                let subTotal = $('.product_subtotal' + id);
                if (quantity < 0) {
                    toastr.warning('quantity must be positive value');
                    $(this).val('');
                } else {
                    $.ajax({
                        url: `/product/find-qty/${id}`,
                        type: 'GET',
                        dataType: 'JSON',
                        success: function(res) {
                            let stock = res.product.stock;
                            let productPrice = res.product.price;
                            if (quantity > stock) {
                                $('.quantity').val(stock);
                                // subTotal.val(parseFloat(stock * productPrice).toFixed(2));
                                updateGrandTotal();
                                toastr.warning('Not enough stock');
                            } else {
                                // subTotal.val(parseFloat(quantity * productPrice).toFixed(2));
                                updateGrandTotal();
                            }

                        }
                    })
                }
            })

            $(document).on('keyup', '.quantity', function() {
                let id = $(this).attr("product-id")
                let quantity = $(this).val();
                quantity = parseInt(quantity);
                let subTotal = $('.product_subtotal' + id);
                if (quantity < 0) {
                    toastr.warning('quantity must be positive value');
                    $(this).val('');
                } else {
                    $.ajax({
                        url: `/product/find-qty/${id}`,
                        type: 'GET',
                        dataType: 'JSON',
                        success: function(res) {
                            let stock = res.product.stock;
                            let productPrice = res.product.price;
                            if (quantity > stock) {
                                $('.quantity').val(stock);
                                // subTotal.val(parseFloat(stock * productPrice).toFixed(2));
                                updateGrandTotal();
                                toastr.warning('Not enough stock');
                            } else {
                                // subTotal.val(parseFloat(quantity * productPrice).toFixed(2));
                                updateGrandTotal();
                            }

                        }
                    })
                }

            })

            // discount
            $(document).on('change', '.select-customer', function() {
                // let id = $(this).val();
                calculateGrandTotal();
            })


            // purchase Delete
            // $(document).on('click', '.purchase_delete', function(e) {
            //     // alert('ok');
            //     let id = $(this).attr('data-id');
            //     let dataRow = $('.data_row' + id);
            //     dataRow.remove();
            //     // Recalculate grand total
            //     updateGrandTotal();
            //     updateTotalQuantity();
            // })


            // total_payable
            $('.total_payable').keyup(function(e) {
                let grandTotal = parseFloat($('.grandTotal').val());
                let value = parseFloat($(this).val());
                totalDue();
                // $('.total_payable_amount').text(value);
            })

            // due
            function totalDue() {
                let pay = $('.total_payable').val();
                let grandTotal = parseFloat($('.grandTotal').val());
                let due = (grandTotal - pay).toFixed(2);
                $('.total_due').val(due);
            }


            $('.tax').change(function() {
                let grandTotal = parseFloat($('.grand_total').val());
                let value = parseInt($(this).val());
                // alert(value);

                let taxTotal = (grandTotal * value) / 100;
                taxTotal = (taxTotal + grandTotal).toFixed(2);
                // $('.grandTotal').text(taxTotal);
                $('.grandTotal').val(taxTotal);
                // $('.total_payable').val(taxTotal);
            })

            const total_payable = document.querySelector('.total_payable');
            total_payable.addEventListener('keydown',
                function(e) {
                    if (event.key === 'Enter') {
                        event.preventDefault();
                        let customer_id = $('.select-customer').val();
                        let sale_date = $('.purchase_date').val();
                        let formattedSaleDate = moment(sale_date, 'DD-MMM-YYYY').format('YYYY-MM-DD HH:mm:ss');
                        let quantity = totalQuantity;
                        let total_amount = parseFloat($('.total').val());
                        let discount = $('.discount_field').val();
                        let total = parseFloat($('.grand_total').val());
                        let tax = $('.tax').val();
                        let change_amount = parseFloat($('.grandTotal').val());
                        let actual_discount = change_amount - total;
                        let paid = $('.total_payable').val();
                        let due = $('.total_due').val();
                        let note = $('.note').val();
                        let payment_method = $('.payment_method').val();
                        // let product_id = $('.product_id').val();
                        // console.log(total_quantity);

                        let products = [];

                        $('tr[class^="data_row"]').each(function() {
                            let row = $(this);
                            // Get values from the current row's elements
                            let product_id = row.find('.product_id').val();
                            let quantity = row.find('input[name="quantity[]"]').val();
                            let unit_price = row.find('input[name="unit_price[]"]').val();
                            let discount_amount = row.find(`span[class='discount_amount${product_id}']`)
                                .text() || 0;
                            let discount_percentage = (row.find(
                                `span[class='discount_percentage${product_id}']`).text()) || 0;
                            let total_price = row.find('input[name="total_price[]"]').val();

                            // Create an object with the gathered data
                            let product = {
                                product_id,
                                quantity,
                                unit_price,
                                discount: discount_amount == 0 ? discount_percentage : 0,
                                total_price
                            };

                            // Push the object into the products array
                            products.push(product);
                        });

                        let allData = {
                            // for purchase table
                            customer_id,
                            sale_date: formattedSaleDate,
                            quantity,
                            total_amount,
                            discount,
                            actual_discount,
                            total,
                            change_amount,
                            tax,
                            paid,
                            due,
                            note,
                            payment_method,
                            products
                        }

                        // console.log(allData);
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            url: '/sale/store',
                            type: 'POST',
                            data: allData,
                            success: function(res) {
                                if (res.status == 200) {
                                    // console.log(res.data);
                                    // $('#paymentModal').modal('hide');
                                    // $('.supplierForm')[0].reset();
                                    // supplierView();
                                    toastr.success(res.message);
                                    let id = res.saleId;
                                    // console.log(id)

                                    // window.location.href = '/sale/invoice/' + id;
                                    var printFrame = $('#printFrame')[0];
                                    var printContentUrl = '/sale/print/' +
                                        id; // Specify the URL of the content to be printed
                                    // console.log('{{ route('sale.invoice', 102049) }}');
                                    $('#printFrame').attr('src', printContentUrl);

                                    printFrame.onload = function() {
                                        printFrame.contentWindow.focus();
                                        printFrame.contentWindow.print();
                                        // Redirect after printing
                                        printFrame.contentWindow.onafterprint = function() {
                                            window.location.href = "/sale";
                                        };
                                    };

                                } else {
                                    if (res.error.customer_id) {
                                        showError('.select-customer', res.error.customer_id);
                                    }
                                    if (res.error.sale_date) {
                                        showError('.purchase_date', res.error.sale_date);
                                    }
                                    if (res.error.payment_method) {
                                        showError('.payment_method', res.error.payment_method);
                                    }
                                }
                            }
                        });
                    }
                })
            // order btn
            $('.payment_btn').click(function(e) {
                e.preventDefault();
                // alert('ok');
                let customer_id = $('.select-customer').val();
                let sale_date = $('.purchase_date').val();
                let formattedSaleDate = moment(sale_date, 'DD-MMM-YYYY').format('YYYY-MM-DD HH:mm:ss');
                let quantity = totalQuantity;
                let total_amount = parseFloat($('.total').val());
                let discount = $('.discount_field').val();
                let total = parseFloat($('.grand_total').val());
                let tax = $('.tax').val();
                let change_amount = parseFloat($('.grandTotal').val());
                let actual_discount = change_amount - total;
                let paid = $('.total_payable').val();
                let due = $('.total_due').val();
                let note = $('.note').val();
                let payment_method = $('.payment_method').val();
                // let product_id = $('.product_id').val();
                // console.log(total_quantity);

                let products = [];

                $('tr[class^="data_row"]').each(function() {
                    let row = $(this);
                    // Get values from the current row's elements
                    let product_id = row.find('.product_id').val();
                    let quantity = row.find('input[name="quantity[]"]').val();
                    let unit_price = row.find('input[name="unit_price[]"]').val();
                    let discount_amount = row.find(`span[class='discount_amount${product_id}']`)
                        .text() || 0;
                    let discount_percentage = (row.find(
                        `span[class='discount_percentage${product_id}']`).text()) || 0;
                    let total_price = row.find('input[name="total_price[]"]').val();

                    // Create an object with the gathered data
                    let product = {
                        product_id,
                        quantity,
                        unit_price,
                        discount: discount_amount == 0 ? discount_percentage : 0,
                        total_price
                    };

                    // Push the object into the products array
                    products.push(product);
                });

                let allData = {
                    // for purchase table
                    customer_id,
                    sale_date: formattedSaleDate,
                    quantity,
                    total_amount,
                    discount,
                    actual_discount,
                    total,
                    change_amount,
                    tax,
                    paid,
                    due,
                    note,
                    payment_method,
                    products
                }

                // console.log(allData);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '/sale/store',
                    type: 'POST',
                    data: allData,
                    success: function(res) {
                        if (res.status == 200) {
                            // console.log(res.data);
                            // $('#paymentModal').modal('hide');
                            // $('.supplierForm')[0].reset();
                            // supplierView();
                            toastr.success(res.message);
                            let id = res.saleId;
                            // console.log(id)

                            // window.location.href = '/sale/invoice/' + id;
                            var printFrame = $('#printFrame')[0];
                            var printContentUrl = '/sale/print/' +
                                id; // Specify the URL of the content to be printed
                            // console.log('{{ route('sale.invoice', 102049) }}');
                            $('#printFrame').attr('src', printContentUrl);

                            printFrame.onload = function() {
                                printFrame.contentWindow.focus();
                                printFrame.contentWindow.print();
                                // Redirect after printing
                                printFrame.contentWindow.onafterprint = function() {
                                    window.location.href = "/sale";
                                };
                            };

                        } else {
                            console.log(res.error)
                            if (res.error.paid) {
                                showError('.total_payable', res.error.paid);
                            }
                            if (res.error.customer_id) {
                                showError('.select-customer', res.error.customer_id);
                            }
                            if (res.error.sale_date) {
                                showError('.purchase_date', res.error.sale_date);
                            }
                            if (res.error.payment_method) {
                                showError('.payment_method', res.error.payment_method);
                            }
                        }
                    }
                });

            })
        })
    </script>
@endsection
