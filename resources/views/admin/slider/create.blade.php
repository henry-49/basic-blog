@extends('admin.admin_master')

@section('admin')

<div class="col-lg-12">
	<div class="card card-default">
		<div class="card-header card-header-border-bottom">
			<h2>Create Slider</h2>
		</div>
		<div class="card-body">
			<form action="{{ route('store.slider') }}" method="POST" enctype="multipart/form-data">
                @csrf
				<div class="form-group">
					<label for="title" class="form-label">Slider Title</label>
					<input type="text" class="form-control" id="title" name="title" placeholder="Enter Title">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
				</div>
				
				<div class="form-group">
					<label for="description">Slider Description</label>
					<textarea class="form-control" id="description" name="description" rows="3"></textarea>
                     @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
				</div>
                
				<div class="form-group">
					<label for="image" class="form-label">Slider Image</label>
					<input type="file" name="image" class="form-control-file" id="image">
                    @error('image')
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