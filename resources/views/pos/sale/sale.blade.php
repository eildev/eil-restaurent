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

        .mytop__tab__controls {
            cursor: pointer;
        }

        .mytop__tab-page {
            display: none;
        }

        .active {
            color: #00a9f1;
            display: block;
        }

        .menu__tab__pag {
            display: none;
        }

        .menu__tab__control {
            cursor: pointer;

            @if ($mode->dark_mode == 1)
                color: black !important;
            @else
                color: white !important;
            @endif

        }

        .menu__active {
            display: block;
            color: #6571ff !important;
        }
    </style>
    <div class="row mt-0">
        <div class="col-lg-12 grid-margin stretch-card mb-0">
            <div class="card">
                <div class="card-body px-4 pt-2 pb-0" style="min-height: 520px !important">
                    <div class="row">
                        <div class="mytop__container border p-0">
                            {{-- My top Tab Head Start  --}}
                            <div class="mytop__head d-flex">
                                <div class="mytop__tab__first mytop__tab__controls active p-2 border" tab__index="1">
                                    <span>New Order</span>
                                </div>
                                <div class="mytop__tab__controls p-2 border" tab__index="2">
                                    <span>Proccessing</span>
                                </div>
                                {{-- <div class="mytop__tab__controls p-2 border" tab__index="3">
                                    <span>Complete</span>
                                </div> --}}
                                <div class="mytop__tab__controls p-2 border mytop__tab__last" tab__index="4">
                                    <span>Details</span>
                                </div>
                            </div>
                            {{-- My top Tab Head End  --}}
                            {{-- My top Tab Body Start  --}}
                            <div class="mytop__body">
                                <div class="mytop__tab-page active p-2 border tap_page--1">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="menu__tab">

                                                @php
                                                    $index = 1;
                                                    $categories = App\Models\ItemCategory::all();
                                                @endphp
                                                <div class="menu__active menu__tab__control border py-1 px-2"
                                                    menu__tab__index="{{ $index }}">
                                                    <span>Set Menu</span>
                                                </div>
                                                @if ($categories->count() > 0)
                                                    @foreach ($categories as $key => $category)
                                                        @php $index++; @endphp
                                                        <div class="menu__tab__control border py-1 px-2"
                                                            menu__tab__index="{{ $index }}">
                                                            <span>{{ $category->category_name }}</span>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <span>Note Found</span>
                                                @endif
                                                {{-- <div class="menu__tab__control border py-1 px-2" menu__tab__index="3">
                                                    <span>Menu - 2</span>
                                                </div> --}}
                                            </div>
                                        </div>
                                        <div class="col-md-5 border">
                                            <div class="menu__active menu__tab__pag menu__tab__pag--1"
                                                style="min-height: 470px;">
                                                @php
                                                    $setmenus = App\Models\SetMenu::all();
                                                @endphp
                                                @if ($setmenus->count() > 0)
                                                    <div class="row" style="max-height: 500px; overflow-y: scroll;">
                                                        <style>
                                                            .product_image {
                                                                position: relative;
                                                            }
                                                        </style>
                                                        @foreach ($setmenus as $key => $setmenu)
                                                            <div class="col-lg-3 col-md-6 p-1 my-1 product_image"
                                                                style="">
                                                                <div class="setmenu__div w-100"
                                                                    set_menu_id="{{ $setmenu->id }}"
                                                                    style="cursor: pointer; ">
                                                                    <img class="w-100" height="90"
                                                                        style="border-radius:5px 5px 0 0;border-left: 1px solid;border-top: 1px solid;border-bottom: 1px solid;border-right: 1px solid;border-color:#00a9f1"
                                                                        src="{{ !empty($setmenu->image) ? asset('uploads/menu_items/' . $setmenu->image) : asset('assets/images/empty.png') }}">
                                                                    <div class="info"
                                                                        style="border-radius:0 0 5px 5px;color:black;background: rgba(255,255,255,.7);text-align:center;border-left: 1px solid;border-bottom: 1px solid;border-right: 1px solid;border-color:#00a9f1">
                                                                        <p style="font-size: 12px">
                                                                            {{ Str::limit($setmenu->menu_name, 16, '') }}
                                                                        </p>
                                                                        <hr style="margin: 0">
                                                                        <p>৳{{ $setmenu->sale_price }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                            @php
                                                $categories = App\Models\ItemCategory::all();
                                                $index = 1;
                                            @endphp
                                            @if ($categories->count() > 0)
                                                @foreach ($categories as $key => $category)
                                                    @php $index++; @endphp
                                                    <div class="menu__tab__pag menu__tab__pag--{{ $index }}">
                                                        @php
                                                            $items = App\Models\MakeItem::where(
                                                                'make_category_id',
                                                                $category->id,
                                                            )->get();
                                                        @endphp
                                                        @if ($items->count() > 0)
                                                            <div class="row"
                                                                style="max-height: 500px; overflow-y: scroll;">
                                                                <style>
                                                                    .product_image {
                                                                        position: relative;
                                                                    }
                                                                </style>
                                                                @foreach ($items as $key => $item)
                                                                    <div class="col-lg-3 col-md-6 p-1 my-1 product_image"
                                                                        style="">
                                                                        <div class="Item__div w-100"
                                                                            product_id="{{ $item->id }}"
                                                                            style="cursor: pointer; ">
                                                                            <img class="w-100" height="90"
                                                                                style="border-radius:5px 5px 0 0;border-left: 1px solid;border-bottom: 1px solid;border-top: 1px solid;border-right: 1px solid;border-color:#00a9f1"
                                                                                src="{{ !empty($item->picture) ? asset($item->picture) : asset('assets/images/empty.png') }}">
                                                                            <div class="info"
                                                                                style="border-radius:0 0 5px 5px;color:black;background: rgba(255,255,255,.7);text-align:center;border-left: 1px solid;border-bottom: 1px solid;border-right: 1px solid;border-color:#00a9f1">
                                                                                <p style="font-size: 12px">
                                                                                    {{ Str::limit($item->item_name, 16, '') }}
                                                                                </p>
                                                                                <hr style="margin: 0">
                                                                                <p>৳{{ $item->sale_price }}</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @else
                                                            <div class="row text-center">
                                                                <div class="col-lg-12">
                                                                    <div class="card" style="width:22rem;margin-top:50px">
                                                                        <div class="card-body">
                                                                            <h5 class="card-title">Product Not Found
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            @endif
                                            {{-- <div class="menu__tab__pag menu__tab__pag--3">P-3</div> --}}
                                        </div>
                                        <div class="col-md-5 border">
                                            {{-- Right Side Controls --}}
                                            {{-- Customer Details Information  --}}
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        @php $customers = App\Models\Customer::first(); @endphp

                                                        <th style="font-size: 10px; padding: 0 20px 10px 13px">
                                                            Customer Info:<br>
                                                            <span class="customer_name">{{ $customers->name ?? '' }}</span>
                                                            <input type="hidden" class="customer_id"
                                                                value="{{ $customers->id ?? '' }}">
                                                            <input type="hidden" value="0" class="sale_id">
                                                            <input type="hidden" value="<?php echo rand(123456, 99999); ?>"
                                                                class="invoice_number">
                                                            <input type="hidden" value="0" class="payment_method"
                                                                value="0">
                                                        </th>
                                                        <th style="font-size: 10px; padding: 0 20px 10px 13px">

                                                            <span
                                                                class="customer_address">{{ !empty($customers->phone) ? $customers->phone : $customers->address ?? '' }}</span><br>
                                                            <span> P. Total: <span
                                                                    class="customer_total_receivable">{{ $customers->total_receivable ?? 0 }}</span></span>
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
                                            {{-- Rander Data  --}}
                                            <div class="renderData">
                                                @include('pos.sale.sales_detailes_ramder_data')
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    @include('pos.sale.controls')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mytop__tab-page p-2 border tap_page--2">
                                    {{-- Order Processing Queu Data  --}}
                                    <div class="row tableQueueRender">
                                    </div>
                                </div>
                                {{-- <div class="mytop__tab-page p-2 border tap_page--3">
                                    <span>Order Complete Page</span>
                                </div> --}}
                                <div class="mytop__tab-page p-2 border tap_page--4">
                                    <div class="SaleDetails">
                                        @include('pos.sale.details')
                                    </div>

                                </div>
                            </div>
                            {{-- My top Tab Body End  --}}
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
                                        <option value="{{ $customer->id }}">{{ $customer->name }} </option>
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
                            <input id="defaultconfig" class="form-control modal_subtotal" readonly maxlength="39"
                                type="number">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Tax</label>
                            <select name="" id="" class="form-control modal_tax"
                                onchange="finalCalculate()">
                                <option value="0">0%</option>
                                <option value="5">5%</option>
                                <option value="7">7%</option>
                                <option value="15">15%</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Grand Total</label>
                            <input id="defaultconfig" class="form-control modal_grandtotal" maxlength="39" readonly
                                type="number">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Pay Amount</label>
                            <input id="defaultconfig" class="form-control modal_payamount" onkeyup="finalCalculate()"
                                maxlength="39" type="number">
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="name" class="form-label">Cash Back</label>
                            <input id="defaultconfig" class="form-control modal_cashback" readonly maxlength="39"
                                type="number">
                            <input type="hidden" class="modal_payment_method" value="1">
                            <input type="hidden" class="modal_sale_id">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary paid_queue"><i class="fa fa-print"></i>
                        Print</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const paid_queue = document.querySelector('.paid_queue');
        paid_queue.addEventListener('click', function(e) {
            e.preventDefault();
            const modal_tax = document.querySelector('.modal_tax').value;
            const modal_subtotal = document.querySelector('.modal_subtotal').value;
            const modal_payamount = document.querySelector('.modal_payamount').value;
            const modal_sale_id = document.querySelector('.modal_sale_id').value;
            const modal_payment_method = document.querySelector('.modal_payment_method').value;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/sale/pay',
                type: 'POST',
                data: {
                    modal_tax,
                    modal_subtotal,
                    modal_payamount,
                    modal_sale_id,
                    modal_payment_method,
                },
                success: function(res) {
                    // Assuming the response is in JSON format and contains the HTML
                    if (res && res.html) {
                        document.querySelector('.renderData').innerHTML = res.html;
                        showTableQueue();
                        posPrint(modal_sale_id);
                        $('#saleModal').modal('hide');

                    } else {
                        console.error('Invalid response format:', res);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', error);
                }
            });

        });

        function finalCalculate() {
            // Select elements
            const modal_subtotal = document.querySelector('.modal_subtotal');
            const modal_tax = document.querySelector('.modal_tax');
            const modal_grandtotal = document.querySelector('.modal_grandtotal');
            const modal_payamount = document.querySelector('.modal_payamount');
            const modal_cashback = document.querySelector('.modal_cashback');

            // Check if elements are found and parse their values
            const subtotalValue = modal_subtotal ? parseFloat(modal_subtotal.value) : 0;
            const taxValue = modal_tax ? parseInt(modal_tax.value) : 0;
            const payamountValue = modal_payamount ? parseFloat(modal_payamount.value) : 0;

            // Calculate tax and grand total
            const tax = (subtotalValue * taxValue) / 100;
            const grandtotal = subtotalValue + tax;

            // Calculate cash back
            const cashBack = grandtotal - payamountValue;

            // Set the calculated values to the respective elements
            if (modal_grandtotal) modal_grandtotal.value = grandtotal.toFixed(2);
            if (modal_cashback) modal_cashback.value = cashBack.toFixed(2);
        }

        showTableQueue();

        function showTableQueue() {
            $.ajax({
                url: '/show/queue',
                type: 'GET',
                success: function(res) {
                    let allQueueData = '';
                    $.each(res.sales, function(key, val) {
                        allQueueData += `<div class="col-md-3 mb-2">
                        <div class="card">
                            <div class="card-header d-flex" style="padding-bottom: 0px !important;justify-content:space-between">
                                <h6 class="card-title text-info text-center mt-1">Dine-1</h6>
                                <p class="card-title text-info text-center">Date: 04-06-2024</p>
                            </div>
                            <div class="card-body p-3 pt-0">
                            <table class="table">
                                <tr>
                                    <td style="text-align:right">Invoice No :</td>
                                    <td><a href="#" class="sale_details_btn" value="${val.id}">#${val.invoice_number} </a> <a href="#" class="sale_customize" value="${val.id}"><i style="font-size: 12px;border: 1px solid; padding: 4px; border-radius: 3px;" class="fa fa-pencil"></i></a></td>
                                </tr>
                                <tr>
                                    <td style="text-align:right">Items x ${val.quantity} :</td>
                                    <td>${val.total}</td>
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
                                    <button onclick="paidby_queue(this)" sale_id_queue="${val.id}" payments_method_queue="1" class="paidby_queue cashby_tablequeue {{ $mode->dark_mode == 1 ? 'mybtn_white' : 'mybtn_dark' }}"
                                        style="; max-width:48px;border-radius:10px; margin-top:5px" value="${val.final_receivable}">Cash</button>
                                    <button onclick="paidby_queue(this)" sale_id_queue="${val.id}"  value="${val.final_receivable}" payments_method_queue="2" class="paidby_queue {{ $mode->dark_mode == 1 ? 'mybtn_white' : 'mybtn_dark' }}"
                                        style="margin-left:5px; max-width:48px;border-radius:10px; margin-top:5px">bKash</button>
                                    <button onclick="paidby_queue(this)" sale_id_queue="${val.id}"  value="${val.final_receivable}" payments_method_queue="3" class="paidby_queue {{ $mode->dark_mode == 1 ? 'mybtn_white' : 'mybtn_dark' }}"
                                        style="margin-left:5px; max-width:48px;border-radius:10px; margin-top:5px">Nagad</button>
                                    <button onclick="paidby_queue(this)" sale_id_queue="${val.id}"  value="${val.final_receivable}" payments_method_queue="4" class="paidby_queue {{ $mode->dark_mode == 1 ? 'mybtn_white' : 'mybtn_dark' }}"
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
        $(document).on('click', '.sale_details_btn', function() {
            const sale_id = $(this).attr('value');
            $.ajax({
                url: '/details/sale/' + sale_id,
                type: 'GET',
                success: function(res) {
                    if (res && res.html) {
                        document.querySelector('.SaleDetails').innerHTML = res.html;
                        // Tab Active
                        const mytop__tab__controls = document.querySelectorAll('.mytop__tab__controls')
                        mytop__tab__controls.forEach((mytab) => {
                            mytab.classList.remove('active');
                        })
                        document.querySelector('.mytop__tab__last').classList.add('active');
                        const tap_page = document.querySelectorAll('.mytop__tab-page');
                        tap_page.forEach((tap) => {
                            tap.classList.remove('active');
                        })

                        document.querySelector(`.tap_page--4`).classList.add(
                            'active');
                        document.querySelector(`.tap_page--2`).classList.remove(
                            'active');

                    } else {
                        console.error('Invalid response format:', res);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', error);
                }
            });
        });

        function paidby_queue(element) {
            let value = element.value;
            let payment_method = element.getAttribute('payments_method_queue');
            let sale_id_queue = element.getAttribute('sale_id_queue');
            $('#saleModal').modal('show');
            document.querySelector('.modal_subtotal').value = value;
            document.querySelector('.modal_sale_id').value = sale_id_queue;
            document.querySelector('.modal_payment_method').value = payment_method;
            finalCalculate();
            $('#saleModal').on('shown.bs.modal', function() {
                document.querySelector('.modal_payamount').focus();
            });
        }

        const setmenu__div = document.querySelectorAll('.setmenu__div');
        setmenu__div.forEach(element => {
            element.addEventListener('click', function(e) {
                const set_menu_id = element.getAttribute('set_menu_id');
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
                    url: '/sale/store/setmenu',
                    type: 'POST',
                    data: {
                        set_menu_id,
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
                    event.preventDefault();
                    const sale_id = document.querySelector('.sale_id').value;
                    const item_id = this.getAttribute('value');
                    $.ajax({
                        url: '/sale/item/remove/' + sale_id + "/" + item_id,
                        type: 'GET',
                        success: function(data) {
                            if (data.status === 200) {
                                toastr.success(data.message);
                                document.querySelector('.renderData').innerHTML = data.html;
                                // showTableQueue();
                                attachEventListeners();
                                if (data.sale_items.length === 0) {
                                    disableDiv('controls');
                                }
                            }

                        }
                    });
                });
            });



        }
        attachEventListeners();
        disableDiv('controls')
        const btn_add_queu = document.querySelector('.btn_add_queu');
        btn_add_queu.addEventListener('click', function(event) {
            const select_dine = document.querySelector('.select_dine');
            const customer_id = document.querySelector('.customer_id').value;
            const sale_id = document.querySelector('.sale_id').value;
            const payment_method = document.querySelector('.payment_method').value;
            const sale_discount = document.querySelector('.sale_discount').value ?? 0;
            const tax = 1;
            const note = "Note dynamic korte hobe";
            if (select_dine.value === '') {
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
                    tax,
                    dine: select_dine.value
                },
                success: function(res) {

                    if (res && res.html) {
                        toastr.success('Order Queue Successfully Added');
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
            selectCustomer(customer_id)
        });

        function selectCustomer(customer_id) {
            $.ajax({
                url: 'select/customer/for-pos/' + customer_id,
                type: 'get',
                success: function(res) {
                    // toastr.success('Customer Successfully Added');
                    $('#customerModal').modal('hide');
                    document.querySelector('.customer_name').textContent = res.data.name;
                    let phoneoraddress;
                    if (res.data.phone !== null) {
                        phoneoraddress = res.data.phone
                    } else {
                        phoneoraddress = res.data.address
                    }
                    document.querySelector('.customer_address').textContent = phoneoraddress;
                    document.querySelector('.customer_total_receivable').textContent = res.data
                        .total_receivable;
                    document.querySelector('.customer_id').value = res.data.id;
                }
            });
        }
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
                        if (res.data.phone !== null) {
                            phoneoraddress = res.data.phone
                        } else {
                            phoneoraddress = res.data.address
                        }
                        document.querySelector('.customer_address').textContent = phoneoraddress;
                        document.querySelector('.customer_total_receivable').textContent = res.data
                            .total_receivable;
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
        });

        function posPrint(saleId) {
            $(document).ready(function() {
                var printFrame = $('#printFrame')[0];
                var printContentUrl =
                    '{{ url('/sale/print/') }}' + "/" + saleId;
                $('#printFrame').attr('src', printContentUrl);
                printFrame.onload = function() {
                    printFrame.contentWindow.focus();
                    printFrame.contentWindow.print();
                };
            });
        }
        $(document).on('click', '.sale_customize', function(event) {
            event.preventDefault();
            const sale_id = this.getAttribute('value');
            // alert(item_id);
            $.ajax({
                url: '/sale/customize/' + sale_id,
                type: 'GET',
                success: function(data) {
                    if (data.status === 200) {
                        enableDiv('controls');
                        document.querySelector('.renderData').innerHTML = data.html;
                        document.querySelector('.sale_id').value = document.querySelector(
                            '.render_sale_id').value;
                        document.querySelector('.select_dine').value = data.sale.dine_id;
                        document.querySelector('.sale_discount ').value = data.sale.discount;
                        // Re-attach event listeners to the newly added elements
                        attachEventListeners();
                        document.querySelector('.btn_update_queu').style.display = 'block';
                        document.querySelector('.btn_add_queu').style.display = 'none';
                        selectCustomer(data.sale.customer_id);

                        // Tab Active
                        const mytop__tab__controls = document.querySelectorAll('.mytop__tab__controls')
                        mytop__tab__controls.forEach((mytab) => {
                            mytab.classList.remove('active');
                        })
                        document.querySelector('.mytop__tab__first').classList.add('active');
                        const tap_page = document.querySelectorAll('.mytop__tab-page');
                        tap_page.forEach((tap) => {
                            tap.classList.remove('active');
                        })

                        document.querySelector(`.tap_page--1`).classList.add(
                            'active');
                        document.querySelector(`.tap_page--2`).classList.remove(
                            'active');
                    }

                }
            });
        });
        const btn_update_queu = document.querySelector('.btn_update_queu');
        btn_update_queu.addEventListener('click', function(event) {
            const sale_id = document.querySelector('.sale_id').value;
            const customer_id = document.querySelector('.customer_id').value;
            const sale_discount = document.querySelector('.sale_discount').value;
            const select_dine = document.querySelector('.select_dine');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/update/sale/custom',
                type: 'POST',
                data: {
                    customer_id,
                    sale_id,
                    sale_discount,
                    dine: select_dine.value
                },
                success: function(res) {

                    if (res && res.html) {
                        toastr.success('Order Queue Successfully Updated');
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
                        document.querySelector('.btn_update_queu').style.display = 'none';
                        document.querySelector('.btn_add_queu').style.display = 'block';
                    } else {
                        console.error('Invalid response format:', res);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', error);
                }
            });
        });
        const mytop__tab__controls = document.querySelectorAll('.mytop__tab__controls');
        mytop__tab__controls.forEach((mytab) => {
            mytab.addEventListener('click', () => {
                mytop__tab__controls.forEach((mytab) => {
                    mytab.classList.remove('active');
                })
                mytab.classList.add('active');
                const tap_page = document.querySelectorAll('.mytop__tab-page');
                tap_page.forEach((tap) => {
                    tap.classList.remove('active');
                })
                document.querySelector(`.tap_page--${mytab.getAttribute('tab__index')}`).classList.add(
                    'active');
            })
        })
        const menu__tab__control = document.querySelectorAll('.menu__tab__control');
        menu__tab__control.forEach((menuTab) => {
            menuTab.addEventListener('click', () => {
                // alert("OK")
                menu__tab__control.forEach((menuTab) => {
                    menuTab.classList.remove('menu__active');
                });
                menuTab.classList.add('menu__active');
                const menu__tab__pag = document.querySelectorAll('.menu__tab__pag');
                menu__tab__pag.forEach((menuTabPag) => {
                    menuTabPag.classList.remove('menu__active');
                });
                const menu__tab__pag__index = menuTab.getAttribute('menu__tab__index');
                document.querySelector(`.menu__tab__pag--${menu__tab__pag__index}`).classList.add(
                    'menu__active');
            })
        })
    </script>
@endsection
