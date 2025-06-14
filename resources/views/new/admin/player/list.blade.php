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
                                                        : 'bg-purple-700
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ') }}  f-12">{{ $player->preferred_location }}</span>
                                        </td>

                                        <td>{{ $player->gender }}</td>
                                        <td>{{ $player->ageCategory->name }}</td>
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
@endsection
