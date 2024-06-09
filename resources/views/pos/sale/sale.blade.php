@extends('master')
@section('title', '| Sale')
@section('admin')
    @php
        $mode = App\models\PosSetting::all()->first();
    @endphp
    <style>
        .disabled-div {
            pointer-events: none;
            /* Disable mouse interactions */
            opacity: 0.5;
            /* Make the div look disabled */
        }

        #myfooter {
            display: none !important;
        }

        .page-content {
            padding: 5px 5px 0 5px !important;
        }

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

        .my_select_white {
            border: 1px solid #00a9f1 !important;
            color: #00a9f1 !important;
            border-radius: 14px !important;
            background: linear-gradient(182deg, #f0f0f0, #cacaca) !important;
            outline: #00a9f1 !important;
        }

        .my_select_white {
            border: 1px solid #00a9f1 !important;
            color: #00a9f1 !important !important;
            border-radius: 14px !important;
            background: linear-gradient(145deg, #15203a, #192544) !important;
            outline: #00a9f1 !important;
        }

        .my_select:active {
            border: 1px solid #00a9f1 !important;
            color: #00a9f1 !important;
        }

        .my_select:focus {
            border: 1px solid #00a9f1 !important;
            color: #00a9f1 !important;
        }
    </style>
    <div class="row mt-0">
        <div class="col-lg-12 grid-margin stretch-card mb-0">
            <div class="card">
                <div class="card-body px-4 pt-2 pb-0">
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
                                        </div>
                                    </div>
                                    <div class="col-md-5 ps-0">
                                        <div class="tab-content tab-content-vertical border px-3 py-0" id="v-tabContent">
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
                                                            <div class="row"
                                                                style="max-height: 400px; overflow-y: scroll;">
                                                                <style>
                                                                    .product_image {
                                                                        position: relative;
                                                                    }
                                                                </style>
                                                                @foreach ($items as $key => $item)
                                                                    <div class="col-lg-4 col-md-6 p-1 my-1 product_image"
                                                                        style="">
                                                                        <div class="Item__div w-100"
                                                                            product_id="{{ $item->id }}"
                                                                            style="cursor: pointer; ">
                                                                            <img class="w-100" height="90"
                                                                                style="border-radius:5px 5px 0 0;border-left: 1px solid;border-top: 1px solid;border-right: 1px solid;border-color:#00a9f1"
                                                                                src="{{ !empty($item->picture) ? asset($item->picture) : asset('assets/images/empty.png') }}">
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
                                        </div>
                                    </div>
                                    <div class="col-md-5 ps-0" style="position: relative">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    @php $customers = App\Models\Customer::first(); @endphp

                                                    <th style="font-size: 10px; padding: 0 20px 10px 13px">
                                                        Customer Info:<br>
                                                        <span class="customer_name">{{ $customers->name }}</span>
                                                        <input type="hidden" class="customer_id" value="{{$customers->id}}">
                                                        <input type="hidden" value="0" class="sale_id">
                                                        <input type="hidden" value="<?php echo rand(123456, 99999) ?>" class="invoice_number">
                                                        <input type="hidden" value="0" class="payment_method"
                                                            value="0">
                                                    </th>
                                                    <th style="font-size: 10px; padding: 0 20px 10px 13px">

                                                        <span class="customer_address">{{ !empty($customers->phone) ? $customers->phone : $customers->address }}</span><br>
                                                        <span> P. Total: <span class="customer_total_receivable">{{ $customers->total_receivable }}</span></span>
                                                    </th>
                                                    <th>
                                                        <button data-bs-target="#customerModal" data-bs-toggle="modal"
                                                            class="{{ $mode->dark_mode == 1 ? 'mybtn_white' : 'mybtn_dark' }}"
                                                            style="width: 35px; height: 25px; border-radius:5px;font-size:10px;padding-left: 0px;"><i
                                                                class="fa fa-pencil"></i></button>
                                                    </th>
                                                </tr>
                                            </thead>
                                        </table>
                                        <style>
                                            tr th,
                                            tr td {
                                                padding: 5px !important;
                                            }
                                        </style>
                                        <div class="renderData">
                                            @include('pos.sale.sales_detailes_ramder_data')
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="row tableQueueRender">

                                </div>
                            </div>
                            <div class="tab-pane fade" id="disabled" role="tabpanel" aria-labelledby="disabled-tab">
                                Details
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <iframe id="printFrame" src="" width="0" height="0"></iframe>
    <!-- Modal -->
    <div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="exampleModalScrollableTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Add or Select Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form class="customerForm row">
                        <div class="col-md-12 form-valid-groups pe-0">
                            <label for="ageSelect" class="form-label">Choose Customer</label>
                            @php $customers = App\Models\Customer::all(); @endphp
                            <select class=" form-select select_customer" data-width="100%" name="make_category_id">
                                @if ($customers)
                                    <option selected disabled>Please Select Customer</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}" >{{ $customer->name }} </option>
                                    @endforeach
                                @else
                                    <option selected disabled>Please Select Customer</option>
                                @endif
                            </select>
                            @error('make_category_id')
                            <div class="text-danger">{{ $message }}</div>
                           @enderror
                            <span class="text-danger product_select_error"></span>
                        </div>
                        <div class="mb-3 col-md-6 mt-3">
                            <label for="name" class="form-label">Customer Name <span
                                    class="text-danger">*</span></label>
                            <input id="defaultconfig" class="form-control customer_name" maxlength="255" name="name"
                                type="text" onkeyup="errorRemove(this);" onblur="errorRemove(this);">
                            <span class="text-danger customer_name_error"></span>
                        </div>
                        <div class="mb-3 col-md-6 mt-3">
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
    <div class="modal fade" id="saleModal" tabindex="-1" aria-labelledby="exampleModalScrollableTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Payment Section</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form class="customerForm row">
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Sub Total</label>
                            <input id="defaultconfig" class="form-control modal_subtotal" maxlength="39" type="number">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Tax</label>
                            <select name="" id="" class="form-control">
                                <option value="0">0%</option>
                                <option value="5">5%</option>
                                <option value="7">7%</option>
                                <option value="15">15%</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Grand Total</label>
                            <input id="defaultconfig" class="form-control opening_payable" maxlength="39"
                                name="opening_payable" type="number">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Pay Amount</label>
                            <input id="defaultconfig" class="form-control opening_payable" maxlength="39"
                                name="opening_payable" type="number">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Cash Back</label>
                            <input id="defaultconfig" class="form-control opening_payable" maxlength="39"
                                name="opening_payable" type="number">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save_new_customer"><i class="fa fa-print"></i> Print</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        showTableQueue();

        function showTableQueue() {
            $.ajax({
                url: '/show/queue',
                type: 'GET',
                success: function(res) {
                    let allQueueData = '';
                    $.each(res.sales, function(key, val) {
                        allQueueData += `<div class="col-md-3">
                        <div class="card">
                            <div class="card-header d-flex" style="padding-bottom: 0px !important;justify-content:space-between">
                                <h6 class="card-title text-info text-center mt-1">Dine-1</h6>
                                <p class="card-title text-info text-center">Date: 04-06-2024</p>
                            </div>
                            <div class="card-body p-3 pt-0">
                            <table class="table">
                                <tr>
                                    <td style="text-align:right">Invoice No :</td>
                                    <td><a href="#">#${val.invoice_number}</a></td>
                                </tr>
                                <tr>
                                    <td style="text-align:right">Items x ${val.quantity} :</td>
                                    <td>${val.receivable}</td>
                                </tr>
                                <tr>
                                    <td style="text-align:right">Discount :</td>
                                    <td>${val.discount}</td>
                                </tr>
                                <tr>
                                    <td style="text-align:right">Total :</td>
                                    <td>${val.final_receivable}</td>
                                </tr>
                            </table>
                            </div>
                            <div class="card-footer" style="padding: 5px!important">
                                <div class="d-flex" style="flex-wrap:wrap;justify-content:center">
                                    <button class="cashby_tablequeue {{ $mode->dark_mode == 1 ? 'mybtn_white' : 'mybtn_dark' }}"
                                        style="; max-width:48px;border-radius:10px; margin-top:5px" value="${val.final_receivable}">Cash</button>
                                    <button class="{{ $mode->dark_mode == 1 ? 'mybtn_white' : 'mybtn_dark' }}"
                                        style="margin-left:5px; max-width:48px;border-radius:10px; margin-top:5px">bKash</button>
                                    <button class="{{ $mode->dark_mode == 1 ? 'mybtn_white' : 'mybtn_dark' }}"
                                        style="margin-left:5px; max-width:48px;border-radius:10px; margin-top:5px">Nagad</button>
                                    <button class="{{ $mode->dark_mode == 1 ? 'mybtn_white' : 'mybtn_dark' }}"
                                        style="margin-left:5px; max-width:48px;border-radius:10px; margin-top:5px">Card</button>
                                </div>
                            </div>
                        </div>

                    </div>`;
                    });
                    document.querySelector('.tableQueueRender').innerHTML = allQueueData;
                }

            });
        }
        // let cashby_tablequeue = document.querySelectorAll('.cashby_tablequeue');
        // console.log(cashby_tablequeue)
        // cashby_tablequeue.forEach(btn =>{
        //     btn.addEventListener('click',function(e){
        //         e.preventDefault();
        //         let value = e.target.value;
        //         alert(vale)
        //     });
        // });
        $(document).on('click','.cashby_tablequeue',function(e){
            e.preventDefault();
            let value = e.target.value;
            $('#saleModal').modal('show');
            document.querySelector('.modal_subtotal').value = value;
        });
        const Item__div = document.querySelectorAll('.Item__div');
        Item__div.forEach(element => {
            element.addEventListener('click', function(e) {
                const product_id = element.getAttribute('product_id');
                const customer_id = document.querySelector('.customer_id').value;
                const sale_id = document.querySelector('.sale_id').value;
                const payment_method = document.querySelector('.payment_method').value;
                const sale_discount = document.querySelector('.sale_discount').value ?? 0;
                const dine = document.querySelector('.select_dine').value ?? 0;
                const invoice_number = document.querySelector('.invoice_number').value;
                const note = "Note dynamic korte hobe";
                const tax = 1;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/sale/store',
                    type: 'POST',
                    data: {
                        product_id,
                        customer_id,
                        sale_id,
                        payment_method,
                        sale_discount,
                        dine,
                        invoice_number,
                        note,
                        tax
                    },
                    success: function(res) {
                        // Assuming the response is in JSON format and contains the HTML
                        if (res && res.html) {
                            enableDiv('controls');
                            document.querySelector('.renderData').innerHTML = res.html;
                            document.querySelector('.sale_id').value = document.querySelector(
                                '.render_sale_id').value;
                            // Re-attach event listeners to the newly added elements
                            attachEventListeners();
                        } else {
                            console.error('Invalid response format:', res);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', error);
                    }
                });
            });
        });

        function attachEventListeners() {
            let sale_discount = document.querySelector('.sale_discount');
            if (sale_discount) {
                sale_discount.addEventListener('input', function(e) {

                    let final_discount = this.value;

                    let final_receivable_main_value = document.querySelector('.final_receivable_main_value').value;
                    let discountCalculator = final_receivable_main_value - final_discount;
                    document.querySelector('.final_receivable').textContent = discountCalculator;
                });
            }

            const remove_items = document.querySelectorAll('.remove_item');
            remove_items.forEach(function(item) {
                item.addEventListener('click', function(event) {
                    alert("OK");
                });
            });
            const btn_add_queu = document.querySelector('.btn_add_queu');
            btn_add_queu.addEventListener('click', function(event) {

                const select_dine = document.querySelector('.select_dine');
                const customer_id = document.querySelector('.customer_id').value;
                const sale_id = document.querySelector('.sale_id').value;
                const payment_method = document.querySelector('.payment_method').value;
                const sale_discount = document.querySelector('.sale_discount').value ?? 0;
                const tax = 1;
                const note = "Note dynamic korte hobe";
                if(select_dine.value === ''){
                    toastr.error('Please Select Dine');
                    select_dine.focus();
                    return false;
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/update/sale',
                    type: 'POST',
                    data: {
                        customer_id,
                        sale_id,
                        payment_method,
                        sale_discount,
                        note,
                        tax
                    },
                    success: function(res) {

                        if (res && res.html) {
                            toastr.success('Qrder Queue Successfully Added');
                            document.querySelector('.renderData').innerHTML = res.html;
                            showTableQueue();
                            attachEventListeners();
                            disableDiv('controls');
                            document.querySelector('.sale_id').value = "0";
                            document.querySelector('.sale_items_count').textContent = "0";
                            document.querySelector('.sale_item_quantity').textContent = "0";
                            document.querySelector('.total_sale_receivable').textContent = "0";
                            document.querySelector('.final_receivable').textContent = "0";
                            document.querySelector('.final_receivable_main_value').value = "0";
                        } else {
                            console.error('Invalid response format:', res);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', error);
                    }
                });

            });

        }
        attachEventListeners();
        disableDiv('controls')

        function disableDiv(divId) {
            // Get the div by its ID
            const div = document.getElementById(divId);

            // Get all input elements within the div
            const inputs = div.querySelectorAll('input, textarea, select, button');

            // Disable all input elements
            inputs.forEach(function(input) {
                input.disabled = true;
            });

            // Optionally, you can add a class to indicate the div is disabled
            div.classList.add('disabled-div');
        }

        function enableDiv(divId) {
            // Get the div by its ID
            const div = document.getElementById(divId);

            // Get all input elements within the div
            const inputs = div.querySelectorAll('input, textarea, select, button');

            // Enable all input elements
            inputs.forEach(function(input) {
                input.disabled = false;
            });

            // Remove the class that indicates the div is disabled
            div.classList.remove('disabled-div');
        }

        const select_customer = document.querySelector('.select_customer');
        select_customer.addEventListener('change', function(e) {
            // toastr.success('Please select');
            const customer_id = document.querySelector('.select_customer').value;
            $.ajax({
                url:'select/customer/for-pos/' + customer_id,
                type:'get',
                success:function(res){
                    toastr.success('Customer Successfully Added');
                    $('#customerModal').modal('hide');
                    document.querySelector('.customer_name').textContent = res.data.name;
                    let phoneoraddress;
                    if(res.data.phone !== null){
                        phoneoraddress = res.data.phone
                    }
                    else{
                        phoneoraddress = res.data.address
                    }
                    document.querySelector('.customer_address').textContent = phoneoraddress;
                    document.querySelector('.customer_total_receivable').textContent = res.data.total_receivable;
                    document.querySelector('.customer_id').value = res.data.id;
                }
            });
        });

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
                            toastr.success(res.message);
                            document.querySelector('.customer_name').textContent = res.data.name;
                            let phoneoraddress;
                            if(res.data.phone !== null){
                                phoneoraddress = res.data.phone
                            }
                            else{
                                phoneoraddress = res.data.address
                            }
                            document.querySelector('.customer_address').textContent = phoneoraddress;
                            document.querySelector('.customer_total_receivable').textContent = res.data.total_receivable;
                            document.querySelector('.customer_id').value = res.data.id;
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
    </script>
@endsection
