@extends('master')
@section('title','| Today Report')
@section('admin')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Daily Report</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12   grid-margin stretch-card filter_box">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <div class="input-group flatpickr" id="flatpickr-date">
                                <input type="text" class="form-control from-date flatpickr-input start-date"
                                    placeholder="Start date" data-input="" readonly="readonly">
                                <span class="input-group-text input-group-addon" data-toggle=""><svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-calendar">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2">
                                        </rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group flatpickr" id="flatpickr-date">
                                <input type="text" class="form-control from-date flatpickr-input end-date"
                                    placeholder="End date" data-input="" readonly="readonly">
                                <span class="input-group-text input-group-addon" data-toggle=""><svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-calendar">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2">
                                        </rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg></span>
                            </div>
                        </div>
                        @php
                            $products = App\Models\Product::all();
                            $customers = App\Models\Customer::all();
                        @endphp
                        <div class="col-md-3">
                            <div class="input-group flatpickr" id="flatpickr-date">
                                <select class="js-example-basic-single form-select product_select" data-width="100%">
                                    @if ($products->count() > 0)
                                        <option selected disabled>Select Product</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    @else
                                        <option selected disabled>Please Add Product</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group flatpickr" id="flatpickr-date">
                                <select class="js-example-basic-single form-select select-supplier customer_id"
                                    data-width="100%" name="">
                                    @if ($customers->count() > 0)
                                        <option selected disabled>Select Customer</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @endforeach
                                    @else
                                        <option selected disabled>Please Add Customer</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="justify-content-left">
                                <button class="btn btn-sm bg-info text-dark mr-2" id="filter">Filter</button>
                                <button class="btn btn-sm bg-primary text-dark" id="reset">Reset</button>
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <div class="flex text-md-end ">
                                <button type="button"
                                    class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0 print-btn">
                                    <i class="btn-icon-prepend" data-feather="printer"></i>
                                    Print
                                </button>
                                {{-- <button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                                    <i class="btn-icon-prepend" data-feather="download-cloud"></i>
                                    Download Report
                                </button> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow-1">
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Sale Amount</h6>
                                <div class="dropdown mb-2">
                                    <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                                data-feather="eye" class="icon-sm me-2"></i> <span
                                                class="">View</span></a>
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                                data-feather="edit-2" class="icon-sm me-2"></i> <span
                                                class="">Edit</span></a>
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                                data-feather="trash" class="icon-sm me-2"></i> <span
                                                class="">Delete</span></a>
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                                data-feather="printer" class="icon-sm me-2"></i> <span
                                                class="">Print</span></a>
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                                data-feather="download" class="icon-sm me-2"></i> <span
                                                class="">Download</span></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="mb-2">
                                        ৳ {{ $todayInvoiceAmount }}
                                    </h3>
                                    <div class="d-flex align-items-baseline">
                                        <p class="text-success">
                                            <span>+3.3%</span>
                                            <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Purchase Cost</h6>
                                <div class="dropdown mb-2">
                                    <a type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                                data-feather="eye" class="icon-sm me-2"></i> <span
                                                class="">View</span></a>
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                                data-feather="edit-2" class="icon-sm me-2"></i> <span
                                                class="">Edit</span></a>
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                                data-feather="trash" class="icon-sm me-2"></i> <span
                                                class="">Delete</span></a>
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                                data-feather="printer" class="icon-sm me-2"></i> <span
                                                class="">Print</span></a>
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                                data-feather="download" class="icon-sm me-2"></i> <span
                                                class="">Download</span></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="mb-2">
                                        ৳ {{ $today_grand_total }}
                                    </h3>
                                    <div class="d-flex align-items-baseline">
                                        <p class="text-danger">
                                            <span>-2.8%</span>
                                            <i data-feather="arrow-down" class="icon-sm mb-1"></i>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">EXPENSE</h6>
                                <div class="dropdown mb-2">
                                    <a type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                                data-feather="eye" class="icon-sm me-2"></i> <span
                                                class="">View</span></a>
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                                data-feather="edit-2" class="icon-sm me-2"></i> <span
                                                class="">Edit</span></a>
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                                data-feather="trash" class="icon-sm me-2"></i> <span
                                                class="">Delete</span></a>
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                                data-feather="printer" class="icon-sm me-2"></i> <span
                                                class="">Print</span></a>
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                                data-feather="download" class="icon-sm me-2"></i> <span
                                                class="">Download</span></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="mb-2">
                                        ৳ {{ $todayExpenseAmount }}
                                    </h3>
                                    <div class="d-flex align-items-baseline">
                                        <p class="text-success">
                                            <span>+2.8%</span>
                                            <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Salary Sheet</h6>
                                <div class="dropdown mb-2">
                                    <a type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                                data-feather="eye" class="icon-sm me-2"></i> <span
                                                class="">View</span></a>
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                                data-feather="edit-2" class="icon-sm me-2"></i> <span
                                                class="">Edit</span></a>
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                                data-feather="trash" class="icon-sm me-2"></i> <span
                                                class="">Delete</span></a>
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                                data-feather="printer" class="icon-sm me-2"></i> <span
                                                class="">Print</span></a>
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                                data-feather="download" class="icon-sm me-2"></i> <span
                                                class="">Download</span></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="mb-2">
                                        ৳ {{ $totalSalary }}
                                    </h3>
                                    <div class="d-flex align-items-baseline">
                                        <p class="text-success">
                                            <span>+2.8%</span>
                                            <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow-1">

            </div>
        </div>
    </div> --}}



    <div class="row">

        {{-- today sale Report  --}}
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title text-info">Today Sale Report</h6>

                    <div id="" class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>SN#</th>
                                    <th>Invoice No.</th>
                                    <th>Product Name</th>
                                    <th>Qty</th>
                                    <th>Due</th>
                                    <th>Sale Amount</th>
                                </tr>
                            </thead>
                            <tbody class="showData">
                                @if ($totalSales->count() > 0)
                                    @foreach ($totalSales as $key => $sale)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <a
                                                    href="{{ route('sale.invoice', $sale->id) }}">#{{ $sale->invoice_number ?? 0 }}</a>
                                            </td>
                                            <td>
                                                <ul>
                                                    @foreach ($sale->saleItem as $item)
                                                        <li>{{ $item->product->name ?? '' }}
                                                            <br>({{ $item->product->barcode ?? '' }})
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>
                                                {{ $sale->quantity ?? 0 }}
                                            </td>
                                            <td>
                                                {{ $sale->due ?? 0 }}
                                            </td>
                                            <td>
                                                {{ $sale->receivable ?? 0 }}
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
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Qty : {{ $todayTotalSaleQty ?? 0 }}</th>
                                    <th>Total : {{ $todayTotalSaleDue ?? 0 }}Tk</th>
                                    <th>Total : {{ $todayTotalSaleAmount ?? 0 }}Tk</th>
                                </tr>
                            </tfoot>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        {{-- today Expanse Report  --}}
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title text-info">Expense Report</h6>

                    <div id="" class="table-responsive">
                        <table id="dataTableExample2" class="table">
                            <thead>
                                <tr>
                                    <th>SN#</th>
                                    <th>Expense Purpose</th>
                                    <th>Category</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody class="showData">
                                {{-- @dd($expense); --}}
                                @if ($expense->count() > 0)
                                    {{-- @dd($expense); --}}
                                    @php
                                        $num = 0;
                                    @endphp
                                    <?php
                                    $totalAmount = 0;
                                    ?>
                                    @foreach ($expense as $key => $expenseData)
                                        <tr>
                                            <td>{{ $num++ }}</td>
                                            <td>{{ $expenseData->purpose ?? '' }}</td>
                                            <td>{{ $expenseData['expenseCat']['name'] ?? '' }}</td>
                                            <td>{{ $expenseData->amount ?? '' }}</td>
                                            <?php $totalAmount += isset($expenseData->amount) ? $expenseData->amount : 0; ?>
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
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><strong>Total : {{ $totalAmount ?? 0 }} Tk</strong></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">

        {{-- today Purchase Report  --}}
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title text-info">Today Purchase Report</h6>

                    <div id="" class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>SN#</th>
                                    <th>Invoice No.</th>
                                    <th>Product Name</th>
                                    <th>Qty</th>
                                    <th>Due</th>
                                    <th>Purchase Amount</th>
                                </tr>
                            </thead>
                            <tbody class="showData">
                                @if ($purchases->count() > 0)
                                    {{-- @dd($purchases); --}}
                                    @foreach ($purchases as $key => $purchase)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <a
                                                    href="{{ route('purchase.invoice', $purchase->id) }}">#{{ $purchase->id ?? 0 }}</a>
                                            </td>
                                            <td>
                                                <ul>
                                                    @foreach ($purchase->purchaseItem as $item)
                                                        <li>{{ $item->product->name ?? '' }}
                                                            <br>({{ $item->product->barcode ?? '' }})
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>
                                                {{ $purchase->total_quantity ?? 0 }}
                                            </td>
                                            <td>
                                                {{ $purchase->due ?? 0 }}
                                            </td>
                                            <td>
                                                {{ $purchase->grand_total ?? 0 }}
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
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Qty : {{ $todayTotalPurchaseQty ?? 0 }}</th>
                                    <th>Total : {{ $todayTotalPurchaseDue ?? 0 }}Tk</th>
                                    <th>Total : {{ $todayTotalPurchaseAmount ?? 0 }}Tk</th>
                                </tr>
                            </tfoot>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        {{-- today Expanse Report  --}}
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title text-info">Today Salary Report</h6>

                    <div id="" class="table-responsive">
                        <table id="dataTableExample2" class="table">
                            <thead>
                                <tr>
                                    <th>SN#</th>
                                    <th>Employee Name</th>
                                    <th>Amount</th>
                                    <th>Due</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if ($salary->count() > 0)
                                    @foreach ($salary as $key => $data)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $data->emplyee->full_name ?? '' }}</td>
                                            <td>{{ $data->debit ?? 0 }}</td>
                                            <td>{{ $data->balance ?? 0 }}</td>
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
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th><strong>Total Amount : {{ $totalSalary ?? 0 }} Tk</strong></th>
                                    <th><strong>Total Due : {{ $totalSalaryDue ?? 0 }} Tk</strong></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
