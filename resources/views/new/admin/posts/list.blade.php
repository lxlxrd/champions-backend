<head>
    <style>
        /* Style pour la prévisualisation de l'image */
        #imagePreview {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
            display: block;
        }

        /* Style pour les types de posts */
        .form-check {
            margin-bottom: 10px;
        }



        /* Style pour le formulaire de filtre */
        .filter-form {
            width: 800px;
            /* largeur fixe */
            max-width: 100%;
            /* évite de déborder sur petits écrans */
        }


        /* Adaptation pour les petits écrans */
        @media (max-width: 768px) {
            .modal-dialog {
                margin: 0.5rem auto;
            }
        }
    </style>
</head>

@php
    use Illuminate\Support\Facades\Storage;
@endphp
@extends('layouts.new.app', [
    'breadcrumbs' => [['name' => 'Administration', 'url' => 'admin.home'], ['name' => 'Manage Post', 'url' => null], ['name' => 'Post lists', 'url' => null]],
    'page_title' => 'List of Post',
    'head_title' => 'Post lists',
])

@section('content')
    <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
            <div class="ecom-wrapper">
                <div class="ecom-content">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="d-sm-flex align-items-center">
                                <ul class="list-inline me-auto my-1">
                                    <li class="list-inline-item">
                                        <div class="form-search">
                                            <i class="ti ti-search"></i>
                                            <input type="search" class="form-control" placeholder="Search Post" />
                                        </div>
                                    </li>
                                </ul>
                                <ul class="list-inline ms-auto my-1">
                                    <li class="list-inline-item align-bottom">
                                        <div class="d-flex justify-content-end mb-3">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#postModal">
                                                <i class="ti ti-plus"></i> New Post
                                            </button>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">


                        <div class="card mb-3">
                            <div class="card-body">
                                <form method="GET" action="{{ route('admin.post.index') }}"
                                    class="row g-3 align-items-end filter-form">
                                    <!-- Filtre par type -->
                                    <div class="col-md-4">
                                        <label for="filter-type" class="form-label">Post Type</label>
                                        <select name="type" id="filter-type" class="form-select">
                                            <option value="">All</option>
                                            <option value="GALERY" {{ request('type') === 'GALERY' ? 'selected' : '' }}>
                                                Gallery</option>
                                            <option value="PUBLICATION"
                                                {{ request('type') === 'PUBLICATION' ? 'selected' : '' }}>Publication
                                            </option>
                                        </select>
                                    </div>

                                    <!-- Filtre par saison -->
                                    <div class="col-md-4">
                                        <label for="filter-season" class="form-label">Season</label>
                                        <select name="season_id" id="filter-season" class="form-select">
                                            <option value="">All</option>
                                            @foreach ($seasons as $season)
                                                <option value="{{ $season->id }}"
                                                    {{ request('season_id') == $season->id ? 'selected' : '' }}>
                                                    {{ $season->year }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4 d-flex justify-content-end gap-2">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <a href="{{ route('admin.post.index') }}" class="btn btn-secondary">Reset</a>
                                    </div>
                                </form>
                            </div>
                        </div>

                        @foreach ($posts as $post)
                            <div class="col-sm-6 col-xl-4">
                                <div class="card product-card ">
                                    <div class="card-img-top">
                                        <a href="#">
                                            <img src="{{ Storage::url($post->image_path) }}" alt="{{ $post->title }}"
                                                alt="image" class="img-prod img-fluid"
                                                style="width: 100%; height: 259px; object-fit: cover;" />
                                        </a>
                                        <div class="card-body position-absolute end-0 top-0">
                                            <div class="form-check prod-likes">
                                                <input type="checkbox" class="form-check-input" checked />
                                                <i data-feather="heart" class="prod-likes-icon"></i>
                                            </div>
                                        </div>
                                        <div class="btn-prod-cart card-body position-absolute end-0 bottom-0">
                                            <div class="btn btn-warning">
                                                <a href="#"
                                                    class="avtar avtar-xs btn-link-danger btn-pc-default d-inline-flex align-items-center justify-content-center"
                                                    data-bs-toggle="modal" data-bs-target="#deletePostModal"
                                                    data-id="{{ $post->id }}"
                                                    data-action="{{ route('admin.post.destroy', $post->id) }}">
                                                    <i class="ti ti-trash f-18"></i>
                                                </a>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body ">
                                        <div class="d-flex align-items-center justify-content-between mt-2">
                                            <h4 class="mb-0 text-truncate"><b> {{ $post->title }}</b></h4>

                                            <div class="btn-prod-cart card-body position-absolute end-0 bottom-0">
                                                <div class="btn border-t-green-400">
                                                    {{-- <a href="#" class="avtar avtar-xs btn-link-success btn-pc-default d-inline-flex align-items-center justify-content-center">
                                                <i class="ti ti-edit-circle f-18"></i>
                                            </a> --}}

                                                    <a href="#" class="edit-post-btn" data-bs-toggle="modal"
                                                        data-bs-target="#postModal" data-mode="edit"
                                                        data-id="{{ $post->id }}"
                                                        data-action="{{ route('admin.post.update', $post->id) }}"
                                                        data-title="{{ $post->title }}"
                                                        data-content="{{ $post->content }}"
                                                        data-type="{{ $post->type }}"
                                                        data-image="{{ $post->image_path ? Storage::url($post->image_path) : '' }}">
                                                        <i class="ti ti-edit-circle f-18"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>




                    <!-- Modal d'ajout et d'édit -->
                    <div class="modal fade" id="postModal" tabindex="-1" aria-labelledby="postModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="postModalLabel">New Post</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form id="postForm" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="_method" id="formMethod" value="POST">
                                    <input type="hidden" name="id" id="postId" value="">
                                    <div class="modal-body">
                                        <!-- Type de Post -->
                                        <div class="mb-3">
                                            <label class="form-label">Type </label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="type"
                                                    id="typeGallery" value="GALERY" checked>
                                                <label class="form-check-label" for="typeGallery">
                                                    Galery
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="type"
                                                    id="typePublication" value="PUBLICATION">
                                                <label class="form-check-label" for="typePublication">
                                                    Publication
                                                </label>
                                            </div>
                                        </div>

                                        <!-- Image -->
                                        <div class="mb-3">
                                            <label for="postImage" class="form-label">Image</label>
                                            <input class="form-control" type="file" id="postImage" name="image_path"
                                                accept="image/jpeg,image/png,image/webp">
                                            <small class="text-muted">Format: JPEG, PNG, WEBP (max 2MB)</small>
                                        </div>

                                        {{-- @error('image_path')
                                    <div class="text-danger">{{ $message }}
                                </div>
                                @enderror --}}

                                        <!-- Titre -->
                                        <div class="mb-3">
                                            <label for="postTitle" class="form-label">Title</label>
                                            <input type="text" class="form-control" id="postTitle" name="title"
                                                placeholder="Enter the title" required>
                                        </div>

                                        <!-- Contenu -->
                                        <div class="mb-3">
                                            <label for="postContent" class="form-label">Content</label>
                                            <textarea class="form-control" id="postContent" name="content" rows="5" placeholder="Post content..."
                                                required></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Publish</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>




                    {{-- Modal de suppression  --}}


                    <div class="modal fade" id="deletePostModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Confirm Deletion</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this post?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <form id="deletePostForm" method="POST">
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
        <!-- [ sample-page ] end -->
    </div>
@endsection


@section('script')
    <script>
        // Gestion de la suppression d'un post

        document.addEventListener('DOMContentLoaded', function() {
            const deletePostModal = document.getElementById('deletePostModal');
            const deletePostForm = document.getElementById('deletePostForm');

            deletePostModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const action = button.getAttribute('data-action');
                deletePostForm.action = action;
            });
        });






        document.addEventListener('DOMContentLoaded', function() {
            const postModal = document.getElementById('postModal');
            const form = document.getElementById('postForm');
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.id = 'formMethod';
            form.appendChild(methodInput);

            const postIdInput = document.createElement('input');
            postIdInput.type = 'hidden';
            postIdInput.name = 'id';
            postIdInput.id = 'postId';
            form.appendChild(postIdInput);

            // Création du conteneur de prévisualisation
            const imagePreviewContainer = document.createElement('div');
            imagePreviewContainer.id = 'imagePreviewContainer';
            document.getElementById('postImage').parentNode.appendChild(imagePreviewContainer);

            // Gestion de l'ouverture du modal
            postModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const isEdit = button && button.getAttribute('data-mode') === 'edit';

                if (isEdit) {
                    // Mode Édition
                    form.action = button.getAttribute('data-action');
                    methodInput.value = 'PUT';
                    postIdInput.value = button.getAttribute('data-id');
                    document.getElementById('postModalLabel').textContent = 'Edit Post';

                    // Remplir les champs
                    document.getElementById('postTitle').value = button.getAttribute('data-title');
                    document.getElementById('postContent').value = button.getAttribute('data-content');

                    // Sélectionner le type
                    const postType = button.getAttribute('data-type');
                    document.getElementById(postType === 'PUBLICATION' ? 'typePublication' : 'typeGallery')
                        .checked = true;

                    // Afficher l'image actuelle
                    const imageUrl = button.getAttribute('data-image');
                    if (imageUrl && imageUrl !== 'storage/') {
                        imagePreviewContainer.innerHTML = `
        <img src="${imageUrl}" class="img-fluid rounded mt-2" style="max-height: 200px;">
        <div class="form-text">Current image</div>
    `;
                    } else {
                        imagePreviewContainer.innerHTML =
                            '<div class="form-text text-muted">No image available</div>';
                    }
                } else {
                    // Mode Création
                    form.action = "{{ route('admin.post.store') }}";
                    methodInput.value = 'POST';
                    postIdInput.value = '';
                    document.getElementById('postModalLabel').textContent = 'New Post';

                    // Réinitialiser le formulaire
                    form.reset();
                    imagePreviewContainer.innerHTML = '';
                    document.getElementById('typeGallery').checked = true;
                }
            });

            // Prévisualisation de l'image
            document.getElementById('postImage').addEventListener('change', function(e) {
                const file = e.target.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreviewContainer.innerHTML = `
<img src="${e.target.result}" class="img-fluid rounded mt-2" style="max-height: 200px;">
<div class="form-text">New image preview</div>
`;
                    };
                    reader.readAsDataURL(file);
                } else if (postIdInput.value) {
                    // Réafficher l'image originale si annulation en mode édition
                    const button = document.querySelector(`[data-id="${postIdInput.value}"]`);
                    const imageUrl = button.getAttribute('data-image');
                    if (imageUrl) {
                        imagePreviewContainer.innerHTML = `
<img src="${imageUrl}" class="img-fluid rounded mt-2" style="max-height: 200px;">
<div class="form-text">Current image</div>
`;
                    }
                }
            });
        });
    </script>
@endsection
