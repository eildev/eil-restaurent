@extends('master')
@section('title', '| Dashboard')
@section('admin')
    {{-- <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Welcome to Dashboard</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <div class="input-group flatpickr wd-200 me-2 mb-2 mb-md-0" id="dashboardDate">
                <span class="input-group-text input-group-addon bg-transparent border-primary" data-toggle><i
                        data-feather="calendar" class="text-primary"></i></span>
                <input type="text" class="form-control bg-transparent border-primary" placeholder="Select date" data-input>
            </div>
            <button type="button" class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
                <i class="btn-icon-prepend" data-feather="printer"></i>
                Print
            </button>
            <button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                <i class="btn-icon-prepend" data-feather="download-cloud"></i>
                Download Report
            </button>
        </div>
    </div> --}}
    @php
        ///////////////////Total Summary////////////////
        $totalInvoice = App\Models\Sale::all();
        //total invoice product
        $totalInvoiceProductTotal = $totalInvoice->sum('quantity');
        $totalInvoiceProductAmount = $totalInvoice->sum('final_receivable');
        //total expenses
        $totalExpense = App\Models\Expense::all();
        $totalExpenseAmount = $totalExpense->sum('amount');
        //total Customer
        $totalCustomer = App\Models\Customer::all();
        //sale profit
        $totalSaleProfit = $totalInvoice->sum('profit');
        $saleItems = App\Models\SaleItem::all();
        $totalSaleItems = $saleItems->sum('qty');
        $totalPurchase = App\Models\Purchase::all();
        $purchaseItems = App\Models\PurchaseItem::all();
        $totalPurchaseItems = $purchaseItems->sum('quantity');
        $totalInvoiceAmount = $totalInvoice->sum('receivable');
        $totalPay = $totalInvoice->sum('paid');
        $profit = $totalInvoice->sum('profit');

        /////////////////today report/////////////////
        $todayDate = now()->toDateString();
        //Today Invoice
        $saleItemsForDate = App\Models\SaleItem::whereDate('created_at', $todayDate);
        $todaySaleItemsToday = $saleItemsForDate->sum('qty');
        $totalInvoiceToday = App\Models\Sale::whereDate('sale_date', $todayDate)->count();

        //Today Purchase
        $todayPurchaseItems = App\Models\PurchaseItem::whereDate('created_at', $todayDate);
        $todayPurchase = App\Models\Purchase::whereDate('created_at', $todayDate);
        $todayPurchaseItemsToday = $todayPurchaseItems->sum('quantity');
        // dd($todayPurchaseItems->sum('grand_total'));
        $todayPurchaseAmont = $todayPurchase->sum('grand_total');
        $todayPurchaseToday = App\Models\Purchase::whereDate('purchse_date', $todayDate)->count();
        //Today invoice product
        $todayInvoiceProductItems = App\Models\Sale::whereDate('sale_date', $todayDate);
        $todayInvoiceProductTotal = $todayInvoiceProductItems->sum('quantity');
        $todayInvoiceProductAmount = $todayInvoiceProductItems->sum('final_receivable');
        //today invoice amount
        $totalInvoiceTodaySum = App\Models\Sale::whereDate('sale_date', $todayDate);
        $todayInvoiceAmount = $totalInvoiceTodaySum->sum('receivable');
        $todayProfit = $totalInvoiceTodaySum->sum('profit');
        //today expenses
        $todayExpenseDate = App\Models\Expense::whereDate('expense_date', $todayDate);
        $todayExpenseAmount = $todayExpenseDate->sum('amount');
        //Today Customer
        $todayCustomer = App\Models\Customer::whereDate('created_at', $todayDate);
        //Sale Profit
        $saleProfitAmount = $totalInvoiceTodaySum->sum('profit');
        //////////////////Current Month Summary///////////////
        $Year = now()->year;
        $month = now()->month;
        $currentMonth = now()->format('F');
        // Month  Invoice
        $saleItemsForMonth = App\Models\SaleItem::whereYear('created_at', $Year)->whereMonth('created_at', $month);
        $todaySaleItemsMonth = $saleItemsForMonth->sum('qty');
        $totalInvoiceMonth = App\Models\Sale::whereYear('sale_date', $Year)->whereMonth('sale_date', $month)->count();
        $totalInvoiceMonthSum = App\Models\Sale::whereYear('sale_date', $Year)->whereMonth('sale_date', $month);
        //Month Purchase
        $MonthPurchaseItems = App\Models\PurchaseItem::whereYear('created_at', $Year)->whereMonth('created_at', $month);
        $MonthPurchaseItemsToday = $MonthPurchaseItems->sum('quantity');
        $MonthPurchaseToday = App\Models\Purchase::whereYear('purchse_date', $Year)
            ->whereMonth('purchse_date', $month)
            ->count();
        //Month invoice product
        $monthInvoiceProductItems = App\Models\Sale::whereYear('sale_date', $Year)->whereMonth('sale_date', $month);
        $monthInvoiceProductTotal = $monthInvoiceProductItems->sum('quantity');
        $monthInvoiceProductAmount = $monthInvoiceProductItems->sum('final_receivable');
        //Month Invoice amount
        $monthInvoiceAmount = $totalInvoiceMonthSum->sum('receivable');
        $monthProfit = $totalInvoiceMonthSum->sum('profit');
        //Mont expenses
        $monthExpenseDate = App\Models\Expense::whereYear('expense_date', $Year)->whereMonth('expense_date', $month);
        $monthExpenseAmount = $monthExpenseDate->sum('amount');
        //Month Customer
        $monthCustomer = App\Models\Customer::whereYear('created_at', $Year)->whereMonth('created_at', $month);
        //Month Sale Profit
        $monthSaleProfitAmount = $totalInvoiceMonthSum->sum('profit');

        $salesByDayCount = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $salesCount = App\Models\Sale::whereDate('sale_date', $date)->count();
            $salesByDayCount[$date] = $salesCount;
        }

        $salesByDay = [];
        $salesProfitByDay = [];
        $purchaseByDay = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $dailySales = App\Models\Sale::whereDate('sale_date', $date)->sum('receivable');
            $dailyProfit = App\Models\Sale::whereDate('sale_date', $date)->sum('profit');
            $dailyPurchase = App\Models\Purchase::whereDate('purchse_date', $date)->sum('grand_total');

            $salesByDay[$date] = $dailySales;
            $salesProfitByDay[$date] = $dailyProfit;
            $purchaseByDay[$date] = $dailyPurchase;
        }

        // Fetching the latest 5 bank records
        $banks = App\Models\Bank::take(5)->get();

        // Array to store total transaction amounts for each bank
        $totalTransactionAmounts = [];

        // Loop through each bank to calculate total transaction amount
        foreach ($banks as $bank) {
            $totalTransactionAmount = App\Models\AccountTransaction::where('account_id', $bank->id)
                ->where('balance', '>', 0)
                ->sum('balance');
            // array_push(floatval($totalTransactionAmounts), floatval($totalTransactionAmount));
            array_push($totalTransactionAmounts, floatval($totalTransactionAmount));
        }
        // dd($totalTransactionAmounts);
        $tt = 0;
        $ttt = [];
        foreach ($totalTransactionAmounts as $item) {
            if ($item > 0) {
                $tt += $item;
            }
        }
        foreach ($totalTransactionAmounts as $item) {
            if ($item > 0) {
                $ot = ($item * 100) / $tt;
                $formatted_ot = number_format($ot, 2, '.', '');
                array_push($ttt, floatval($formatted_ot));
            }
        }
        // dd($ttt, $totalTransactionAmounts);

        // monthly report
        use Carbon\Carbon;

        // Initialize arrays to store monthly data
        $salesByMonth = [];
        $profitsByMonth = [];
        $purchasesByMonth = [];

        for ($i = 0; $i < 12; $i++) {
            $monthStart = now()->subMonths($i)->startOfMonth();
            $monthEnd = now()->subMonths($i)->endOfMonth();

            $monthlySales = App\Models\Sale::whereBetween('sale_date', [$monthStart, $monthEnd])->sum('receivable');
            $monthlyProfit = App\Models\Sale::whereBetween('sale_date', [$monthStart, $monthEnd])->sum('profit');
            $monthlyPurchase = App\Models\Purchase::whereBetween('purchse_date', [$monthStart, $monthEnd])->sum(
                'grand_total',
            );

            $salesByMonth[$monthStart->format('Y-m')] = $monthlySales;
            $profitsByMonth[$monthStart->format('Y-m')] = $monthlyProfit;
            $purchasesByMonth[$monthStart->format('Y-m')] = $monthlyPurchase;
        }

        // Reverse the arrays to get the data in chronological order
        $salesByMonth = array_reverse($salesByMonth, true);
        $profitsByMonth = array_reverse($profitsByMonth, true);
        $purchasesByMonth = array_reverse($purchasesByMonth, true);
    @endphp




    {{-- ///////Today Summary ////// --}}
    <div class="row">
        <div class="col-12 col-xl-12 stretch-card">

            <div class="row flex-grow-1">
                <h3 class="mb-3">Today Summary</h3>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card" style="">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                {{-- <h6 class="card-title mb-0">Invoice</h6> --}}
                            </div>
                            <div class="row">

                                <div class=" col-md-4">
                                    <img src="uploads/dashboard/Artboard4@300x-100.jpg" height="50px" width="50px" alt="Image" style="border-radius:5px">
                                </div>
                                <div class="col-md-8">
                                    {{-- <h3 class="mb-2"> {{ $totalInvoiceToday }}

                                        <span style="font-size: 15px;">
                                        (৳ {{ $saleProfitAmount }})</span>
                                </h3> --}}
                                <h3>{{ $saleProfitAmount }}</h3>
                                <h6 class="mb-0">Profit</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card" style="">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                {{-- <h6 class="card-title mb-0">Purchase</h6> --}}

                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="uploads/dashboard/Artboard3@300x-100.jpg" height="50px" width="50px" alt="Image" style="border-radius:5px">
                                </div>
                                <div class="col-md-8 ">
                                    {{-- <h3 class="mb-2">{{ $todayPurchaseToday }}<span style="font-size: 15px;">
                                            (৳ {{ $todayExpenseAmount }})</span></h3> --}}
                                            <h3>{{ $todayExpenseAmount }}</h3>
                                 <h6 class=" mb-0">Expense</h6>
                                 {{-- <h6 class=" mb-0">Total Purchase</h6> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card" style="">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                {{-- <h6 class="card-title mb-0">invoice product</h6> --}}
                            </div>
                            <div class="row">
                                <div class=" col-md-4">
                                    <img src="uploads/dashboard/Artboard1@300x-100.jpg" height="50px" width="50px" alt="Image" style="border-radius:5px">
                                </div>
                                <div class="col-md-8">
                                    {{-- <h3 class="mb-2">{{ $todayInvoiceProductTotal }} <span
                                            style="font-size: 15px;">( ৳
                                            {{ $todayInvoiceProductAmount }})</span></h3> --}}
                                            <h3>{{ $todayInvoiceProductAmount }}</h3>
                                            <h6 class=" mb-0">Invoice</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card" style="">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                {{-- <h6 class="card-title mb-0">invoice amount</h6> --}}
                            </div>
                            <div class="row">
                                <div class=" col-md-4">
                                    <img src="uploads/dashboard/Artboard5@300x-100.jpg" height="50px" width="50px" alt="Image" style="border-radius:5px">
                                </div>
                                <div class="col-md-8">
                                    {{-- <h3 class="mb-2"> ৳ {{ $todayInvoiceAmount }}<span
                                            style="font-size: 15px;"> (৳ {{ $todayProfit }})</span></h3> --}}
                                            <h3>{{$todayPurchaseAmont }}</h3>
                                    <h6 class=" mb-0">Purchase</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-3 grid-margin stretch-card">
                    <div class="card" style="">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Expenses</h6>
                                <div class="dropdown mb-2">
                                    <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                                data-feather="eye" class="icon-sm me-2"></i> <span
                                                class="">View</span></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-12 col-xl-12">
                                    <h3 class="mb-2"> ৳ {{ $todayExpenseAmount }}<span
                                            style="font-size: 15px; color:white"></span></h3>
                                    <div class="d-flex align-items-baseline">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                {{-- <div class="col-md-3 grid-margin stretch-card">
                    <div class="card" style="">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0"> customer</h6>
                                <div class="dropdown mb-2">
                                    <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                                data-feather="eye" class="icon-sm me-2"></i> <span
                                                class="">View</span></a>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-12 col-xl-12">
                                    <h3 class="mb-2">{{ $todayCustomer->count() }}</h3>
                                    <div class="d-flex align-items-baseline">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                {{-- <div class="col-md-3 grid-margin stretch-card">
                    <div class="card" style="">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Sale Profit</h6>
                                <div class="dropdown mb-2">
                                    <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                                data-feather="eye" class="icon-sm me-2"></i> <span
                                                class="">View</span></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-12 col-xl-12">
                                    <h3 class="mb-2"> ৳ {{ $saleProfitAmount }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>

    </div> <!-- row -->
    {{-- //////End Today /////// --}}


    {{-- //////Revenew Chart Start /////// --}}
    <div class="row">
        <div class="col-xl-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Weekly Profit</h6>
                    <div id="apexLine1"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Daily Sales</h6>
                    <div id="apexBar1"></div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var colors = {
                primary: "#6571ff",
                secondary: "#7987a1",
                success: "#05a34a",
                info: "#66d1d1",
                warning: "#fbbc06",
                danger: "#ff3366",
                light: "#e9ecef",
                dark: "#060c17",
                muted: "#7987a1",
                gridBorder: "rgba(77, 138, 240, .15)",
                bodyColor: "#b8c3d9",
                cardBg: "#0c1427"
            }

            var fontFamily = "'Roboto', Helvetica, sans-serif"
            // Apex Bar chart start
            var options = {
                chart: {
                    type: 'bar',
                    height: '320',
                    parentHeightOffset: 0,
                    foreColor: colors.bodyColor,
                    background: colors.cardBg,
                    toolbar: {
                        show: false
                    },
                },
                theme: {
                    mode: 'dark'
                },
                tooltip: {
                    theme: 'dark'
                },
                colors: [colors.primary],
                grid: {
                    padding: {
                        bottom: -4
                    },
                    borderColor: colors.gridBorder,
                    xaxis: {
                        lines: {
                            show: true
                        }
                    }
                },
                series: [{
                    name: 'sales',
                    data: [
                        @foreach ($salesByDay as $date => $salesCount)
                            {{ $salesCount }},
                        @endforeach
                    ]
                }],
                xaxis: {
                    type: 'datetime',
                    categories: [
                        @foreach ($salesByDayCount as $date => $salesCount)
                            '{{ $date }}',
                        @endforeach
                    ],
                    axisBorder: {
                        color: colors.gridBorder,
                    },
                    axisTicks: {
                        color: colors.gridBorder,
                    },
                },
                legend: {
                    show: true,
                    position: "top",
                    horizontalAlign: 'center',
                    fontFamily: fontFamily,
                    itemMargin: {
                        horizontal: 8,
                        vertical: 0
                    },
                },
                stroke: {
                    width: 0
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4
                    }
                }
            }

            var apexBarChart = new ApexCharts(document.querySelector("#apexBar1"), options);
            apexBarChart.render();

            // Apex Bar chart end



            var lineChartOptions = {
                chart: {
                    type: "line",
                    height: '320',
                    parentHeightOffset: 0,
                    foreColor: colors.bodyColor,
                    background: colors.cardBg,
                    toolbar: {
                        show: false
                    },
                },
                theme: {
                    mode: 'dark'
                },
                tooltip: {
                    theme: 'dark'
                },
                colors: [colors.primary, colors.danger, colors.warning],
                grid: {
                    padding: {
                        bottom: -4
                    },
                    borderColor: colors.gridBorder,
                    xaxis: {
                        lines: {
                            show: true
                        }
                    }
                },
                series: [{
                        name: "Weekly Sale",
                        data: [
                            @foreach ($salesByDay as $date => $dailySales)
                                {{ $dailySales }},
                            @endforeach
                        ]
                    },
                    {
                        name: "Weekly Profit",
                        data: [
                            @foreach ($salesProfitByDay as $date => $dailyProfit)
                                {{ $dailyProfit }},
                            @endforeach
                        ]
                    },
                    {
                        name: "Weekly Purchase",
                        data: [
                            @foreach ($purchaseByDay as $date => $dailyPurchase)
                                {{ $dailyPurchase }},
                            @endforeach
                        ]
                    }
                ],
                xaxis: {
                    type: "datetime",
                    categories: [
                        @foreach ($salesByDay as $date => $salesCount)
                            '{{ $date }}',
                        @endforeach
                    ],
                    lines: {
                        show: true
                    },
                    axisBorder: {
                        color: colors.gridBorder,
                    },
                    axisTicks: {
                        color: colors.gridBorder,
                    },
                },
                markers: {
                    size: 0,
                },
                legend: {
                    show: true,
                    position: "top",
                    horizontalAlign: 'center',
                    fontFamily: fontFamily,
                    itemMargin: {
                        horizontal: 8,
                        vertical: 0
                    },
                },
                stroke: {
                    width: 3,
                    curve: "smooth",
                    lineCap: "round"
                },
            };
            var apexLineChart = new ApexCharts(document.querySelector("#apexLine1"), lineChartOptions);
            apexLineChart.render();
        });
    </script>
    {{-- //////Revenew Chart Start /////// --}}





    {{-- /////Current Month Summary/// --}}
    {{-- <div class="row">
        <div class="col-12 col-xl-12 stretch-card">

            <div class="row flex-grow-1">
                <h3 class="my-3">Current Month Summary</h3>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Invoice In {{ $currentMonth }} {{ $Year }}</h6>
                                <div class="dropdown mb-2">
                                    <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                                data-feather="eye" class="icon-sm me-2"></i> <span
                                                class="">View</span></a>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-12 col-xl-12">
                                    <h3 class="mb-2">{{ $totalInvoiceMonth }}<span
                                            style="font-size: 15px; color:#6571ff"> ({{ $todaySaleItemsMonth }})</span>
                                    </h3>
                                    <div class="d-flex align-items-baseline">

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
                                <h6 class="card-title mb-0">Purchase In {{ $currentMonth }} {{ $Year }}</h6>
                                <div class="dropdown mb-2">
                                    <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                                data-feather="eye" class="icon-sm me-2"></i> <span
                                                class="">View</span></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-12 col-xl-12">
                                    <h3 class="mb-2">{{ $MonthPurchaseToday }}<span
                                            style="font-size: 15px; color:#6571ff">
                                            ({{ $MonthPurchaseItemsToday }})</span></h3>
                                    <div class="d-flex align-items-baseline">

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
                                <h6 class="card-title mb-0">Invoice product In {{ $currentMonth }} {{ $Year }}
                                </h6>
                                <div class="dropdown mb-2">
                                    <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                                data-feather="eye" class="icon-sm me-2"></i> <span
                                                class="">View</span></a>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-12 col-xl-12">
                                    <h3 class="mb-2">{{ $monthInvoiceProductTotal }} <span
                                            style="font-size: 15px; color:#6571ff">( ৳
                                            {{ $monthInvoiceProductAmount }})</span></h3>
                                    <div class="d-flex align-items-baseline">

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
                                <h6 class="card-title mb-0">Invoice amount In {{ $currentMonth }} {{ $Year }}
                                </h6>
                                <div class="dropdown mb-2">
                                    <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                                data-feather="eye" class="icon-sm me-2"></i> <span
                                                class="">View</span></a>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-12 col-xl-12">
                                    <h3 class="mb-2"> ৳{{ $monthInvoiceAmount }}<span
                                            style="font-size: 15px; color:#6571ff"> ( ৳{{ $monthProfit }})</span></h3>
                                    <div class="d-flex align-items-baseline">

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
                                <h6 class="card-title mb-0">Expenses In {{ $currentMonth }} {{ $Year }}</h6>
                                <div class="dropdown mb-2">
                                    <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                                data-feather="eye" class="icon-sm me-2"></i> <span
                                                class="">View</span></a>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-12 col-xl-12">
                                    <h3 class="mb-2"> ৳ {{ $monthExpenseAmount }}<span
                                            style="font-size: 15px; color:#6571ff"></span></h3>
                                    <div class="d-flex align-items-baseline">

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
                                <h6 class="card-title mb-0">Customer In {{ $currentMonth }} {{ $Year }}</h6>
                                <div class="dropdown mb-2">
                                    <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                                data-feather="eye" class="icon-sm me-2"></i> <span
                                                class="">View</span></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-12 col-xl-12">
                                    <h3 class="mb-2">{{ $monthCustomer->count() }}</h3>
                                    <div class="d-flex align-items-baseline">

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
                                <h6 class="card-title mb-0">Sale profit In {{ $currentMonth }} {{ $Year }}</h6>
                                <div class="dropdown mb-2">
                                    <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                                data-feather="eye" class="icon-sm me-2"></i> <span
                                                class="">View</span></a>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-12 col-xl-12">
                                    <h3 class="mb-2"> ৳ {{ $monthSaleProfitAmount }}</h3>
                                    <div class="d-flex align-items-baseline">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- row --> --}}
    {{-- /////EndCurrent Month Summary/// --}}


    {{-- /// pie chart start /// --}}
    <div class="row">
        <div class="col-xl-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Total Trnasaction</h6>
                    <div id="apexPie1"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Banking Details</h6>
                    <div id="apexRadialBar1"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var colors = {
                primary: "#6571ff",
                secondary: "#7987a1",
                success: "#05a34a",
                info: "#66d1d1",
                warning: "#fbbc06",
                danger: "#ff3366",
                light: "#e9ecef",
                dark: "#060c17",
                muted: "#7987a1",
                gridBorder: "rgba(77, 138, 240, .15)",
                bodyColor: "#b8c3d9",
                cardBg: "#0c1427"
            }

            var fontFamily = "'Roboto', Helvetica, sans-serif"

            var options = {
                chart: {
                    height: 300,
                    type: "pie",
                    foreColor: colors.bodyColor,
                    background: colors.cardBg,
                    toolbar: {
                        show: false
                    },
                },
                theme: {
                    mode: 'dark'
                },
                tooltip: {
                    theme: 'dark'
                },
                colors: [colors.primary, colors.warning, colors.danger, colors.info, colors.success],
                legend: {
                    show: true,
                    position: "top",
                    horizontalAlign: 'center',
                    fontFamily: fontFamily,
                    itemMargin: {
                        horizontal: 8,
                        vertical: 0
                    },
                },
                stroke: {
                    colors: ['rgba(0,0,0,0)']
                },
                dataLabels: {
                    enabled: false
                },
                series: [
                    @foreach ($totalTransactionAmounts as $element)
                        {{ $element }},
                    @endforeach
                ],
                labels: [
                    @foreach ($banks as $bank)
                        '{{ $bank->name }}',
                    @endforeach
                ],
            };

            var chart = new ApexCharts(document.querySelector("#apexPie1"), options);
            chart.render();


            var options = {
                chart: {
                    height: 300,
                    type: "radialBar",
                    parentHeightOffset: 0,
                    foreColor: colors.bodyColor,
                    background: colors.cardBg,
                    toolbar: {
                        show: false
                    },
                },
                theme: {
                    mode: 'dark'
                },
                tooltip: {
                    theme: 'dark'
                },
                colors: [colors.primary, colors.warning, colors.danger, colors.info, colors.success],
                fill: {

                },
                grid: {
                    padding: {
                        top: 10
                    }
                },
                plotOptions: {
                    radialBar: {
                        dataLabels: {
                            total: {
                                show: true,
                                label: 'TOTAL',
                                fontSize: '14px',
                                fontFamily: fontFamily,
                                formatter: function(w) {
                                    return (w.globals.seriesTotals.reduce((a, b) => a + b, 0) / w.globals
                                        .series.length).toFixed(2) + '%';
                                }
                            }
                        },
                        track: {
                            background: colors.gridBorder,
                            strokeWidth: '100%',
                            opacity: 1,
                            margin: 5,
                        },
                    }
                },
                series: [
                    @foreach ($ttt as $item)
                        {{ $item }},
                    @endforeach
                ],
                labels: [
                    @foreach ($banks as $bank)
                        '{{ $bank->name }}',
                    @endforeach
                ],
                legend: {
                    show: true,
                    position: "top",
                    horizontalAlign: 'center',
                    fontFamily: fontFamily,
                    itemMargin: {
                        horizontal: 8,
                        vertical: 0
                    },
                },
            };

            var chart = new ApexCharts(document.querySelector("#apexRadialBar1"), options);
            chart.render();

        });
    </script>
    {{-- /// pie chart end /// --}}
    {{-- //////Start Total Summary /////// --}}
    {{-- <div class="row">
        <div class="col-12 col-xl-12 stretch-card">

            <div class="row flex-grow-1">
                <h3 class="my-3">Total Summery</h3>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Total Invoice</h6>
                                <div class="dropdown mb-2">
                                    <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                                data-feather="eye" class="icon-sm me-2"></i> <span
                                                class="">View</span></a>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-12 col-xl-12">
                                    <h3 class="mb-2">{{ $totalInvoice->count() }}<span
                                            style="font-size: 15px; color:#6571ff"> ({{ $totalSaleItems }})</span>
                                    </h3>
                                    <div class="d-flex align-items-baseline">

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
                                <h6 class="card-title mb-0">total purchase</h6>
                                <div class="dropdown mb-2">
                                    <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                                data-feather="eye" class="icon-sm me-2"></i> <span
                                                class="">View</span></a>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-12 col-xl-12">
                                    <h3 class="mb-2">{{ $totalPurchase->count() }}<span
                                            style="font-size: 15px; color:#6571ff"> ({{ $totalPurchaseItems }})</span>
                                    </h3>
                                    <div class="d-flex align-items-baseline">

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
                                <h6 class="card-title mb-0">total invoice product</h6>
                                <div class="dropdown mb-2">
                                    <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                                data-feather="eye" class="icon-sm me-2"></i> <span
                                                class="">View</span></a>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-12 col-xl-12">
                                    <h3 class="mb-2">{{ $totalInvoiceProductTotal }} <span
                                            style="font-size: 15px; color:#6571ff">(
                                            ৳{{ $totalInvoiceProductAmount }})</span></h3>
                                    <div class="d-flex align-items-baseline">

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
                                <h6 class="card-title mb-0">total invoice amount</h6>
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
                                <div class="col-12 col-md-12 col-xl-12">
                                    <h3 class="mb-2"> ৳ {{ $totalInvoiceAmount }}<span
                                            style="font-size: 15px; color:#6571ff"> ( ৳{{ $profit }})</span></h3>
                                    <div class="d-flex align-items-baseline">

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
                                <h6 class="card-title mb-0">total expenses</h6>
                                <div class="dropdown mb-2">
                                    <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                                data-feather="eye" class="icon-sm me-2"></i> <span
                                                class="">View</span></a>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-12 col-xl-12">
                                    <h3 class="mb-2"> ৳ {{ $totalExpenseAmount }}<span
                                            style="font-size: 15px; color:#6571ff"></span></h3>
                                    <div class="d-flex align-items-baseline">

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
                                <h6 class="card-title mb-0">Total customer</h6>
                                <div class="dropdown mb-2">
                                    <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                                data-feather="eye" class="icon-sm me-2"></i> <span
                                                class="">View</span></a>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-12 col-xl-12">
                                    <h3 class="mb-2">{{ $totalCustomer->count() }}</h3>
                                    <div class="d-flex align-items-baseline">

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
                                <h6 class="card-title mb-0">Total sale profit</h6>
                                <div class="dropdown mb-2">
                                    <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                                data-feather="eye" class="icon-sm me-2"></i> <span
                                                class="">View</span></a>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-12 col-xl-12">
                                    <h3 class="mb-2"> ৳ {{ $totalSaleProfit }}</h3>
                                    <div class="d-flex align-items-baseline">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- row --> --}}
    {{-- //////End Total Summary /////// --}}
<br>
    {{-- total chart  --}}
    <div class="row">
        <div class="col-xl-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Total Profit</h6>
                    <div id="apexLine2"></div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var colors = {
                primary: "#6571ff",
                secondary: "#7987a1",
                success: "#05a34a",
                info: "#66d1d1",
                warning: "#fbbc06",
                danger: "#ff3366",
                light: "#e9ecef",
                dark: "#060c17",
                muted: "#7987a1",
                gridBorder: "rgba(77, 138, 240, .15)",
                bodyColor: "#b8c3d9",
                cardBg: "#0c1427"
            }

            var fontFamily = "'Roboto', Helvetica, sans-serif"

            var lineChartOptions = {
                chart: {
                    type: "line",
                    height: '320',
                    parentHeightOffset: 0,
                    foreColor: colors.bodyColor,
                    background: colors.cardBg,
                    toolbar: {
                        show: false
                    },
                },
                theme: {
                    mode: 'dark'
                },
                tooltip: {
                    theme: 'dark'
                },
                colors: [colors.success, colors.info, colors.primary],
                grid: {
                    padding: {
                        bottom: -4
                    },
                    borderColor: colors.gridBorder,
                    xaxis: {
                        lines: {
                            show: true
                        }
                    }
                },
                series: [{
                        name: "Monthly Sale",
                        data: [
                            @foreach ($salesByMonth as $month => $monthlySales)
                                {{ $monthlySales }},
                            @endforeach
                        ]
                    },
                    {
                        name: "Monthly Profit",
                        data: [
                            @foreach ($profitsByMonth as $month => $monthlyProfit)
                                {{ $monthlyProfit }},
                            @endforeach
                        ]
                    },
                    {
                        name: "Monthly Purchase",
                        data: [
                            @foreach ($purchasesByMonth as $month => $monthlyPurchase)
                                {{ $monthlyPurchase }},
                            @endforeach
                        ]
                    }
                ],
                xaxis: {
                    type: "datetime",
                    categories: [
                        @foreach ($salesByMonth as $month => $salesCount)
                            '{{ $month }}-01',
                        @endforeach
                    ],
                    lines: {
                        show: true
                    },
                    axisBorder: {
                        color: colors.gridBorder,
                    },
                    axisTicks: {
                        color: colors.gridBorder,
                    },
                },
                markers: {
                    size: 0,
                },
                legend: {
                    show: true,
                    position: "top",
                    horizontalAlign: 'center',
                    fontFamily: fontFamily,
                    itemMargin: {
                        horizontal: 8,
                        vertical: 0
                    },
                },
                stroke: {
                    width: 3,
                    curve: "smooth",
                    lineCap: "round"
                },
            };
            var apexLineChart = new ApexCharts(document.querySelector("#apexLine2"), lineChartOptions);
            apexLineChart.render();
        });
    </script>
@endsection
