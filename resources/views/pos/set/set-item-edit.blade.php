@extends('master')
@section('title', '| Set Items')
@section('admin')
    <div class="row mt-0">
        <div class="col-lg-12 grid-margin stretch-card mb-3">
            <div class="card">
                <div class="card-body px-4 py-2">
                    <form id="myValidForm" class="myForms" method="POST">
                        @csrf
                        <input type="hidden" name="id" class="menuItemId" value="0">
                    <div class="row" >
                        <div class="mb-1 col-md-6">
                            @php
                                $setMenus = App\Models\SetMenu::all();
                            @endphp
                            <div  class="row">
                                <div class="col-md-10 form-valid-groups">
                                    <label for="ageSelect" class="form-label">Menu name</label>
                                    <select class="js-example-basic-single form-select menu_select" data-width="100%" name="menu_id"
                                       >
                                        @if ($setMenus->count() > 0)
                                            <option selected disabled>Select Set Menu</option>
                                            @foreach ($setMenus as $setMenu)
                                                <option value="{{ $setMenu->id }}" {{$menuItems->menu_id  == $setMenu->id ? 'selected': ''}}>{{ $setMenu->menu_name }} </option>
                                            @endforeach
                                        @else
                                            <option selected disabled>Please Select Set Menu</option>
                                        @endif
                                    </select>
                                    <span class="text-danger product_select_error"></span>
                                </div>
                                <div class="col-md-2"  style="margin-top: 10px">
                                    <label for="ageSelect" class="form-label"> </label><br>
                                    <a href="" class="btn btn-sm btn-info"  data-bs-toggle="modal"
                                    data-bs-target="#exampleModalLongScollable11">+</a>
                                </div>
                            </div>
                        </div>
                        @php
                        $makeItems = App\Models\MakeItem::where('cost_price', '>', 0)->get();
                        @endphp
                        <div class="mb-2 col-md-6 form-valid-groups">
                            <label for="ageSelect" class="form-label">Select Item Name</label>
                            <div class="">
                                <select class="js-example-basic-single form-select" name="item_id"  data-width="100%" id="make_id">
                                @if ($makeItems->count() > 0)
                                    <option selected disabled>Select Items</option>
                                    @foreach ($makeItems as $makeItem)
                                        <option value="{{ $makeItem->id }}" {{$menuItems->item_id  == $makeItem->id ? 'selected': ''}}>{{ $makeItem->item_name }}
                                        </option>
                                    @endforeach
                                @else
                                    <option selected disabled>Please Add Product</option>
                                @endif
                            </select>
                            </div>
                        </div>
                        <div class="mb-2 col-md-4">
                            <label for="ageSelect11" class="form-label">Sale Price</label>
                            <div class="">
                                <input type="number" id="salePrice" value="{{$menuItems['makeItems']['sale_price']}}" name="sale_price" class="form-control" placeholder="0.00"
                                     aria-describedby="btnGroupAddon" >
                            </div>
                        </div>
                        <div class="mb-2 col-md-3 form-valid-groups">
                            <label for="ageSelect" class="form-label">Quantity</label>
                            <div class="">
                                <input type="number" id="quantity" value= "{{$menuItems->quantity}}" class="form-control" name="quantity" placeholder="0"
                                     aria-describedby="btnGroupAddon">
                            </div>
                            <div id="quantityError" class="text-danger"></div>
                        </div>
                        <div class="mb-1 col-md-5">
                            <label for="password" class="form-label">Total Cost</label>
                            <div class="d-flex g-3">
                                <input type="text" class="form-control barcode_input" id="costPrice" placeholder="0.00" value="{{$menuItems->apro_cost}}" name="apro_cost"
                                     aria-describedby="btnGroupAddon" readonly>
                                <button type="submit" class="btn btn-primary ms-2"
                                   >Add</button>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>

    </div>

   {{-- /////////////////Set Menu Add Modal//////////////// --}}
<div class="modal fade" id="exampleModalLongScollable11" tabindex="-1"
   aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title" id="exampleModalScrollableTitle">Add Set Menu</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal"
                   aria-label="btn-close"></button>
           </div>
           <div class="modal-body">
               <form id="myFormId" enctype="multipart/form-data">
                {{-- @csrf --}}
                  <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="menu_name" class="form-label">Menu Name</label>
                            <input id="menu_name" class="form-control menu_name"
                                maxlength="250" name="menu_name" type="text">
                            <span class="text-danger menu_name_error"></span>
                        </div>
                    </div>


                  </div>
                  <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="Cost" class="form-label">Cost Price</label>
                            <input id="Cost" class="form-control cost_price"
                                 name="cost_price" type="number">
                            <span class="text-danger cost_price_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="sale_price" class="form-label">Sale Price</label>
                            <input id="defaultconfig12" class="form-control sale_price"
                                 name="sale_price" type="number">
                            <span class="text-danger sale_price_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="discount" class="form-label">Discount Type</label>
                            <select class="form-control" name="discount_type" data-width="100%">
                        <option selected disabled>Select Discount Type</option>
                        <option value="percentage">Percentage</option>
                                <option value="solid">Amount</option>
                            </select>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Discount Amount</label>
                            <input id="defaultconfigDiscount" class="form-control discount"
                                maxlength="250" name="discount" type="number">

                        </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Menu Image</label>
                            <input type="file" class="image" name="image" id="myDropify" />

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Note</label>
                           <textarea name="note" class="form-control" cols="30" rows="9"></textarea>

                        </div>
                    </div>

                  </div>
           </div>
           <div class="modal-footer">
               <button type="button" class="btn btn-secondary"
                   data-bs-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary save_set_menu">Save</button>
           </div>
           </form>
       </div>
   </div>
</div>
<style>
    .modal.fade .modal-dialog {
        transition: transform 0.0s ease-out; /* Adjust duration (e.g., 0.2s for 200ms) */
    }
    .modal.fade.show .modal-dialog {
        transform: translateY(0);
    }
</style>
<!--------Category Modal-------->
    {{-- table  --}}
    <div class="row">
        <div class="col-md-12 mb-1 grid-margin stretch-card">
            <div class="card">
                <div class="card-body px-4 py-2">
                    <div class="mb-3">
                        <h6 class="card-title">Details</h6>
                    </div>

                    <div id="" class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nenu Name</th>
                                    <th>Item Name</th>
                                    {{-- <th>Sale Price</th> --}}
                                    <th>QTY</th>
                                    <th>Total Cost</th>
                                    <th>
                                        <i class="fa-solid fa-trash-can"></i>
                                    </th>
                                </tr>

                            </thead>
                            <tbody class="showData newShow">
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="2"></th>
                                    <th >Grand Total</th>
                                    <th id="totalCost">0.00</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



<script>
    // validation

$(document).ready(function() {
$('#myValidForm').validate({
    rules: {

        menu_id: {
            required: true,
        },
        item_id: {
            required: true,
        },
        quantity: {
            required: true,
        },
        sale_price: {
            required: true,
        },

    },
    messages: {

        menu_id: {
            required: 'Menu Name Required ',
        },
        item_id: {
            required: 'Item Name Required',
        },
        quantity: {
            required: 'Quantity Field Required',
        },
        sale_price: {
            required: 'Sale Price Required',
        },

    },
    errorElement: 'span',
    errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-valid-groups').append(error);
    },
    highlight: function(element, errorClass, validClass) {
        $(element).addClass('is-invalid');
    },
    unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        $(element).addClass('is-valid');
    },
});
});
    // validation End

