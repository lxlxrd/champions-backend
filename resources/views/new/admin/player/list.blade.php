@extends('layouts.new.app', [
'breadcrumbs' => [['name' => 'Administration', 'url' => 'admin.home'],
['name' => 'Manage Player', 'url' => null], ['name' => 'Player lists', 'url' => null]],
'page_title' => 'List of players',
'head_title' => 'Player list',
])
@section( 'content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">

            <div class="card-body">
                <div class="dt-responsive">
                    <table id="res-config" class="display table table-striped table-hover dt-responsive nowrap" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Player</th>
                                <th>Birth Date</th>
                                <th>Parent</th>
                                <th>Jersey Size</th>
                                <th>Preferred Location</th>
                                <th>Gender</th>
                                <th>Age Category</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($players as $player)
                            <tr>
                                <td>{{$player->fullname}}</td>
                                <td>{{$player->birth_date}}</td>
                                <td>{{ optional($player->parent)->fullname ?? '-' }}</td>
                                <td><span class="badge {{$player->jersey_size === 'YS' ? 'bg-green-500' : (
                                $player->jersey_size === 'YM' ? 'bg-blue-500' : 'bg-yellow-500'
                                )}}  f-12">{{$player->jersey_size }}</span>
                                </td>

                                <td><span class="badge {{$player->preferred_location == 'Courtice' ? 'bg-fuchsia-500' : (
                                $player->preferred_location == 'Bowmanville' ? 'bg-rose-500' : 'bg-violet-500'
                                )}}  f-12">{{$player->preferred_location }}</span>
                                </td>
                                <td>{{$player->gender}}</td>
                                <td>{{$player->ageCategory->name}}</td>
                                <td class="text-center">
                                    <ul class="list-inline me-auto mb-0">
                                        <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="View">
                                            <a href="#" class="avtar avtar-xs btn-link-secondary btn-pc-default" data-bs-toggle="modal" data-bs-target="#cust-modal">
                                                <i class="ti ti-eye f-18"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Edit">
                                            <a href="../application/ecom_product-add.html" class="avtar avtar-xs btn-link-success btn-pc-default">
                                                <i class="ti ti-edit-circle f-18"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Delete">
                                            <a href="#" class="avtar avtar-xs btn-link-danger btn-pc-default">
                                                <i class="ti ti-trash f-18"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Player</th>
                                <th>Birth Date</th>
                                <th>Parent</th>
                                <th>Jersey Size</th>
                                <th>Preferred Location</th>
                                <th>Gender</th>
                                <th>Age Category</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('style')
<link rel="stylesheet" href="{{asset('new/assets/css/plugins/dataTables.bootstrap5.min.css')}}">
<link rel="stylesheet" href="{{asset('new/assets/css/plugins/responsive.bootstrap5.min.css')}}">

@endsection
@section('script')
@include ('layouts.new.dtScript')

<script src="{{asset('new/assets/js/plugins/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('new/assets/js/plugins/responsive.bootstrap5.min.js')}}"></script>
<script>
    // [ Configuration Option ]
    $('#res-config').DataTable({
        responsive: true
    });

    // [ New Constructor ]
    var newcs = $('#new-cons').DataTable();

    new $.fn.dataTable.Responsive(newcs);

    // [ Immediately Show Hidden Details ]
    $('#show-hide-res').DataTable({
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.childRowImmediate
                , type: ''
            }
        }
    });

</script>
@endsection
