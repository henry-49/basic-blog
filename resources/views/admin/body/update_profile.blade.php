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
			<h2>User Profile Update</h2>
		</div>
		<div class="card-body">
			<form action="{{ route('update.user.profile') }}" method="POST" class="form-pill" enctype="multipart/form-data">
                @csrf
				<div class="form-group">
					<label for="username" class="form-label">User Name</label>
					<input type="text" class="form-control input-lg" id="username" name="name" value="{{ $user->name }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
				</div>

				<div class="form-group">
					<label for="email" class="form-label">User Email</label>
					<input type="email" class="form-control input-lg" id="email" name="email" value="{{ $user->email }}">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
				</div>
				 
				<div class="form-footer pt-4 pt-5 mt-4 border-top">
					<button type="submit" class="btn btn-primary btn-default">Update</button>
				</div>
			</form>
		</div>
	</div>

</div>

@endsection