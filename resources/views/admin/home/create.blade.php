@extends('admin.admin_master')

@section('admin')

<div class="col-lg-12">
	<div class="card">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
		<div class="card-header card-header-border-bottom">
			<h2>Create About</h2>
		</div>
		<div class="card-body">
			<form action="{{ route('store.about') }}" method="POST">
                @csrf
				<div class="form-group">
					<label for="title" class="form-label">Home Title</label>
					<input type="text" class="form-control" id="title" name="title" placeholder="Enter Title">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
				</div>
				
				<div class="form-group">
					<label for="short_description">Short Description</label>
					<textarea class="form-control" id="short_description" name="short_description" rows="3"></textarea>
                     @error('short_description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
				</div>

                <div class="form-group">
					<label for="long_description">Long Description</label>
					<textarea class="form-control" id="long_description" name="long_description" rows="3"></textarea>
                     @error('long_description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
				</div>
                
				<div class="form-footer pt-4 pt-5 mt-4 border-top">
					<button type="submit" class="btn btn-primary btn-default">Create</button>
				</div>
			</form>
		</div>
	</div>

	
	
</div>

@endsection