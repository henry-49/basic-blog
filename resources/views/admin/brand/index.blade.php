@extends('admin.admin_master')

@section('admin')




    <div class="py-12">
        <div class="container mb-4">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">All Brands</h4>
                        </div>
                        <div class="card-body">
                            <p class="card-text">List of all brands</p>


                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                    <th scope="col">SL No</th>
                                    <th scope="col">Brand Name</th>
                                    <th scope="col">Brand Image</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if($brands->count() > 0)
                                @foreach ($brands as $brand)
                                    <tr>
                                        <th scope="row">{{ $brands->firstItem() + $loop->index }}</th>
                                        <td>{{ $brand->brand_name }}</td>
                                        <td><img src="{{ asset($brand->brand_image) }}" alt="{{ $brand->brand_name }}" style="height: 40px; width:70px" /></td>
                                        <td>
                                            @if($brand->created_at == NULL)
                                            <span class="text-danger">No Date Set </span>
                                            @else
                                            {{ Carbon\Carbon::parse($brand->created_at)->diffForHumans() }}
                                        </td>
                                        @endif
                                        <td>
                                            <a href="{{ route('edit.brand', $brand->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="{{ route('delete.brand', $brand->id) }}"
                                                 onclick="return confirm('Are you sure you want to delete this brand?');"
                                                 class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <strong>No Brands Found</strong>
                                    </td>
                                </tr>
                                @endif
                                </tbody>
                            </table>
                            {{ $brands->links() }}
                      </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Add Brand</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('store.brand') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-2">
                                    <label for="brand_name" class="form-label">Brand Name</label>
                                    <input type="text" class="form-control" id="brand_name" name="brand_name" placeholder="Enter brand name">
                                    @error('brand_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label for="brand_image" class="form-label">Brand Image</label>
                                    <input type="file" class="form-control" id="brand_image" name="brand_image">
                                    @error('brand_image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Add Brand</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
{{-- end of all brands --}}


    </div>


    
@endsection