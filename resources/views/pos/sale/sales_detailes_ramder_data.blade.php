@if($sale_items)
    @php
        $mode = App\models\PosSetting::all()->first();
    @endphp
<div class="" style="max-height: 260px;margin-bottom:190px;overflow-y:scroll;overflow-x:hidden">
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
                    <span style="color: #00a9f1;">{{ ($sale_item->set_menu == 0) ? $sale_item->makeitem->item_name :  $sale_item->setmenu->menu_name}}</span> <br>
                    <span style="font-size: 11px">{{ $sale_item->rate }}| {{ $sale_item->makeitem->barcode }} | Dis: {{ $sale_item->discount }}</span>
                </td>
                <td style="padding-top: 15px !important">x {{ $sale_item->qty }}</td>
                <td style="padding-top: 15px !important">৳{{ $sale_item->sub_total }}</td>
                <td style="padding-top: 15px !important"><i class="fa fa-trash remove_item"></i>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <input type="hidden" class="render_sale_id" value="{{ $sale->id }}">
</div>
@endif
<div class="payment-footer" style="position: absolute;bottom:0;left:0;right:0;">
    @if($sale_items)
    <table class="table">
        <thead>
            <tr>
                <td>
                    <h4>Total</h5> (Items: <span class="sale_items_count">{{$sale_items->count()}}</span>, Quantity: <span class="sale_item_quantity">{{$sale_items->sum('qty')}}</span>
                </td>
                <td>S.T ৳<span class="total_sale_receivable">{{ $sale->receivable }}</span></td>
                <input type="hidden" class="final_receivable_main_value" value="{{ $sale->final_receivable }}">
                <td>G.T ৳<span class="final_receivable">{{ $sale->final_receivable }}<span></td>
            </tr>
        </thead>
    </table>
    @endif
    <div id="controls">
        <table class="table">
            <tbody>
                <tr>
                    <td>
                        <div style="display: flex">
                            <select
                                class="form-select select_dine {{ $mode->dark_mode == 1 ? 'my_select_dark' : 'my_select_white' }} me-2"
                                name="dine" id="ageSelect" style="border-color:#00a9f1 !important;">
                                <option selected="" disabled="" value="">Select Dine
                                </option>
                                @php
                                    $dines = App\Models\Dine::all();
                                @endphp
                                @foreach ($dines as $dine)
                                    <option value="{{ $dine->id }}">{{$dine->dine_name}} | Location: {{ $dine->dine_location }}</option>
                                @endforeach
                            </select>
                            <input type="number"
                                class="sale_discount form-control {{ $mode->dark_mode == 1 ? 'my_select_dark' : 'my_select_white' }} px-2"
                                placeholder="Enter Discount" style="border-color:#00a9f1 !important;" value="0.00">
                        </div>
                        <div class="btn-group my-2 d-flex;" role="group" aria-label="Button group with nested dropdown"
                            style="flex-wrap:wrap;justify-content:center">
                            <button class="{{ $mode->dark_mode == 1 ? 'mybtn_white' : 'mybtn_dark' }}"
                                style="width:75px;margin-right:5px; margin-bottom:7px">Cash</button>
                            <button class="{{ $mode->dark_mode == 1 ? 'mybtn_white' : 'mybtn_dark' }}"
                                style="width:75px;margin-right:5px; margin-bottom:7px">bKash</button>
                            <button class="{{ $mode->dark_mode == 1 ? 'mybtn_white' : 'mybtn_dark' }}"
                                style="width:75px;margin-right:5px; margin-bottom:7px">Nagad</button>
                            <button class="{{ $mode->dark_mode == 1 ? 'mybtn_white' : 'mybtn_dark' }}"
                                style="width:75px;margin-right:5px; margin-bottom:7px">Card</button>
                            <button class="btn_add_queu {{ $mode->dark_mode == 1 ? 'mybtn_white' : 'mybtn_dark' }}"
                                style="width:105px;margin-right:5px; margin-bottom:7px">Add
                                Queue</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


