@if($sale_details)
<div class="row">
    <div class="col-md-6 border">
        <table>
            <thead>
                <tr>
                    <th>Sale By: </th>
                    <td>{{ $sale_details->user->name }}</td>
                </tr>
                <tr>
                    <th>Invoice Date: </th>
                    <td>{{ $sale_details->sale_date }}</td>
                </tr>
                <tr>
                    <th>Customer Name: </th>
                    <td>{{ $sale_details->customer->name }}</td>
                </tr>
                <tr>
                    <th>Customer Balance:</th>
                    <td>{{ $sale_details->customer->total_receivable }}</td>
                </tr>
                <tr>
                    <th>Customer Phone:</th>
                    <td>{{ $sale_details->customer->phone }}</td>
                </tr>
            </thead>
        </table>
    </div>
    <div class="col-md-6 border">
        <table>
            <thead>
                <tr>
                    <th>Dine</th>
                    <td>{{ $sale_details->dine_id }}</td>
                </tr>
                <tr>
                    <th>Invoice No: </th>
                    <td>{{ $sale_details->invoice_number }}</td>
                </tr>
                <tr>
                    <th>Items x {{ $sale_items->count() }} :</th>
                    <td>{{ $sale_details->total }}</td>
                </tr>
                <tr>
                    <th>Discount:</th>
                    <td>{{ $sale_details->discount }}</td>
                </tr>
                <tr>
                    <th>Grand Total:</th>
                    <td>{{ $sale_details->final_receivable }}</td>
                </tr>
            </thead>

        </table>
    </div>
    <hr>
    <div class="col-md-12">
        <h4 class="py-3">Items Details</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Product Information</th>
                    <th>Product Price</th>
                    <th>Product Quantity</th>
                    <th>Sub-Total</th>
                    <th><i class="fas fa-sliders"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sale_items as $sale_item)
                    <tr style="">
                        <td>
                            <div class="d-flex">
                                <img height="90"
                                style="border-radius:50%;border: 1px solid;border-color:#00a9f1;padding:2px"

                                src="@if($sale_item->set_menu == 1)
                                        {{ !empty($sale_item->setmenu->image) ? asset('uploads/menu_items/'.$sale_item->setmenu->image) :  asset('assets/images/empty.png')}}
                                    @else
                                        {{ !empty($sale_item->makeitem->picture) ? $sale_item->makeitem->picture :  asset('assets/images/empty.png')}}
                                    @endif">
                                <div class="ms-2">
                                    <span
                                        style="color: #00a9f1;">{{ $sale_item->set_menu == 0 ? $sale_item->makeitem->item_name : $sale_item->setmenu->menu_name }}</span>
                                    <br>
                                    <span style="font-size: 11px">{{ $sale_item->rate }}| {{ $sale_item->makeitem->barcode }} |
                                        Dis: {{ $sale_item->discount }}</span>
                                        </div>
                            </div>
                        </td>
                        <td style="padding-top: 15px !important">x {{ $sale_item->rate }}</td>
                        <td style="padding-top: 15px !important">x {{ $sale_item->qty }}</td>
                        <td style="padding-top: 15px !important">৳{{ $sale_item->sub_total }}</td>
                        <td style="padding-top: 15px !important">
                            <a href="" class="remove_item" value="{{ $sale_item->id }}"><i
                                    class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@else
<div style="height: 250px; display:flex; justify-content:center;align-items:center">
    <h3>Please Select Sale Info....</h3>
</div>
@endif
