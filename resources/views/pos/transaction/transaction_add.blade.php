@extends('master')
@section('title','| Transactions')

@section('admin')
<style>
    .nav.nav-tabs .nav-item .nav-link.active {
        color: #010205!important;
    background: rgb(101 209 209) !important;
    }
.nav.nav-tabs .nav-item .nav-link {
    border-color: #090c0f #030406 #1a1d1f;
    color: #000;
    background-color: #6571ff;
    cursor: pointer;
}
</style>
<link rel="stylesheet" type="text/css" href="print.css" media="print">

<ul class="nav nav-tabs" id="myTab" role="tablist">

    <li class="nav-item">
        <a class="nav-link active" id="profile-tab" data-bs-toggle="tab" href="#profile" style="background: " role="tab" aria-controls="profile" aria-selected="false">Add Transaction</a>
      </li>

      @if(Auth::user()->can('transaction.history'))
    <li class="nav-item">
      <a class="nav-link " id="home-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Transaction History</a>
    </li>
@endif
  </ul>
  <div class="tab-content border border-print border-top-0 p-3" id="myTabContent">
    <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="row">
            <div class="col-md-12  grid-margin stretch-card filter_table">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <!-- Col -->
                            <div class="col-sm-3">
                                <div class="mb-3 w-100">
                                    {{-- <label class="form-label">Amount<span class="text-danger">*</span></label> --}}
                                    <select class="transaction_customer_name is-valid js-example-basic-single form-control filter-category @error('transaction_customer_id') is-invalid @enderror" name="transaction_customer_id" aria-invalid="false" width="100">
                                        <option>Select Customer</option>
                                        @foreach ($customer as $customers)
                                        <option value="{{$customers->id}}">{{{$customers->name}}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3 w-100">
                                    {{-- <label class="form-label">Amount<span class="text-danger">*</span></label> --}}
                                    <select class="transaction_supplier_name is-valid js-example-basic-single form-control filter-category @error('transaction_supplier_id') is-invalid @enderror" name="transaction_supplier_id" aria-invalid="false" width="100">
                                        <option>Select Supplier</option>
                                            @foreach ($supplier as $suppliers)
                                            <option value="{{$suppliers->id}}">{{$suppliers->name}}</option>
                                            @endforeach


                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group flatpickr" id="flatpickr-date">
                                    <input type="text" class="form-control start-date" placeholder="Start date" data-input>
                                    <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                  </div>
                            </div><!-- Col -->
                            <div class="col-sm-3">
                                <div class="input-group flatpickr" id="flatpickr-date">
                                    <input type="text" class="form-control end-date" placeholder="End date" data-input>
                                    <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                  </div>
                            </div>
                            <style>
                                .select2-container--default{
                                    width: 100% !important;
                                }
                            </style>

                        </div>
                        <div class="row">
                            <div class="col-md-11 mb-2"> <!-- Left Section -->
                                <div class="justify-content-left">
                                    <a href="" class="btn btn-sm bg-info text-dark mr-2" id="transactionfilter">Filter</a>
                                    <a class="btn btn-sm bg-primary text-dark" onclick="window.location.reload();">Reset</a>
                                </div>
                            </div>

                            <div class="col-md-1"> <!-- Right Section -->

                                <button type="button"
                                class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0 print-btn">
                                <i class="btn-icon-prepend" data-feather="printer"></i>
                                Print
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            {{-- ////list// --}}
           <div id="transaction-filter-rander">
            @include('pos.transaction.transaction-filter-rander-table')
           </div>
          </div>
    </div>
    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <div class="row">
            <div class="col-md-12 stretch-card mt-1">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title text-info">Add Transaction</h6>
                            <form id="myValidForm" action="{{route('transaction.store')}}" method="post"  >
                                @csrf
                                <div class="row">
                                    <!-- Col -->
                                    <div class="col-sm-12">
                                        <div class="mb-3 form-valid-groups">
                                            <label class="form-label">Personal/Direct Transaction</label>
                                            <select class="form-select"data-width="100%" name="dirrect_transaction" aria-invalid="false">
                                                <option value="no">No</option>
                                                <option value="yes">Yes</option>

                                            </select>
                                        </div>
                                    </div><!-- Col -->
                                    <div class="col-sm-6">
                                        <div class="mb-3 form-valid-groups">
                                            <label class="form-label">Transaction Date<span class="text-danger">*</span></label>
                                            <div class="input-group flatpickr" id="flatpickr-date">
                                                <input type="text" name="date" class="form-control" placeholder="Select date" data-input>
                                                <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                              </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3 form-valid-groups">
                                            <label class="form-label">Transaction Type <span class="text-danger">*</span></label>
                                            <select class="form-select bank_id "data-width="100%" name="transaction_type" aria-invalid="false">
                                                <option selected="" disabled value="">Select Type</option>
                                                <option value="receive">Cash Receive</option>
                                                <option value="pay">Cash Payment</option>
                                            </select>
                                        </div>
                                    </div><!-- Col -->
                                    <div class="col-sm-6">
                                        <div class="mb-3 form-valid-groups">
                                            <label class="form-label">Account Type<span class="text-danger">*</span></label>
                                            <select class="form-select" data-width="100%" name="account_type" id="account_type" aria-invalid="false">
                                                <option selected disabled value="">Select Account Type</option>
                                                <option value="supplier">Supplier</option>
                                                <option value="customer">Customer</option>
                                            </select>
                                        </div>
                                    </div><!-- Col -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Account ID<span class="text-danger">*</span></label>
                                            <select class="form-select select-account-id" data-width="100%" name="account_id" id="account_id" aria-invalid="false">
                                                <option selected disabled value="">Select Account ID</option>
                                            </select>
                                        </div>
                                    </div><!-- Col -->
                                    <div>
                                        <h5 id="account-details"></h5>
                                        <h5 id="due_invoice_count"></h5>
                                        <h5 id="total_invoice_due"></h5>
                                        <h5 id="personal_balance"></h5>
                                        <h5 id="total_due"></h5>

                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3 form-valid-groups">
                                            <label class="form-label">Amount<span class="text-danger">*</span></label>
                                            <input type="number" name="amount" class="form-control" placeholder="Enter Amount">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Transaction Account</label>
                                            <select class="form-select "data-width="100%" name="payment_method" aria-invalid="false">
                                                <option selected="" disabled value="">Select Account</option>
                                                @foreach ($paymentMethod as $payment)
                                                <option value="{{$payment->id}}">{{$payment->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Note</label>
                                            <textarea name="note" class="form-control"  placeholder="Write Note (Optional)" rows="4" cols="50"></textarea>
                                        </div>
                                    </div><!-- Col -->
                                </div><!-- Row -->

                                <div >
                                <input type="submit" class="btn btn-primary submit" value="Payment">
                                </div>
                            </form>

                            <table>
                                <tbody id="account_data">
                                    <!-- Data will be dynamically populated here -->
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
  </div>
<script>
       document.getElementById("account_type").addEventListener("change", function() {
        var accountType = this.value;
        var options = '<option selected disabled value="">Select Account ID</option>';

        if (accountType === "supplier") {
            @foreach ($supplier as $supply)
                options += '<option  value="{{ $supply->id}}">{{ $supply->name }} </option>';
            @endforeach

        } else if (accountType === "customer") {
            @foreach ($customer as $customers)
                options += '<option value="{{ $customers->id }}">{{ $customers->name }}</option>';
            @endforeach

        }

        document.getElementById("account_id").innerHTML = options;
    });
    //
    // document.getElementById("account_id").addEventListener("change", function() {
    //    var accountId = this.value;
    //     $('#supplier-info').slideDown();
    //   //  $('#customer-info').hide();
    //   if (!accountId) {
    //     $('#supplier-info').hide();;
    // }
    //  });
    var account_id=  document.querySelector('.select-account-id');
    account_id.addEventListener('change', function(){
// alert('ok');
    let accountId  = this.value;
    let account_type = document.querySelector('#account_type').value;
    // console.log(id);
    $.ajax({
        url: '/getDataForAccountId',
        method: 'GET',
        data: { id: accountId,account_type },
        success: function(data) {
           console.log(data);
            $('#account-details').text('Name: ' + data.info.name);
            $('#due_invoice_count').text('Due Invoice Count: '+data.count);
            $('#total_invoice_due').text('Total Invoice Due: '+ data.info.opening_receivable);
            $('#personal_balance').text('Personal Balance: '+ data.info.wallet_balance);
            $('#total_due').text('Total Due: '+data.info.total_payable);
        },
        error: function(xhr, status, error) {
            // Error handling
            console.error('Request failed:', error);
        }
    });
    });

$(document).ready(function (){

    document.querySelector('#transactionfilter').addEventListener('click', function(e) {
        e.preventDefault();
        let startDate = document.querySelector('.start-date').value;

            let endDate = document.querySelector('.end-date').value;
            // alert(endDate);
            let filterCustomer = document.querySelector('.transaction_customer_name').value;
            let filterSupplier = document.querySelector('.transaction_supplier_name').value;
            //   alert(filterCustomer);
            //   alert(filterSupplier);
            $.ajax({
                url: "{{ route('transaction.filter.view') }}",
                method: 'GET',
                data: {
                    startDate,
                    endDate,
                    filterCustomer,
                    filterSupplier,
                },
                success: function(res) {
                    jQuery('#transaction-filter-rander').html(res);
                }
            });
        });
    /////Validation
        $('#myValidForm').validate({
            rules: {
                account_type: {
                    required : true,
                },
                transaction_type: {
                    required : true,
                },
                date: {
                    required : true,
                },
                balance: {
                    required : true,
                },
            },
            messages :{
                account_type: {
                    required : 'Please Select Account Type',
                },
                date: {
                    required : 'Please Select Date',
                },
                transaction_type: {
                    required : 'Please Select Transaction Type',
                },
                balance: {
                    required : 'Enter Transaction Balance',
                },
            },
            errorElement : 'span',
            errorPlacement: function (error,element) {
                error.addClass('invalid-feedback');
                element.closest('.form-valid-groups').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
                $(element).addClass('is-valid');
            },
        });
    });
///Print
        $('.print-btn').click(function() {
            // Remove the id attribute from the table
            $('#dataTableExample').removeAttr('id');
            $('.table-responsive').removeAttr('class');
            // Trigger the print function
            window.print();

        });
</script>
<style>
    @media print {

        nav,.nav,
        .footer {
            display: none !important;
        }

        .page-content {
            margin-top: 0 !important;
            padding-top: 0 !important;
        }

        .btn_group ,.filter_table,.dataTables_length,.pagination,.dataTables_info{
            display: none !important;
        }
        #dataTableExample_filter{
            display: none !important;
        }
        .border{
            border: none !important;
        }
        table,th,td{
            border: 1px solid black;
            background: #fff
        }
        .actions{
            display: none !important;
        }
        .card{
            background: #fff!important;
            box-shadow: none!important;
            border: none !important;
        }
        .note_short{

        }
    }

</style>
@endsection
