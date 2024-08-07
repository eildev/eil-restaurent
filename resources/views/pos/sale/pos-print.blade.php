@php
    // dd($sale);
    // $branch = App\Models\Branch::findOrFail($sale->branch_id);
    // $customer = App\Models\Customer::findOrFail($sale->customer_id);
    // $products = App\Models\SaleItem::where('sale_id', $sale->id)->get();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Point of Sale Receipt</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: "Space Mono", monospace;
            font-weight: 500;
            font-style: normal;
            font-size: 16px;
            color: #000000;
            text-align: left !important;
            width: 300px !important;
        }

        .receipt {
            width: 100%;
            /* Adjust according to your POS paper width */
            margin: auto;

        }

        .receipt h2 {
            font-size: 10px;
            margin-bottom: 5px;
        }

        .receipt p {
            margin: 5px 0;
            /* font-size: 12px; */
        }

        table {
            text-align: right;
            /* font-size: 10px; */
            width: 300px;
            margin: 0 5px;
        }


        th,
        td {

            text-align: right;
        }

        .text-end {
            text-align: right;
        }

        .text-start {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        hr {
            border: 1px dashed #ccc;
        }
    </style>
</head>

<body>
    <div class="receipt ">
        <div>
            @if (!empty($invoice_logo_type))
                @if ($invoice_logo_type == 'Name')
                    <h4>{{ $siteTitle }}</h4>
                @elseif($invoice_logo_type == 'Logo')
                    @if (!empty($logo))
                        <img height="50" width="150" src="{{ url($logo) }}" alt="logo">
                    @else
                        <h4>{{ $siteTitle }}</h4>
                    @endif
                @elseif($invoice_logo_type == 'Both')
                    @if (!empty($logo))
                        <img height="50" width="150" src="{{ url($logo) }}" alt="logo">
                    @endif
                    <h4>{{ $siteTitle }}</h4>
                @endif
            @else
                <h4>EIL POS Software</h4>
            @endif
            <p>{{ $address ?? 'Banasree' }}</p>
            <p>{{ $email ?? 'Banasree' }}</p>
            <p>{{ $phone ?? '' }}</p>
            <div class="text-end" style="margin: 0 10px 10px 0">
                <p><b>{{ $sale->customer->name ?? '' }}</b></p>
                <p>{{ $sale->customer->address ?? '' }}</p>
                <p>{{ $sale->customer->email ?? '' }}</p>
                <p>{{ $sale->customer->phone ?? '' }}</p>
            </div>
            <div class="flex font-sm">
                @php
                    $dacTimeZone = new DateTimeZone('Asia/Dhaka');
                    $created_at = optional($sale->created_at)->setTimezone($dacTimeZone);
                    $formatted_date = optional($sale->created_at)->format('d F Y') ?? '';
                    $formatted_time = $created_at ? $created_at->format('h:i A') : '';
                @endphp
                <p>{{ $formatted_date ?? '' }}</p>
                <p>Time: {{ $formatted_time ?? '' }}</p>
            </div>
        </div>
        {{-- <img src="" alt="">
        <h2>Branch name</h2> --}}
        <div class="text-end">
            <hr>
            {{-- <p>-------------------</p> --}}
            <table align="right">
                <thead>
                    <tr>
                        <th class="text-start">
                            Item <br> Name
                        </th>
                        {{-- <th class="text-center"> U.<br> Price</th> --}}
                        <th class="text-center">
                            Qty
                        </th>
                        <th class="text-center">Discount</th>
                        <th class="text-end">
                            Amount
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if ($sale->saleItem->count() > 0)

                        @foreach ($sale->saleItem as $index => $saleItem)
                            {{-- @dd(($saleItem->set_menu == 1) ? $saleItem->setmenu->menu_name : $saleItem->product->name) --}}
                            <tr>
                                <td class="text-start">
                                    {{ $saleItem->set_menu == 1 ? $saleItem->setmenu->menu_name ?? '' : $saleItem->product->name ?? '' }}
                                </td>
                                <td class="text-center">{{ $saleItem->qty ?? 0 }}</td>
                                <td class="text-center">{{ $saleItem->discount ?? 0 }}</td>
                                <td class="text-end">{{ $saleItem->sub_total ?? 0 }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <br> <br> <br>
            {{-- <br> <br> <br> --}}
            {{-- <p>-------------------</p> --}}
            <hr>
            <div class="flex">
                <p>Total:</p>
                <p>{{ $sale->total }}</p>
            </div>

            {{-- <p>-------------------</p> --}}
            <hr>

            <div class="flex">
                <p>Discount: </p>
                <p>৳ {{ $sale->discount }}</p>
                <p>৳ {{ $sale->change_amount }}</p>
            </div>
            <hr>




            @if ($sale->tax != null)
                <div class="flex">
                    {{-- <p>TAX: ({{ $sale->tax }}%) ৳ {{ $sale->receivable }}</p> --}}
                    <p>TAX: </p>
                    <p>{{ $sale->tax }}</p>
                    <p>৳ {{ $sale->final_receivable }}</p>
                </div>
                <hr>
            @endif

            <div class="flex">
                <p>Grand Total: </p>
                <p>৳ {{ $sale->final_receivable }}</p>
            </div>
            <hr>
            <div class="flex">
                <p>Paid</p>
                <p>৳ {{ $sale->paid }} </p>
            </div>
            <hr>
            <div class="flex">
                @if ($sale->due > 0)
                    <p>Balance Due</p>
                    <p>৳ {{ $sale->due }} </p>
                @else
                    <p>Return</p>
                    <p>৳ {{ $sale->returned }} </p>
                @endif
            </div>
            <hr>
            <p>Thank you for your purchase!</p>
        </div>
    </div>


    <style>
        @media print {
            body {
                font-family: "Space Mono", monospace;
                font-weight: 500;
                font-style: normal;
                font-size: 11px;
                color: #000000;
                text-align: left !important;
                width: 300px !important;
                /* background: red !important; */
            }

            nav,
            .footer {
                display: none !important;
            }

            .page-content {
                margin-top: 0 !important;
                padding-top: 0 !important;
            }

            .btn_group {
                display: none !important;
            }
        }
    </style>

    <script>
        // Open print window when page loads
        window.onload = function() {
            window.print();
        };

        // Close the tab when print window is closed or cancelled
        window.onafterprint = function() {
            window.close();
        };
    </script>
</body>

</html>
