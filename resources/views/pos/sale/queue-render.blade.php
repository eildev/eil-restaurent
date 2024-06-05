
@if($sales)
    @foreach($sales as $sale)
    <div class="col-md-3">
        <div class="card">
            <div class="card-header d-flex" style="padding-bottom: 0px !important;justify-content:space-between">
                <h6 class="card-title text-info text-center mt-1">Dine-1</h6>
                <p class="card-title text-info text-center">Date: 04-06-2024</p>
            </div>
            <div class="card-body p-3 pt-0">
            <table class="table">
                <tr>
                    <td style="text-align:right">Invoice No :</td>
                    <td>#123521</td>
                </tr>
                <tr>
                    <td style="text-align:right">Items x 5 :</td>
                    <td>500.00</td>
                </tr>
                <tr>
                    <td style="text-align:right">Discount :</td>
                    <td>0.00</td>
                </tr>
                <tr>
                    <td style="text-align:right">Total :</td>
                    <td>500.00</td>
                </tr>
            </table>
            </div>
            <div class="card-footer" style="padding: 5px!important">
                <div class="d-flex" style="flex-wrap:wrap;justify-content:center">
                    <button class="{{ $mode->dark_mode == 1 ? 'mybtn_white' : 'mybtn_dark' }}"
                        style="; max-width:48px;border-radius:10px; margin-top:5px">Cash</button>
                    <button class="{{ $mode->dark_mode == 1 ? 'mybtn_white' : 'mybtn_dark' }}"
                        style="margin-left:5px; max-width:48px;border-radius:10px; margin-top:5px">bKash</button>
                    <button class="{{ $mode->dark_mode == 1 ? 'mybtn_white' : 'mybtn_dark' }}"
                        style="margin-left:5px; max-width:48px;border-radius:10px; margin-top:5px">Nagad</button>
                    <button class="{{ $mode->dark_mode == 1 ? 'mybtn_white' : 'mybtn_dark' }}"
                        style="margin-left:5px; max-width:48px;border-radius:10px; margin-top:5px">Card</button>
                </div>
            </div>
        </div>

    </div>
    @endforeach
@endif
