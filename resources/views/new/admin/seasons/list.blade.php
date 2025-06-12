<head>
    <style>
        .list-inline-item .avtar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            vertical-align: middle;
        }

        .avtar-xs {
            width: 24px;
            height: 24px;
            line-height: 24px;
        }

        #res-config td {
            vertical-align: middle;
        }


        //-- animation poureffet fluide --
        .modal.fade .modal-dialog {
            transition: transform 0.3s ease-out;
        }


        //-- utilisé dans le modal du show --

        .form-control-static {
            padding: 0.375rem 0.75rem;
            background-color: #f8f9fa;
            border-radius: 0.25rem;
            display: block;
            width: 100%;
        }

    </style>
</head>

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
                        <i class="ti ti-plus"></i> New Season
                    </button>
                </div>
                <div class="dt-responsive">
                    <table id="res-config" class="display table table-striped table-hover dt-responsive nowrap" style="width: 100%">
                        <thead>
                            <tr>
                                <th>YEAR</th>
                                <th>PARENT</th>
                                <th>PLAYER</th>
                                <th>START</th>
                                <th>END</th>
                                <th>STATUS</th>
                                <th class="text-center">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($seasons as $season)
                            <tr>
                                {{-- @dd($season->active) --}}
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
                                <td class="text-center align-middle">
                                    <div class="d-flex justify-content-center">
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item" data-bs-toggle="tooltip" title="View">

                                                <a href="#" class="avtar avtar-xs btn-link-secondary btn-pc-default d-inline-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#showSeasonModal" data-name="{{ $season->year }}" data-active="{{ $season->active }}" data-start="{{ $season->start }}" data-end="{{ $season->end }}" data-parent="{{ $season->distinct_parents }}" data-player="{{ $season->distinct_players }}">
                                                    <i class="ti ti-eye f-18"></i>
                                                </a>
                                            </li>

                                            <li class="list-inline-item" data-bs-toggle="tooltip" title="Edit">

                                                <a href="#" class="avtar avtar-xs btn-link-success btn-pc-default d-inline-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#seasonModal" data-mode="edit" data-id="{{ $season->id }}" data-year="{{ $season->year }}" data-active="{{ $season->active ? '1':'0' }}" data-end="{{ $season->end }}" data-start="{{ $season->start }}">
                                                    <i class="ti ti-edit-circle f-18"></i>
                                                </a>
                                            </li>

                                            <li class="list-inline-item" data-bs-toggle="tooltip" title="Delete">
                                                <a href="#" class="avtar avtar-xs btn-link-danger btn-pc-default d-inline-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal" data-id="{{ $season->id }}" data-action="{{ route('admin.season.destroy', $season->id) }}">
                                                    <i class="ti ti-trash f-18"></i>
                                                </a>
                                            </li>


                                            <li class="list-inline-item" data-bs-toggle="tooltip" title="Archive">
                                                <a href="#" class="avtar avtar-xs btn-link-warning btn-pc-default d-inline-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#archiveConfirmationModal" data-id="{{ $season->id }}" data-action="{{ route('admin.season.archive', $season->id) }}">
                                                    <i class="ti ti-archive f-18"></i>
                                                </a>
                                            </li>


                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>YEAR</th>
                                <th>PARENT</th>
                                <th>PLAYER</th>
                                <th>START</th>
                                <th>END</th>
                                <th>STATUS</th>
                                <th class="text-center">ACTION</th>
                            </tr>
                        </tfoot>
                    </table>


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




                        <!-- Modal pour archive -->
                        <div class="modal fade" id="archiveConfirmationModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Confirm Archive</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to archive this season?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <form id="archiveForm" method="POST">
                                            @csrf
                                            <input type="hidden" name="active" value="0">
                                            <button type="submit" class="btn btn-warning">Archive</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>



                        {{-- Modal show  --}}
                        <div class="modal fade" id="showSeasonModal" tabindex="-1" aria-labelledby="showSeasonModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="showSeasonModalLabel">Season details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Year:</label>
                                            <p id="show-year" class="form-control-static"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Parent:</label>
                                            <p id="show-parent" class="form-control-static"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Player:</label>
                                            <p id="show-player" class="form-control-static"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Active:</label>
                                            <p id="show-active" class="form-control-static"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Start:</label>
                                            <p id="show-start" class="form-control-static"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">End:</label>
                                            <p id="show-end" class="form-control-static"></p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>



                        {{-- Modal pour delete --}}
                        <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Confirm Deletion</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure to delete this season ?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <form id="deleteForm" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
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

<script>
    //{{-- Script pour le show --}}


    document.addEventListener('DOMContentLoaded', function() {
        // Récupère le modal
        const showSeasonModal = document.getElementById('showSeasonModal');

        // Écouteur d'événement quand le modal s'ouvre
        showSeasonModal.addEventListener('show.bs.modal', function(event) {
            // Récupère le bouton qui a déclenché l'ouverture
            const button = event.relatedTarget;

            // Met à jour le titre du modal avec l'année
            document.getElementById('showSeasonModalLabel').textContent = `Details Season ${button.getAttribute('data-name')}`;

            // Remplit les champs avec les données
            document.getElementById('show-year').textContent = button.getAttribute('data-name');
            document.getElementById('show-parent').textContent = button.getAttribute('data-parent');
            document.getElementById('show-player').textContent = button.getAttribute('data-player');

            // Gère l'affichage du statut actif
            const isActive = button.getAttribute('data-active') === '1';
            document.getElementById('show-active').textContent = isActive ? 'Yes' : 'No';

            // Formate les dates (si nécessaire)
            const startDate = new Date(button.getAttribute('data-start'));
            const endDate = new Date(button.getAttribute('data-end'));

            document.getElementById('show-start').textContent = startDate.toLocaleDateString();
            document.getElementById('show-end').textContent = endDate.toLocaleDateString();
        });
    });




    //{{-- Script pour le delete --}}

    const deleteModal = document.getElementById('deleteConfirmationModal');
    const deleteForm = document.getElementById('deleteForm');

    deleteModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        deleteForm.action = button.getAttribute('data-action');
    });




    //{{-- Pour le create et le edit  --}}
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




<script>
    const archiveModal = document.getElementById('archiveConfirmationModal');
    const archiveForm = document.getElementById('archiveForm');

    archiveModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const action = button.getAttribute('data-action');
        archiveForm.action = action;
    });

</script>

@endsection
