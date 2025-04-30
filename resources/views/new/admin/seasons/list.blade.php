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
                <div class="d-flex justify-content-end mb-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#seasonModal" data-mode="create">
                        New Season
                    </button>
                </div>
                <div class="dt-responsive">
                    <table id="res-config" class="display table table-striped table-hover dt-responsive nowrap" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Year</th>
                                <th>Parent</th>
                                <th>Player</th>
                                <th>Start</th>
                                <th>End</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($seasons as $season)
                            <tr>
                                <td>{{$season->year}}</td>
                                <td> {{ $season->distinct_players }}
                                </td>
                                <td> {{ $season->distinct_parents }}
                                </td>
                                <td>{{$season->start?? '-'}}</td>
                                <td>{{$season->end?? '-'}}</td>
                                <td>
                                    @if($season->active)
                                    <span class="text-green-600 font-medium">Active</span>
                                    @else
                                    <span class="text-red-600 font-medium">Archived</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <ul class="list-inline me-auto mb-0">
                                        <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="View">
                                            <a href="#" class="avtar avtar-xs btn-link-secondary btn-pc-default" data-bs-toggle="modal" data-bs-target="#cust-modal">
                                                <i class="ti ti-eye f-18"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Edit">
                                            <button class="btn btn-link-success p-1" data-bs-toggle="modal" data-bs-target="#seasonModal" data-mode="edit" data-id="{{ $season->id }}" data-year="{{ $season->year }}" data-active="{{ $season->active ? '1':'0' }}" data-end="{{ $season->end }}" data-start="{{ $season->start }}">
                                                <i class="ti ti-edit-circle f-18"></i>
                                            </button>
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
                                <th>Parent</th>
                                <th>Player</th>
                                <th>Action</th>
                                <th>Start</th>
                                <th>End</th>
                                <th>Status</th>

                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card-body pc-component">
    <div id="seasonModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="seasonModal" data-mode="add" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="seasonModal" data-mode="add"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="seasonForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="modalYear" class="form-label">Year</label>
                            <input type="number" class="form-control" id="modalYear" name="year" placeholder="Enter year" required>
                        </div>
                        <div class="mb-3">
                            <label for="modalStart" class="form-label">Start</label>
                            <input type="text" class="form-control" id="modalStart" name="start" placeholder="Enter year" required>
                        </div>
                        <div class="mb-3">
                            <label for="modalEnd" class="form-label">End</label>
                            <input type="text" class="form-control" id="modalEnd" name="end" placeholder="Enter year" required>
                        </div>
                        <div class="mb-3">
                            <label for="modalActive" class="form-label">Status</label>
                            <select class="form-select" id="modalActive" name="active" required>
                                <option value="0">Archived</option>
                                <option value="1">Active</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save </button>
                    </div>
                </form>
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

<script>
    const seasonModal = document.getElementById('seasonModal');
    seasonModal.addEventListener('show.bs.modal', event => {
        const btn = event.relatedTarget;
        const mode = btn.getAttribute('data-mode'); // create | edit
        const form = document.getElementById('seasonForm');
        const title = seasonModal.querySelector('.modal-title');
        const yearInput = document.getElementById('modalYear');
        const actInput = document.getElementById('modalActive');
        const startInput = document.getElementById('modalStart');
        const endInput = document.getElementById('modalEnd');
        if (mode === 'create') {
            title.textContent = 'Create New Season';
            form.action = "{{ route('admin.season.store') }}";
            form.removeAttribute('_method'); // supprime le PUT si présent
            yearInput.value = '';
            actInput.value = '0';
            startInput.value = '';
            endInput.value = '';
        } else {
            // mode === 'edit'
            const id = btn.getAttribute('data-id');
            const year = btn.getAttribute('data-year');
            const active = btn.getAttribute('data-active');
            const start = btn.getAttribute('data-start');
            const end = btn.getAttribute('data-end');

            title.textContent = 'Edit Season #' + id;
            form.action = `/administration/seasons/${id}`; // ou helper route
            // injecter le champ _method PUT
            let m = form.querySelector('input[name="_method"]');
            if (!m) {
                m = document.createElement('input');
                m.setAttribute('type', 'hidden');
                m.setAttribute('name', '_method');
                form.appendChild(m);
            }
            m.setAttribute('value', 'PUT');

            yearInput.value = year;
            actInput.value = active;
            startInput.value = start;
            endInput.value = end;
        }
    });

</script>

@endsection
