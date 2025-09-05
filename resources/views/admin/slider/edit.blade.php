@extends('admin.admin_master')

@section('admin')
    <div class="py-12">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                         @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ session('success') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                         @endif
                        <div class="card-header">
                            <h4 class="card-title">Edit Slider</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('update.slider', $slider->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="old_image" value="{{ $slider->image }}" />

                                <div class="form-group">
                                    <label for="title" class="form-label">Slider Title</label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ $slider->title }}">
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description">Slider Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3">{{ $slider->description }}</textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="image" class="form-label">Slider Image</label>
                                    <input type="file" class="form-control-file" id="image" name="image" value="{{ $slider->image }}">
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mb-2">
                                    <img src="{{ asset($slider->image) }}" alt="{{ $slider->title }}" style="max-width: 400px; max-height: 200px;">
                                </div>
                                <button type="submit" class="btn btn-primary">Update Slider</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
