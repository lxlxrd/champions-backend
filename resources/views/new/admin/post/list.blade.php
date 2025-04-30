@php
use Illuminate\Support\Facades\Storage;
@endphp
@extends('layouts.new.app', [
'breadcrumbs' => [['name' => 'Administration', 'url' => 'admin.home'],
['name' => 'Manage Post', 'url' => null], ['name' => 'Post lists', 'url' => null]],
'page_title' => 'List of Post',
'head_title' => 'Post lists',
])

@section( 'content')
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
                                        <input type="search" class="form-control" placeholder="Search Products" />
                                    </div>
                                </li>
                            </ul>
                            <ul class="list-inline ms-auto my-1">
                                <li class="list-inline-item">
                                    <select class="form-select">
                                        <option>Price: High To Low</option>
                                        <option>Price: Low To High</option>
                                        <option>Popularity</option>
                                        <option>Discount</option>
                                        <option>Fresh Arrivals</option>
                                    </select>
                                </li>
                                <li class="list-inline-item align-bottom">
                                    <a href="#" class="d-inline-flex d-xxl-none btn btn-link-secondary align-items-center" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_mail_filter">
                                        <i class="ti ti-filter f-16"></i> Filter
                                    </a>
                                    <a href="#" class="d-none d-xxl-inline-flex btn btn-link-secondary align-items-center" data-bs-toggle="collapse" data-bs-target="#ecom-filter">
                                        <i class="ti ti-filter f-16"></i> Filter
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach ($posts as $post)
                    <div class="col-sm-6 col-xl-4">
                        <div class="card product-card ">
                            <div class="card-img-top">
                                <a href="../application/ecom_product-details.html">
                                    <img src="{{Storage::url($post->image_path)}}" alt="{{ $post->title }}" alt="image" class="img-prod img-fluid" style="width: 100%; height: 259px; object-fit: cover;" />
                                </a>
                                <div class="card-body position-absolute end-0 top-0">
                                    <div class="form-check prod-likes">
                                        <input type="checkbox" class="form-check-input" checked />
                                        <i data-feather="heart" class="prod-likes-icon"></i>
                                    </div>
                                </div>
                                <div class="btn-prod-cart card-body position-absolute end-0 bottom-0">
                                    <div class="btn btn-warning">
                                        <svg class="pc-icon">
                                            <use xlink:href="#custom-bag"></use>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="card-img-top h-64 overflow-hidden rounded-lg">
                                <img src="{{Storage::url($post->image_path)}}" alt="{{ $post->title }}" class="w-full h-full object-cover" style="width: 100%; height: 200px; object-fit: cover;" />
                        </div> --}}
                        <div class="card-body ">
                            <a href="../application/ecom_product-details.html">
                                <p class="prod-content mb-0 text-muted"> {{ $post->type }}</p>
                            </a>
                            <div class="d-flex align-items-center justify-content-between mt-2">
                                <h4 class="mb-0 text-truncate"><b> {{ $post->title }}</b></h4>
                                <div class="prod-color">
                                    <span class="bg-success"></span>
                                    <span class="bg-dark"></span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- [ sample-page ] end -->
</div>
@endsection
