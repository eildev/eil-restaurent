@extends('master')
@section('title','| Edit Item category')
@section('admin')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card d-flex justify-content-end">
        <div class="">
            <h4 class="text-right"><a href="{{ route('make.item.category.view') }}" class="btn btn-info">All Item List</a></h4>
        </div>
    </div>
<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">

            <h6 class="card-title">Edit Item Category</h6>

            <form id="validMyForm" class="forms-sample" action="{{route('update.item.category',$categoryEdit->id)}}"  method="post">
               @csrf
                <div class="row mb-3 ">
                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Category Name</label>
                    <div class="col-sm-9 my-form-valid">
                        <input type="text" class="form-control" name="category_name" value="{{$categoryEdit->category_name}}" id="exampleInputUsername2" placeholder="Category Name">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary me-2">Update</button>

            </form>

        </div>
    </div>
</div>
</div>
<script>

$(document).ready(function() {

$('#validMyForm').validate({
    rules: {

        category_name: {
            required: true,
        },
    },
    messages: {
        category_name: {
            required: 'Item Category Name Required ',
        },
    },
    errorElement: 'span',
    errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.my-form-valid').append(error);
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
</script>
@endsection
