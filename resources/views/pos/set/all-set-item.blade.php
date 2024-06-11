@extends('master')
@section('title','|Set  Item List')
@section('admin')

    <div class="row">

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title text-info">View All Set Item </h6>
                    <div id="" class="table-responsive">
                        <table id="example" class="table">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Menu Name</th>
                                    <th>Item Name</th>
                                    <th>Quantity</th>
                                    <th>Total Cost</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="showData">
                                @if ($menuItems->count() > 0)
                                    @foreach ($menuItems as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                           {{$item['menuItems']['menu_name']}}
                                            <td>
                                                {{$item['makeItems']['item_name']}}
                                            </td>
                                            <td>
                                                {{$item->quantity}}
                                            </td>
                                            <td> {{$item->apro_cost}}</td>
                                            <td>
                                                <a class="btn btn-sm border text-warning" href="{{route('menu.item.edit',$item->id)}}"><i class="fas fa-edit"></i></a>

                                                <a class="btn btn-sm border delete-btn text-danger" href="{{route('make.item.delete',$item->id)}}"><i class="fas fa-trash-alt"></i></a>
                                            </td>
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
