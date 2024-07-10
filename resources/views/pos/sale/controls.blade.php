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
                                <option value="{{ $dine->dine_name }} | Location: {{ $dine->dine_location }}">
                                    {{ $dine->dine_name }} | Location: {{ $dine->dine_location }}</option>
                            @endforeach
                        </select>
                        <input type="number"
                            class="sale_discount form-control {{ $mode->dark_mode == 1 ? 'my_select_dark' : 'my_select_white' }} px-2"
                            placeholder="Enter Discount" style="border-color:#00a9f1 !important;" value="0.00">
                    </div>
                    <div class="btn-group my-2 d-flex;" role="group"
                        aria-label="Button group with nested dropdown"
                        style="flex-wrap:wrap;justify-content:center">
                        <button class="{{ $mode->dark_mode == 1 ? 'mybtn_white' : 'mybtn_dark' }}"
                            style="width:70px;margin-right:5px; margin-bottom:7px">Cash</button>
                        <button class="{{ $mode->dark_mode == 1 ? 'mybtn_white' : 'mybtn_dark' }}"
                            style="width:70px;margin-right:5px; margin-bottom:7px">bKash</button>
                        <button class="{{ $mode->dark_mode == 1 ? 'mybtn_white' : 'mybtn_dark' }}"
                            style="width:70px;margin-right:5px; margin-bottom:7px">Nagad</button>
                        <button class="{{ $mode->dark_mode == 1 ? 'mybtn_white' : 'mybtn_dark' }}"
                            style="width:70px;margin-right:5px; margin-bottom:7px">Card</button>
                        <button class="btn_add_queu {{ $mode->dark_mode == 1 ? 'mybtn_white' : 'mybtn_dark' }}"
                            style="width:100px;margin-right:5px; margin-bottom:7px">Add
                            Queue</button>
                        <button class="btn_update_queu {{ $mode->dark_mode == 1 ? 'mybtn_white' : 'mybtn_dark' }}"
                                style="width:100px;margin-right:5px; margin-bottom:7px;display:none">Update</button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
