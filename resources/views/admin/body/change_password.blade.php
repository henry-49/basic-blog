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
			<form action="{{ route('store.about') }}" method="POST" class="form-pill">
                @csrf
				<div class="form-group">
					<label for="old_password" class="form-label">Old Password</label>
					<input type="password" class="form-control" id="old_password" name="old_password" placeholder="Enter Old Password">
                    @error('old_password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
				</div>
				<div class="form-group">
					<label for="new_password" class="form-label">New Password</label>
					<input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter New Password">
                    @error('new_password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
				</div>
				<div class="form-group">
					<label for="confirm_password" class="form-label">Confirm Password</label>
					<input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Enter Confirm Password">
                    @error('confirm_password')
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