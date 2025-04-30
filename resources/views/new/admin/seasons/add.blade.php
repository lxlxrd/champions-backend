@extends('layouts.new.app', [
'breadcrumbs' => [['name' => 'Administration', 'url' => null], ['name' => 'Season lists', 'url' => null]],
'page_title' => 'Add a season',
'head_title' => '',
])

@section('content')
<div class="col-lg-6">
    <div class="card">
        <div class="card-header">
            <h5>New Season</h5>
        </div>
        <div class="card-body">
            <form>
                <div class="form-group mb-0">
                    <label class="form-label">Year:</label>
                    <input type="email" class="form-control" placeholder="Enter Year">
                    <small class="form-text text-muted">Please enter the year</small>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary me-2">Submit</button>
            <button class="btn btn-secondary">Clear</button>
        </div>
    </div>
</div>
@endsection