document.addEventListener('DOMContentLoaded', function() {
    const saveMenu = document.querySelector('.save_set_menu');

    saveMenu.addEventListener('click', function(e) {
        e.preventDefault();
        $('.text-danger').text('');

        // Client-side validation
        let isValid = true;
        const menuName = document.getElementById('menu_name').value.trim();
        const costPrice = document.getElementById('Cost').value.trim();
        const salePrice = document.getElementById('defaultconfig12').value.trim();

        if (!menuName) {
            $('.menu_name_error').text('Menu Name is required.');
            isValid = false;
        }

        if (!costPrice) {
            $('.cost_price_error').text('Cost Price is required.');
            isValid = false;
        }

        if (!salePrice) {
            $('.sale_price_error').text('Sale Price is required.');
            isValid = false;
        }

        if (!isValid) {
            toastr.error('Please fill in all required fields.');
            return;
        }

        let formElement = document.getElementById('myFormId');
        if (!formElement || !(formElement instanceof HTMLFormElement)) {
            console.error('Form element not found or not of type HTMLFormElement');
            return;
        }

        let formData = new FormData(formElement);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "/set/menu/store",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status == 200) {
                    $('#exampleModalLongScollable11').modal('hide');
                    $('#myFormId')[0].reset();
                    toastr.success(response.message);
                    const newOption = new Option(response.data.menuItem.menu_name, response.data.menuItem.id);
                    document.querySelector('.menu_select').append(newOption);
                    // Optionally refresh select2 if used
                    $('.js-example-basic-single').select2();
                } else {
                    toastr.error(response.message || 'Validation Required');
                }
            },
            error: function(response) {
                if (response.status === 422) {
                    const errors = response.responseJSON.errors;
                    Object.keys(errors).forEach(function(key) {
                        $('.' + key + '_error').text(errors[key][0]);
                    });
                    toastr.error('Please correct the errors and try again.');
                } else {
                    toastr.error('An error occurred. Please try again.');
                }
            }
        });
    });

    $('#exampleModalLongScollable11').on('hidden.bs.modal', function() {
        $('#myFormId')[0].reset();
        $('.text-danger').text('');
    });
});//

   $(document).ready(function () {

        $('#exampleModalLongScollable11').on('hidden.bs.modal', function () {
            $('.setMenuForm')[0].reset();
            $('.text-danger').text('');
        });
        ///Item selected price show
        $('#make_id').on('change', function () {
            const selectedItemID = $(this).val();
            $.ajax({
                url: '/get-item-price',
                method: 'GET',
                data: { item_id: selectedItemID },
                success: function (response) {
                    $('#salePrice').val(response.itemPrice);
                    $('#costPrice').val('');
                    $('#quantity').val('');

                },
                error: function () {
                    toastr.error('Failed to fetch item price.');
                }
            });
        });
        function calculateCostPrice() {
            const salePrice = parseFloat($('#salePrice').val());
            const quantity = parseInt($('#quantity').val());
            const costPrice = isNaN(salePrice) || isNaN(quantity) ? '' : salePrice * quantity;
            $('#costPrice').val(costPrice);
        }
        $('#salePrice').on('input', function () {
            calculateCostPrice();
        });
        $('#quantity').on('input', function () {
            calculateCostPrice();
        });
    });
