@extends('admin.admin_master')

@section('admin')

    <div class="py-12">
        <div class="container mb-4">
            <div class="row">
                <h4> Home About</h4>
                <a href="{{ route('create.about')}}" class="btn btn-primary ml-2 mb-2">Add About</a> <br>

                <div class="col-md-12">
                    <div class="card">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ session('success') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="card-header">
                            <h4 class="card-title">All About</h4>
                        </div>
                        <div class="card-body">

                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                    <th scope="col" width="5%">SL No</th>
                                    <th scope="col" width="10%">Home Title</th>
                                    <th scope="col" width="20%">Short Description</th>
                                    <th scope="col" width="30%">Long Description</th>
                                    <th scope="col" width="15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if($homeabout->count() > 0)
                                        @php($i = 1)
                                    @foreach ($homeabout as $about)
                                        <tr>
                                            <th scope="row">{{ $i++ }}</th>
                                            <td>{{ $about->title }}</td>
                                            <td>{{ $about->short_description }}</td>
                                            <td>{{ $about->long_description }}</td>
                                            
                                            
                                            <td>
                                                <a href="{{ route('edit.about', $about->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="{{ route('delete.about', $about->id) }}"
                                                    onclick="return confirm('Are you sure you want to delete this brand?');"
                                                    class="btn btn-danger btn-sm">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <strong>No About Data Found</strong>
                                    </td>
                                </tr>
                                @endif
                                </tbody>
                            </table>
                            
                      </div>
                    </div>
                </div>

            </div>
        </div>
{{-- end of about --}}
    </div>


    
@endsection