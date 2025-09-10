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
			<h2>Create Contact</h2>
		</div>
		<div class="card-body">
			<form action="{{ route('store.contact') }}" method="POST">
                @csrf
				<div class="form-group">
					<label for="contact_phone" class="form-label">Contact Phone</label>
					<input type="text" class="form-control" id="contact_phone" name="phone" placeholder="Enter Contact Phone">
                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
				</div>
				
				<div class="form-group">
					<label for="contact_email">Contact Email</label>
					<input type="email" class="form-control" id="contact_email" name="email" placeholder="Enter Contact Email">
                     @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
				</div>

                <div class="form-group">
					<label for="contact_address">Contact Address</label>
					<textarea class="form-control" id="contact_address" name="address" rows="3"></textarea>
                     @error('address')
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