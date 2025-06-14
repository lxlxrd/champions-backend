@extends('layouts.new.app', [
    'breadcrumbs' => [['name' => 'Administration', 'url' => 'admin.home'], ['name' => 'Manage Player', 'url' => null], ['name' => 'Player lists', 'url' => null]],
    'page_title' => 'List of players',
    'head_title' => 'Player list',
])
@section('content')
    <div class="row">
        <div class="col-sm-12">
            {{-- Filters --}}

            <div class="card mb-4">
                <div class="card-body">
                    <form id="combined-filters-form" class="row g-3 align-items-end">
                        <!-- Gender -->
                        <div class="col-md-3">
                            <label for="filter-gender" class="form-label">Gender</label>
                            <select id="filter-gender" class="form-select">
                                <option value="">All</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <!-- Preferred Location -->
                        <div class="col-md-3">
                            <label for="filter-location" class="form-label">Preferred Location</label>
                            <select id="filter-location" class="form-select">
                                <option value="">All</option>
                                @foreach ($players->pluck('preferred_location')->unique() as $loc)
                                    <option value="{{ $loc }}">{{ ucfirst($loc) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Age Category -->
                        <div class="col-md-3">
                            <label for="filter-age" class="form-label">Age Category</label>
                            <select id="filter-age" class="form-select">
                                <option value="">All</option>
                                @foreach ($players->pluck('ageCategory')->unique('id') as $cat)
                                    @if ($cat)
                                        <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                                    @endif
                                @endforeach

                            </select>
                        </div>

                        <!-- Birthdate -->
                        <div class="col-md-3">
                            <label for="filter-birthyear" class="form-label">Birth Year</label>
                            <select id="filter-birthyear" class="form-select">
                                <option value="">All</option>
                                @foreach ($players->pluck('birth_date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('Y'))->unique()->sort() as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Cancel Filters --}}

                        <div class="col-12 text-end">
                            <button type="button" id="reset-filters" class="btn btn-secondary">Reset Filters</button>
                        </div>

                    </form>
                </div>

            </div>



            <div class="card">


                <div class="card-body">
                    <div class="dt-responsive">
                        <table id="res-config" class="display table table-striped table-hover dt-responsive nowrap"
                            style="width: 100%">
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
                                @foreach ($players as $player)
                                    <tr>
                                        <td>{{ $player->fullname }}</td>
                                        <td>{{ $player->birth_date }}</td>
                                        <td>{{ optional($player->parent)->fullname ?? '-' }}</td>
                                        <td><span
                                                class="badge {{ $player->jersey_size === 'YS'
                                                    ? 'bg-green-500'
                                                    : ($player->jersey_size === 'YM'
                                                        ? 'bg-blue-500'
                                                        : 'bg-yellow-500') }}  f-12">{{ $player->jersey_size }}</span>
                                        </td>

                                        <td><span
                                                class="badge {{ $player->preferred_location === 'Newcastle'
                                                    ? 'bg-teal-400'
                                                    : ($player->preferred_location === 'Bowmanville'
                                                        ? 'bg-orange-500'
                                                        : 'bg-purple-700') }}  f-12">{{ $player->preferred_location }}</span>
                                        </td>

                                        <td>{{ $player->gender }}</td>
                                        <td>{{ $player->ageCategory->name }}</td>

                                        <td class="text-center">
                                            <ul class="list-inline me-auto mb-0">
                                                <li class="list-inline-item align-bottom" data-bs-toggle="tooltip"
                                                    title="View">
                                                    <a href="#"
                                                        class="avtar avtar-xs btn-link-secondary btn-pc-default btn-show-player"
                                                        data-bs-toggle="modal" data-bs-target="#playerModal"
                                                        data-fullname="{{ $player->fullname }}"
                                                        data-birthdate="{{ $player->birth_date }}"
                                                        data-parent="{{ optional($player->parent)->fullname ?? '-' }}"
                                                        data-gender="{{ $player->gender }}"
                                                        data-jersey="{{ $player->jersey_size }}"
                                                        data-location="{{ $player->preferred_location }}"
                                                        data-agecategory="{{ $player->ageCategory->name }}">
                                                        <i class="ti ti-eye f-18"></i>
                                                    </a>

                                                </li>
                                                <li class="list-inline-item align-bottom" data-bs-toggle="tooltip"
                                                    title="Edit">
                                                    <a href="#"
                                                        class="avtar avtar-xs btn-link-success btn-pc-default btn-edit-player"
                                                        data-bs-toggle="modal" data-bs-target="#editPlayerModal"
                                                        data-id="{{ $player->id }}"
                                                        data-firstname="{{ $player->first_name }}"
                                                        data-lastname="{{ $player->last_name }}"
                                                        data-birthdate="{{ \Carbon\Carbon::parse($player->birth_date)->format('Y-m-d') }}"
                                                        data-parent-id="{{ $player->player_parents_id }}"
                                                        data-parent="{{ optional($player->parent)->fullname ?? '-' }}"
                                                        data-gender="{{ $player->gender }}"
                                                        data-jersey="{{ $player->jersey_size }}"
                                                        data-location="{{ ucfirst(strtolower($player->preferred_location)) }}"
                                                        data-agecategory-id="{{ $player->age_categories_id }}"
                                                        data-agecategory="{{ optional($player->ageCategory)->name ?? '-' }}">
                                                        <i class="ti ti-edit-circle f-18"></i>
                                                    </a>




                                                </li>
                                                <li class="list-inline-item align-bottom" data-bs-toggle="tooltip"
                                                    title="Delete">
                                                    <a href="#"
                                                        class="avtar avtar-xs btn-link-danger btn-pc-default btn-delete-player"
                                                        data-bs-toggle="modal" data-bs-target="#deletePlayerModal"
                                                        data-id="{{ $player->id }}" data-name="{{ $player->fullname }}">
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
                                    <th>PLAYER</th>
                                    <th>BIRTH DATE</th>
                                    <th>PARENT</th>
                                    <th>JERSEY SIZE</th>
                                    <th>PREFERRED LOCATION</th>
                                    <th>GENDER</th>
                                    <th>AGE CATEGORY</th>
                                    <th class="text-center">ACTION</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>






    {{-- Modal show --}}
    <!-- Modal : Player Details -->
    <div class="modal fade" id="playerModal" tabindex="-1" aria-labelledby="playerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Player Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="modal-fullname" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Birth Date</label>
                                <input type="text" class="form-control" id="modal-birthdate" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Parent</label>
                                <input type="text" class="form-control" id="modal-parent" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Gender</label>
                                <input type="text" class="form-control" id="modal-gender" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jersey Size</label>
                                <input type="text" class="form-control" id="modal-jersey" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Preferred Location</label>
                                <input type="text" class="form-control" id="modal-location" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Age Category</label>
                                <input type="text" class="form-control" id="modal-agecategory" readonly>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>





    {{-- Modal edit --}}
    <div class="modal fade" id="editPlayerModal" tabindex="-1" aria-labelledby="editPlayerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form method="POST" id="editPlayerForm" action="">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Player</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit-player-id" name="id">
                        <input type="hidden" id="edit-parent-id" name="player_parents_id">
                        <input type="hidden" id="edit-agecategory-id" name="player_age_category_id">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" id="edit-firstname" name="first_name"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="edit-lastname" name="last_name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Birth Date</label>
                                <input type="date" class="form-control" id="edit-birthdate" name="birth_date"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Parent</label>
                                <input type="text" class="form-control" id="edit-parent" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Gender</label>
                                <select class="form-select" id="edit-gender" name="gender" required>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jersey Size</label>
                                <input type="text" class="form-control" id="edit-jersey" name="jersey_size" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Preferred Location</label>
                                <select class="form-select" id="edit-location" name="preferred_location" required>
                                    <option value="Bowmanville">Bowmanville</option>
                                    <option value="Courtice">Courtice</option>
                                    <option value="Newcastle">Newcastle</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Age Category</label>
                                <input type="text" class="form-control" id="edit-agecategory" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>






    {{-- Modal de confirmation de supression --}}
    <div class="modal fade" id="deletePlayerModal" tabindex="-1" aria-labelledby="deletePlayerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="deletePlayerForm" action="">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Deletion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete <strong id="delete-player-name"></strong>?</p>
                        <p class="text-danger mb-0">This action cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Yes, delete</button>
                    </div>
                </div>
            </form>
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



    {{-- Filters --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const table = $('#res-config').DataTable();

            function applyCombinedFilters() {
                const gender = $('#filter-gender').val();
                const location = $('#filter-location').val();
                const age_category = $('#filter-age').val();
                const birthdate = $('#filter-birthyear').val();

                table
                    .column(5).search(gender ? '^' + gender + '$' : '', true, false,
                        true
                    ) // exact match insensible à la casse                    .column(4).search(location || '') // LOCATION
                    .column(6).search(age_category || '') // AGE CATEGORY
                    .column(4).search(location || '') // LOCATION
                    .column(1).search(birthdate || '') // BIRTHDATE
                    .draw();
            }

            $('#combined-filters-form select, #filter-birthdate').on('change keyup', applyCombinedFilters);
        });
    </script>

    {{-- Cancel Filters --}}


    <script>
        $('#reset-filters').on('click', function() {
            $('#combined-filters-form')[0].reset();
            $('#res-config').DataTable().search('').columns().search('').draw();
        });
    </script>


    {{-- Modal show --}}


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#playerModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var modal = $(this);

                modal.find('#modal-fullname').val(button.data('fullname'));
                modal.find('#modal-birthdate').val(button.data('birthdate'));
                modal.find('#modal-parent').val(button.data('parent'));
                modal.find('#modal-gender').val(button.data('gender'));
                modal.find('#modal-jersey').val(button.data('jersey'));
                modal.find('#modal-location').val(button.data('location'));
                modal.find('#modal-agecategory').val(button.data('agecategory'));
            });
        });
    </script>



    {{-- edit  --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#editPlayerModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var modal = $(this);

                var playerId = button.data('id');

                modal.find('#edit-player-id').val(playerId);
                modal.find('#edit-firstname').val(button.data('firstname'));
                modal.find('#edit-lastname').val(button.data('lastname'));
                modal.find('#edit-birthdate').val(button.data('birthdate'));
                modal.find('#edit-parent-id').val(button.data('parent-id'));
                modal.find('#edit-parent').val(button.data('parent'));
                modal.find('#edit-gender').val(button.data('gender'));
                modal.find('#edit-jersey').val(button.data('jersey'));
                modal.find('#edit-location').val(button.data('location')).trigger('change');
                modal.find('#edit-agecategory-id').val(button.data('agecategory-id'));
                modal.find('#edit-agecategory').val(button.data('agecategory'));

                var actionUrl = `/administration/players/${playerId}`;
                $('#editPlayerForm').attr('action', actionUrl);
            });
        });
    </script>


    {{-- Delete --}}


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#deletePlayerModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var modal = $(this);
                var playerId = button.data('id');
                var playerName = button.data('name');

                // Remplir le nom dans le texte
                modal.find('#delete-player-name').text(playerName);

                // Définir l'action vers la bonne route
                var actionUrl = `/administration/players/${playerId}`;
                $('#deletePlayerForm').attr('action', actionUrl);
            });
        });
    </script>
@endsection
