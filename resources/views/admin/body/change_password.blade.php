@extends('admin.admin_master')

@section('admin')

<div class="col-lg-8">
	<div class="card">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
		<div class="card-header card-header-border-bottom">
			<h2>Change Password</h2>
		</div>
		<div class="card-body">
			<form action="{{ route('update.password') }}" method="POST" class="form-pill">
                @csrf
				<div class="form-group">
					<label for="old_password" class="form-label">Current Password</label>
					<input type="password" class="form-control" id="current_password" name="old_password" placeholder="Enter Old Password">
                    @error('old_password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
				</div>

				<div class="form-group">
					<label for="password" class="form-label">New Password</label>
					<input type="password" class="form-control" id="password" name="password" placeholder="Enter New Password">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
				</div>

				<div class="form-group">
					<label for="password_confirmation" class="form-label">Confirm Password</label>
					<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
                    @error('password_confirmation')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
				</div>
				 
				<div class="form-footer pt-4 pt-5 mt-4 border-top">
					<button type="submit" class="btn btn-primary btn-default">Save</button>
				</div>
			</form>
		</div>
	</div>

</div>

@endsection