//Store Set item
$(document).ready(function () {
    $('.myForms').submit(function(event) {
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: '/update/set/item',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {

                // console.log(response.data.menuItem);
                if (response.status === 200) {
                    var menuName = response.data.menuItem.menu_items.menu_name;
                    var itemName = response.data.menuItem.make_items.item_name;
                    var newQuantity = response.data.menuItem.quantity;
                    var newCost = response.data.menuItem.apro_cost;
                    var itemId = response.data.menuItem.id;
                    let existingRow = $('.showData').find(`tr[data-id="${itemId}"]`);
                if (existingRow.length) {
                    existingRow.find('.menu-name').text(menuName);
                        existingRow.find('.item-name').text(itemName);
                        existingRow.find('.quantity').text(newQuantity);
                        existingRow.find('.apro_cost').text(newCost);
                } else {
                    var newRow = `
                            <tr data-id="${itemId}">
                                <td class="menu-name">${menuName}</td>
                                <td class="item-name">${itemName}</td>
                                <td class="quantity">${newQuantity}</td>
                                <td class="apro_cost">${newCost}</td>
                                <td><a type="button" class="btn btn-sm text-danger deleteRow"><i class="fas fa-trash-alt"></i></a></td>
                            </tr>`;

                    $('.showData').append(newRow);

                }
                updateGrandTotal()

                    $('.menuItemId').val(response.menuItemId);
                    // console.log()
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
    function showAllSelectedItems() {
    let id = '{{ $menuItems->id }}';
    $.ajax({
        url: '/menu/item/find/' + id,
        type: 'GET',
        dataType: 'JSON',
        success: function(res) {
            if (res.status == 200) {
                const items = res.menuItemsAll;
                items.forEach(item => {
                    const itemId = item.id;
                    const itemName = item.make_items.item_name;
                    const menuName = item.menu_items.menu_name;
                    const quantity = item.quantity;
                    const apro_cost = item.apro_cost;
                    let existingRow = $('.showData').find(`tr[data-id="${itemId}"]`);
                    if (existingRow.length > 0) {
                        // Update the existing row
                        existingRow.find('.quantity').text(quantity);
                        existingRow.find('.apro_cost').text(aproCost);
                    }else{
                     var newRow = `
                            <tr data-id="${itemId}">
                                <td>${menuName}</td>
                                <td>${itemName}</td>
                                <td class="quantity">${quantity}</td>
                                <td class="apro_cost">${apro_cost}</td>
                                <td><a type="button" class="btn btn-sm text-danger deleteRow"><i class="fas fa-trash-alt"></i></a></td>
                            </tr>`;
                        $('.showData').append(newRow);

                        }
                });
                updateGrandTotal();
            } else {
                toastr.warning(res.error);
            }
        }
    });
}
showAllSelectedItems()
//Delete
$(document).on('click', '.deleteRow', function() {
        var row = $(this).closest('tr');
        let id = row.data('id');
        // console.log(row.data('item-id'));
        $.ajax({
            type: 'get',
            url: '/delete/menu-item/' + id,
            data: {
                _token: '{{ csrf_token() }}',
            },
            success: function(response) {
                if (response.status === 200) {
                    row.remove();
                    updateGrandTotal();
                    toastr.success(response.message);
                } else {
                    toastr.error('Failed to delete the item.');
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                toastr.error('Failed to delete the item.');
            }
        });
    });
    //
    function updateGrandTotal() {
    var grandTotal = 0;
    $('.apro_cost').each(function() {
        grandTotal += parseFloat($(this).text());
    });
    $('#totalCost').text(grandTotal.toFixed(2));
}
//Edit Show Data

    });

</script>
@endsection
