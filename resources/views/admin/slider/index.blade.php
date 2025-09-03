@extends('admin.admin_master')

@section('admin')




    <div class="py-12">
        <div class="container mb-4">
            <div class="row">
                <h4> Home Slider</h4>
                <a href="{{ route('create.slider')}}" class="btn btn-primary ml-2 mb-2">Add Slider</a> <br>

                <div class="col-md-12">
                    <div class="card">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ session('success') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="card-header">
                            <h4 class="card-title">All Slider</h4>
                        </div>
                        <div class="card-body">
                            <p class="card-text">List of all Slider</p>


                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                    <th scope="col" width="5%">SL No</th>
                                    <th scope="col" width="10%">Slider Title</th>
                                    <th scope="col" width="25%">Description</th>
                                    <th scope="col" width="10%">Slider Image</th>
                                    <th scope="col" width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if($sliders->count() > 0)
                                        @php($i = 1)
                                    @foreach ($sliders as $slider)
                                        <tr>
                                            <th scope="row">{{ $i++ }}</th>
                                            <td>{{ $slider->title }}</td>
                                            <td>{{ $slider->description }}</td>
                                            <td><img src="{{ asset($slider->image) }}" alt="{{ $slider->title }}" style="height: 40px; width:70px" /></td>
                                            
                                            <td>
                                                <a href="{{ route('edit.slider', $slider->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="{{ route('delete.slider', $slider->id) }}"
                                                    onclick="return confirm('Are you sure you want to delete this brand?');"
                                                    class="btn btn-danger btn-sm">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <strong>No Slider Found</strong>
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
{{-- end of all sliders --}}
    </div>


    
@endsection