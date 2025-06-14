@extends('layouts.new.app', [
    'breadcrumbs' => [['name' => 'Administration', 'url' => 'admin.home'], ['name' => 'Manage Registration', 'url' => null], ['name' => 'Registration lists', 'url' => null]],
    'page_title' => 'List of Registrations',
    'head_title' => 'Registration lists',
])
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">

                <div class="card-body">
                    <div class="dt-responsive">

                        <div class="card mb-4">
                            <div class="card-body">
                                <form id="filters-form" class="row g-3 align-items-end">
                                    <div class="col-md-4">
                                        <label for="filter-season" class="form-label">Season</label>
                                        <select id="filter-season" class="form-select">
                                            @php
                                                $years = $registrations->pluck('season.year')->unique()->sort();
                                                $categories = $registrations
                                                    ->pluck('age_category.name')
                                                    ->unique()
                                                    ->sort();
                                            @endphp
                                            <option value="">All</option>
                                            @foreach ($years as $year)
                                                <option value="{{ $year }}">{{ $year }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="filter-age" class="form-label">Age Category</label>
                                        <select id="filter-age" class="form-select">
                                            <option value="">All</option>
                                            @foreach ($categories as $cat)
                                                <option value="{{ $cat }}">{{ $cat }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="filter-status" class="form-label">Status</label>
                                        <select id="filter-status" class="form-select">
                                            <option value="">All</option>
                                            <option value="approved">approved</option>
                                            <option value="pending">pending</option>
                                            <option value="rejected">rejected</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <table id="res-config" class="display table table-striped table-hover dt-responsive nowrap"
                            style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Player</th>
                                    <th>Parent</th>
                                    <th>Season</th>
                                    <th>Age Category</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($registrations as $reg)
                                    <tr>
                                        <td>{{ $reg->player->fullname }}</td>
                                        <td>{{ $reg->parent->fullname ?? '-' }}</td>
                                        <td>{{ $reg->season->year }}</td>
                                        <td>{{ $reg->age_category->name }}</td>

                                        <td><span
                                                class="badge {{ $reg->status === 'approved'
                                                    ? 'bg-green-500'
                                                    : ($reg->status === 'rejected'
                                                        ? 'bg-red-500'
                                                        : 'bg-yellow-500') }}  f-12">{{ $reg->status }}</span>
                                        </td>

                                        <td class="text-center">
                                            <ul class="list-inline me-auto mb-0">
                                                <li class="list-inline-item align-bottom" data-bs-toggle="tooltip"
                                                    title="View">
                                                    <a href="#"
                                                        class="avtar avtar-xs btn-link-secondary btn-pc-default"
                                                        data-bs-toggle="modal" data-bs-target="#cust-modal">
                                                        <i class="ti ti-eye f-18"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item align-bottom" data-bs-toggle="tooltip"
                                                    title="Edit">
                                                    <a href="../application/ecom_product-add.html"
                                                        class="avtar avtar-xs btn-link-success btn-pc-default">
                                                        <i class="ti ti-edit-circle f-18"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item align-bottom" data-bs-toggle="tooltip"
                                                    title="Delete">
                                                    <a href="#" class="avtar avtar-xs btn-link-danger btn-pc-default">
                                                        <i class="ti ti-trash f-18"></i>
                                                    </a>
                                                </li>

                                                <li class="list-inline-item align-bottom" data-bs-toggle="tooltip"
                                                    title="Approve">
                                                    <button type="button" class="btn btn-icon btn-light-success"
                                                        onclick="openApproveModal('{{ route('admin.registration.validate', $reg->id) }}')">
                                                        <i class="ti ti-circle-check"></i>
                                                    </button>
                                                </li>

                                                <li class="list-inline-item align-bottom" data-bs-toggle="tooltip"
                                                    title="Reject">
                                                    <button type="button" class="btn btn-icon btn-outline-danger"
                                                        onclick="openRejectModal('{{ route('admin.registration.reject', $reg->id) }}')">
                                                        <i class="ti ti-x"></i>
                                                    </button>
                                                </li>


                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>PLAYER</th>
                                    <th>PARENT</th>
                                    <th>SEASON</th>
                                    <th>AGE CATEGORY</th>
                                    <th>STATUS</th>
                                    <th class="text-center">ACTION</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- Création du modal --}}


    <!-- Modal de confirmation pour VALIDER -->
    <div class="modal fade" id="confirmApproveModal" tabindex="-1" aria-labelledby="confirmApproveLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" id="approveForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmApproveLabel">Confirm approval</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure <strong>to validate</strong> this registration ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Validate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de confirmation pour REJETER -->
    <div class="modal fade" id="confirmRejectModal" tabindex="-1" aria-labelledby="confirmRejectLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" id="rejectForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmRejectLabel">Confirm rejection</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure <strong>to reject</strong> this registration ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Reject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('new/assets/css/plugins/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('new/assets/css/plugins/responsive.bootstrap5.min.css') }}">
@endsection
@section('script')
    @include ('layouts.new.dtScript')

    <script src="{{ asset('new/assets/js/plugins/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('new/assets/js/plugins/responsive.bootstrap5.min.js') }}"></script>
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
                    display: $.fn.dataTable.Responsive.display.childRowImmediate,
                    type: ''
                }
            }
        });
    </script>


    {{-- Modal --}}
    <script>
        function openApproveModal(actionUrl) {
            const form = document.getElementById('approveForm');
            form.action = actionUrl;
            const modal = new bootstrap.Modal(document.getElementById('confirmApproveModal'));
            modal.show();
        }

        function openRejectModal(actionUrl) {
            const form = document.getElementById('rejectForm');
            form.action = actionUrl;
            const modal = new bootstrap.Modal(document.getElementById('confirmRejectModal'));
            modal.show();
        }
    </script>



    {{-- Filter season --}}

    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });

        document.addEventListener('DOMContentLoaded', function() {
            const table = $('#res-config').DataTable();

            function applyCombinedFilters() {
                const season = $('#filter-season').val();
                const age = $('#filter-age').val();
                const status = $('#filter-status').val();

                // Appliquer filtre par filtre si valeur présente, sinon reset
                table
                    .column(2).search(season || '') // colonne 2 = Season
                    .column(3).search(age || '') // colonne 3 = Age Category
                    .column(4).search(status || '') // colonne 4 = Status
                    .draw();
            }

            $('#filters-form select').on('change', applyCombinedFilters);
        });
    </script>
@endsection
