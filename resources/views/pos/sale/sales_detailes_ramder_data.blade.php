@if ($sale_items)
    @php
        $mode = App\models\PosSetting::all()->first();
    @endphp
    <div class=""
        style="padding:8px; max-height: 260px;margin-bottom:15px;overflow-y:scroll;overflow-x:hidden; border: 1px solid;">
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
                @foreach ($sale_items as $sale_item)
                    <tr style="">
                        <td>
                            <div class="d-flex">
                                <img height="90"
                                    style="border-radius:50%;border: 1px solid;border-color:#00a9f1;padding:2px"
                                    src="@if ($sale_item->set_menu == 1) {{ !empty($sale_item->setmenu->image) ? asset('uploads/menu_items/' . $sale_item->setmenu->image) : asset('assets/images/empty.png') }}
                                    @else
                                        {{ !empty($sale_item->makeitem->picture) ? $sale_item->makeitem->picture : asset('assets/images/empty.png') }} @endif">
                                <div class="ms-2">
                                    <span
                                        style="color: #00a9f1;">{{ $sale_item->set_menu == 0 ? $sale_item->makeitem->item_name ?? '' : $sale_item->setmenu->menu_name ?? '' }}</span>
                                    <br>
                                    <span style="font-size: 11px">{{ $sale_item->rate }}|
                                        {{ $sale_item->makeitem->barcode }} |
                                        Dis: {{ $sale_item->discount }}</span>
                                </div>
                            </div>


                        </td>
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
        <input type="hidden" class="render_sale_id" value="{{ $sale->id }}">
    </div>
@endif
<div class="payment-footer">
    @if ($sale_items)
        <table class="table">
            <thead>
                <tr>
                    <td>
                        <h4>Total</h5> (Items: <span class="sale_items_count">{{ $sale_items->count() }}</span>,
                            Quantity: <span class="sale_item_quantity">{{ $sale_items->sum('qty') }})</span>
                    </td>
                    <td>S.T ৳<span class="total_sale_receivable">{{ $sale->receivable }}</span></td>
                    <input type="hidden" class="final_receivable_main_value" value="{{ $sale->final_receivable }}">
                    <td>G.T ৳<span class="final_receivable">{{ $sale->final_receivable }}<span></td>
                </tr>
            </thead>
        </table>
    @endif

</div>
