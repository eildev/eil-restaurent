@extends('master')
@section('title', '| Add Product')
@section('admin')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">New Product</li>
        </ol>
    </nav>
    <form class="productForm" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="card-title">Add Product</h6>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label">Product Name <span
                                        class="text-danger">*</span></label>
                                <input class="form-control name" onchange="generateCode(this);" name="name"
                                    type="text" onkeyup="errorRemove(this);" onblur="errorRemove(this);">
                                <span class="text-danger name_error"></span>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label">Product Code</label>
                                <input class="form-control @error('barcode') is-invalid @enderror" name="barcode"
                                    type="number" value="{{ old('barcode') }}" readonly>
                                @error('barcode')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                @php
                                    $categories = App\Models\Category::get();
                                @endphp
                                <label for="ageSelect" class="form-label">Category <span
                                        class="text-danger">*</span></label>
                                <select class="js-example-basic-single form-select category_id" id="category_name"
                                    name="category_id" onchange="errorRemove(this);">
                                    @if ($categories->count() > 0)
                                        <option selected disabled>Select category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    @else
                                        <option selected disabled>Please Add Category</option>
                                    @endif
                                </select>
                                <span class="text-danger category_id_error"></span>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="ageSelect" class="form-label">Subcategory </label>
                                <select class="js-example-basic-single form-select subcategory_id" name="subcategory_id">
                                    <option selected disabled>Select Subcategory</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-4">
                                @php
                                    $brands = App\Models\Brand::get();
                                @endphp
                                <label for="ageSelect" class="form-label">Brand </label>
                                <select class="js-example-basic-single form-select brand_id" name="brand_id">
                                    @if ($brands->count() > 0)
                                        <option selected disabled>Select Brand</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    @else
                                        <option selected disabled>Please Add Brand</option>
                                    @endif
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="password" class="form-label">Cost Price <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" name="cost" type='number' placeholder="00.00"
                                    onkeyup="errorRemove(this);" onblur="errorRemove(this);" />
                                <span class="text-danger cost_error"></span>
                            </div>
                            <div class="mb-3 col-md-6">
                                @php
                                    $units = App\Models\Unit::get();
                                @endphp
                                <label for="ageSelect" class="form-label">Unit <span class="text-danger">*</span></label>
                                <select class="js-example-basic-single form-select unit_id" name="unit_id"
                                    onchange="errorRemove(this);">
                                    @if ($units->count() > 0)
                                        <option selected disabled>Select Unit</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                        @endforeach
                                    @else
                                        <option selected disabled>Please Add Unit</option>
                                    @endif
                                </select>
                                <span class="text-danger unit_id_error"></span>
                            </div>
                            <div class="mb-3 col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">Product Image</h6>
                                        <p class="mb-3 text-warning">Note: <span class="fst-italic">Image not
                                                required. If you
                                                add
                                                a category image
                                                please add a 400 X 400 size image.</span></p>
                                        <input type="file" class="categoryImage" name="image" id="myDropify" />
                                    </div>
                                </div>
                            </div>
                            <div>
                                <input class="btn btn-primary w-full save_product" type="submit" value="Submit">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>


    <script>
        // remove error
        // function errorRemove(element) {
        //     if (element.value != '') {
        //         $(element).siblings('span').hide();
        //         $(element).css('border-color', 'green');
        //     }
        // }

        function errorRemove(element) {
            tag = element.tagName.toLowerCase();
            if (element.value != '') {
                // console.log('ok');
                if (tag == 'select') {
                    $(element).closest('.mb-3').find('.text-danger').hide();
                } else {
                    $(element).siblings('span').hide();
                    $(element).css('border-color', 'green');
                }
            }
        }


        $(document).ready(function() {
            // show error
            function showError(name, message) {
                $(name).css('border-color', 'red'); // Highlight input with red border
                $(name).focus(); // Set focus to the input field
                $(`${name}_error`).show().text(message); // Show error message
            }

            // when select category
            $('.category_id').change(function() {
                let id = $(this).val();
                // alert(id);
                if (id) {
                    $.ajax({
                        url: '/subcategory/find/' + id,
                        type: 'GET',
                        dataType: 'JSON',
                        success: function(res) {
                            if (res.status == 200) {
                                $('.subcategory_id').empty();
                                // $('.subcategory_id').size_id();
                                // console.log(res);

                                // show subcategory
                                if (res.data.length > 0) {

                                    // console.log(res.data)
                                    $('.subcategory_id').html(
                                        '<option selected disabled>Select a SubCategory</option>'
                                    );
                                    $.each(res.data, function(key, item) {
                                        $('.subcategory_id').append(
                                            `<option value="${item.id}">${item.name}</option>`
                                        );
                                    })
                                } else {
                                    $('.subcategory_id').html(`
                                        <option selected disable>Please add Subcategory</option>`)
                                }

                                // show Size
                                if (res.size.length > 0) {
                                    // console.log(res.size);
                                    $('.size_id').html(
                                        '<option selected disabled>Select a Size</option>'
                                    );
                                    $.each(res.size, function(key, item) {

                                        $('.size_id').append(
                                            `<option value="${item.id}">${item.size}</option>`
                                        );
                                    })
                                } else {
                                    $('.size_id').html(`
                                        <option selected disable>Please add Size</option>`)
                                }
                            }
                        }
                    });
                }
            })


            // product save
            $('.save_product').click(function(e) {
                e.preventDefault();
                // alert('ok')
                let formData = new FormData($('.productForm')[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/product/store',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.status == 200) {
                            // console.log(res);
                            $('.productForm')[0].reset();

                            toastr.success(res.message);
                            window.location.href = "{{ route('product.view') }}";
                        } else {
                            const error = res.error;
                            if (error.name) {
                                showError('.name', error.name);
                            }
                            if (error.category_id) {
                                showError('.category_id', error.category_id);
                            }
                            if (error.cost) {
                                showError('.cost', error.cost);
                            }
                            if (error.unit_id) {
                                showError('.unit_id', error.unit_id);
                            }
                        }
                    }
                });
            })
        });

        function generateCode(input) {
            var nameInput = input.value.trim();
            if (nameInput !== "") {
                var codeInput = input.parentElement.nextElementSibling.querySelector('input[name="barcode"]');
                var randomNumber = Math.floor(Math.random() * 1000000) +
                    20; // Generate a random number between 1 and 1000000
                var generatedCode = nameInput.replace(/\s+/g, '').toUpperCase() + randomNumber;
                var generatedNumber = randomNumber; // Extract the generated number

                codeInput.value = generatedNumber; // Set the generated number directly in the input field
            }
        }
    </script>
@endsection
