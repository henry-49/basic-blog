<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Multi Picture
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container mb-4">
            <div class="row">
                <div class="col-md-8">
                    <div class="card-group">
                        @foreach ($images as $image)
                            <div class="col-md-4 mt-5">
                                <div class="card">
                                    <img src="{{ asset($image->image) }}" class="card-img-top" alt="...">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Multi Image</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('store.multi.image') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-2">
                                    <label for="images" class="form-label">Images</label>
                                    <input type="file" class="form-control" id="images" name="images[]" multiple="">
                                    @error('images')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Add Image</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
{{-- end of all multi images --}}


    </div>
</x-app-layout>
