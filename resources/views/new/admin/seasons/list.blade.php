@extends('layouts.new.app', [
'breadcrumbs' => [['name' => 'Administration', 'url' => 'admin.home'],
['name' => 'Manage Season', 'url' => null], ['name' => 'Season lists', 'url' => null]],
'page_title' => 'List of seasons',
'head_title' => 'Season lists',
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
                                <th>Year</th>
                                <th>Status</th>
                                <th>Parent</th>
                                <th>Player</th>
                                <th class="text-center">Action</th>
                                {{-- <th>Salary</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($seasons as $season)
                            <tr>
                                <td>{{$season->year}}</td>
                                <td>
                                    @if($season->active)
                                    <span class="text-green-600 font-medium">Active</span>
                                    @else
                                    <span class="text-red-600 font-medium">Archived</span>
                                    @endif
                                </td>

                                <td> {{ $season->distinct_players }}
                                </td>
                                <td> {{ $season->distinct_parents }}
                                </td>
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
                                <th>Year</th>
                                <th>Status</th>
                                <th>Parent</th>
                                <th>Player</th>
                                <th>Action</th>
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
