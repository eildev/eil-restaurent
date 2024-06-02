@extends('master')
@section('title','| Item List')
@section('admin')

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title text-info">View Item List</h6>
                    <div id="" class="table-responsive">
                        <table id="example" class="table">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    {{-- <th>Category</th> --}}
                                    <th>Item Name</th>
                                    <th>Barcode</th>
                                    <th>Total Cost</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="showData">
                                @if ($items->count() > 0)
                                    @foreach ($items as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item['makeItem']['product_id']?? '' }}</td>
                                            <td>{{ $item['makeItem']['quantity'] ?? '' }}</td>
                                            <td>{{ $item['makeItem']['unit'] ?? '' }}</td>
                                            <td>{{ $item->item_name ?? '' }}</td>
                                            <td>{{ $item->barcode ?? '' }}</td>
                                            <td>{{ $item->cost_price ?? '' }}</td>
                                            <td><img src="{{asset('/uploads/make_item/'.$item->picture)}}" alt=""></td>

                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="12">
                                            <div class="text-center text-warning mb-2">Data Not Found</div>
                                        </td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
