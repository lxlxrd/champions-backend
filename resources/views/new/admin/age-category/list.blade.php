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


{{-- message de feedback --}}
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif


@extends('layouts.new.app', [
'breadcrumbs' => [['name' => 'Administration', 'url' => 'admin.home'],
['name' => 'Manage Age Category', 'url' => null], ['name' => 'Age Category lists', 'url' => null]],
'page_title' => 'List of Age Categories',
'head_title' => 'Age Category Lists',
])

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                {{-- bouton d'ajout --}}
                <div class="d-flex justify-content-between mb-3">
                    <h5 class="card-title">List of categories</h5>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAgeCategoryModal">
                        <i class="ti ti-plus"></i> Add
                    </button>
                </div>
                <div class="dt-responsive">
                    <table id="res-config" class="display table table-striped table-hover dt-responsive nowrap" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Min Age</th>
                                <th>Max Age</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->min_age }}</td>
                                <td>{{ $category->max_age }}</td>

                                <td class="text-center align-middle">
                                    <div class="d-flex justify-content-center">
                                        <ul class="list-inline mb-0">
                                            {{-- Show --}}

                                            <li class="list-inline-item" data-bs-toggle="tooltip" title="View">
                                                <a href="#" class="avtar avtar-xs btn-link-secondary btn-pc-default d-inline-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#showCategoryModal" data-name="{{ $category->name }}" data-min_age="{{ $category->min_age }}" data-max_age="{{ $category->max_age }}">
                                                    <i class="ti ti-eye f-18"></i>
                                                </a>
                                            </li>

                                            {{-- Edit --}}
                                            <li class="list-inline-item" data-bs-toggle="tooltip" title="Edit">
                                                <a href="#" class="avtar avtar-xs btn-link-success btn-pc-default d-inline-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#addAgeCategoryModal" data-mode="edit" data-id="{{ $category->id }}" data-name="{{ $category->name }}" data-min_age="{{ $category->min_age }}" data-max_age="{{ $category->max_age }}" data-action="{{ route('admin.age-category.update', $category->id) }}">
                                                    <i class="ti ti-edit-circle f-18"></i>
                                                </a>
                                            </li>

                                            <li class="list-inline-item" data-bs-toggle="tooltip" title="Delete">
                                                <a href="#" class="avtar avtar-xs btn-link-danger btn-pc-default d-inline-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal" data-id="{{ $category->id }}" data-action="{{ route('admin.age-category.destroy', $category->id) }}">
                                                    <i class="ti ti-trash f-18"></i>
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
                                <th>Name</th>
                                <th>Min Age</th>
                                <th>Max Age</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </tfoot>
                    </table>

                    {{-- Modal pour formulaire --}}
                    <div class="modal fade" id="addAgeCategoryModal" tabindex="-1" aria-labelledby="addAgeCategoryModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form method="POST" id="ageCategoryForm">
                                @csrf
                                <input type="hidden" name="_method" value="POST" id="formMethod">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addAgeCategoryModalLabel">Add Age Category</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="inputName" class="form-label">Name</label>
                                            <input type="text" name="name" class="form-control" id="inputName" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="inputMinAge" class="form-label">Min Age</label>
                                            <input type="number" name="min_age" class="form-control" id="inputMinAge" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="inputMaxAge" class="form-label">Max Age</label>
                                            <input type="number" name="max_age" class="form-control" id="inputMaxAge" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Save</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> {{-- /modal --}}



                    {{-- Modal pour supression  --}}

                    <!-- Modal de confirmation de suppression -->
                    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Confirm Deletion</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure to delete this category ?
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



                    <!-- Modal pour afficher les détails -->
                    <div class="modal fade" id="showCategoryModal" tabindex="-1" aria-labelledby="showCategoryModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="showCategoryModalLabel">Category details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Name:</label>
                                        <p id="show-name" class="form-control-static"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Min Age:</label>
                                        <p id="show-min-age" class="form-control-static"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Max Age:</label>
                                        <p id="show-max-age" class="form-control-static"></p>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
<link rel="stylesheet" href="{{ asset('new/assets/css/plugins/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" href="{{ asset('new/assets/css/plugins/responsive.bootstrap5.min.css') }}">
@endsection

@section('script')
@include('layouts.new.dtScript')
<script src="{{ asset('new/assets/js/plugins/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('new/assets/js/plugins/responsive.bootstrap5.min.js') }}"></script>

<script>
    $('#res-config').DataTable({
        responsive: true
    });

    // Gestion de la suppression
    const deleteModal = document.getElementById('deleteConfirmationModal');
    const deleteForm = document.getElementById('deleteForm');

    deleteModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        deleteForm.action = button.getAttribute('data-action');
    });



    // Show 
    const showModal = document.getElementById('showCategoryModal');
    showModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;

        // Mise à jour du titre du modal avec le nom de la catégorie 
        // si le nom est  'Adulte' le titre sera 'Détails: Adulte'
        // showCategoryModalLabel id du titre du modal on affecte au texte du titre Deatils: + le nom de la catégorie
        document.getElementById('showCategoryModalLabel').textContent = `Details: ${button.getAttribute('data-name')}`;

        // Remplissage des données
        document.getElementById('show-name').textContent = button.getAttribute('data-name');
        document.getElementById('show-min-age').textContent = button.getAttribute('data-min_age');
        document.getElementById('show-max-age').textContent = button.getAttribute('data-max_age');
    });




    // Formulaire : Création ou édition
    const form = document.getElementById('ageCategoryForm');
    const methodInput = document.getElementById('formMethod');
    const inputName = document.getElementById('inputName');
    const inputMinAge = document.getElementById('inputMinAge');
    const inputMaxAge = document.getElementById('inputMaxAge');
    const modal = document.getElementById('addAgeCategoryModal');

    modal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        // Supprimez la vérification de classe et vérifiez plutôt le data-mode
        const isEdit = button.getAttribute('data-mode') === 'edit';

        if (isEdit) {
            form.setAttribute('action', button.getAttribute('data-action'));
            methodInput.value = 'PUT';

            inputName.value = button.getAttribute('data-name');
            inputMinAge.value = button.getAttribute('data-min_age');
            inputMaxAge.value = button.getAttribute('data-max_age');

            modal.querySelector('.modal-title').textContent = 'Edit Age Category';
        } else {
            form.setAttribute('action', "{{ route('admin.age-category.store') }}");
            methodInput.value = 'POST';

            inputName.value = '';
            inputMinAge.value = '';
            inputMaxAge.value = '';

            modal.querySelector('.modal-title').textContent = 'Add Age Category';
        }
    });

</script>
@endsection
