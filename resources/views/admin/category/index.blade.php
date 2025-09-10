<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          All Category
            
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container mb-4">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ session('success') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
                            </div>
                        @endif
                        <div class="card-header">
                            <h4 class="card-title">All Categories</h4>
                        </div>
                        <div class="card-body">
                            <p class="card-text">List of all categories</p>
                  

                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                    <th scope="col">SL No</th>
                                    <th scope="col">Category Name</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if($categories->count() > 0)
                                @foreach ($categories as $category)
                                    <tr>
                                        <th scope="row">{{ $categories->firstItem() + $loop->index }}</th>
                                        <td>{{ $category->category_name }}</td>
                                        <td>{{ $category->user->name }}</td>
                                        <td>
                                            @if($category->created_at == NULL)
                                            <span class="text-danger">No Date Set </span>
                                            @else
                                            {{ Carbon\Carbon::parse($category->created_at)->diffForHumans() }}
                                        </td>
                                        @endif
                                        <td>
                                            <a href="{{ route('edit.category', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="{{ route('delete.category', $category->id) }}" class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <strong>No Categories Found</strong>
                                    </td>
                                </tr>
                                @endif
                                </tbody>
                            </table>
                            {{ $categories->links() }}
                      </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Add Category</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('store.category') }}" method="POST">
                                @csrf
                                <div class="mb-2">
                                    <label for="category_name" class="form-label">Category Name</label>
                                    <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Enter category name">
                                    @error('category_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Add Category</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
{{-- end of all categories --}}

{{-- trashed categories --}}
 <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Trashed Categories</h4>
                        </div>
                        <div class="card-body">
                            <p class="card-text">List of all trashed categories</p>


                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                    <th scope="col">SL No</th>
                                    <th scope="col">Category Name</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Deleted At</th>
                                    <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if($trashed_categories->count() > 0)
                                @foreach ($trashed_categories as $category)
                                    <tr>
                                        <th scope="row">{{ $trashed_categories->firstItem() + $loop->index }}</th>
                                        <td>{{ $category->category_name }}</td>
                                        <td>{{ $category->user->name }}</td>
                                        <td>
                                            @if($category->deleted_at == NULL)
                                            <span class="text-danger">No Date Set </span>
                                            @else
                                            {{ Carbon\Carbon::parse($category->deleted_at)->diffForHumans() }}
                                        </td>
                                        @endif
                                        <td>
                                            <a href="{{ route('restore.category', $category->id) }}" class="btn btn-info btn-sm">Restore</a>
                                            <a href="{{ route('pdelete.category', $category->id) }}" class="btn btn-danger btn-sm">Permanently Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <strong>No Trashed Categories Found</strong>
                                    </td>
                                </tr>
                                @endif
                                </tbody>
                            </table>
                            {{ $trashed_categories->links() }}
                      </div>
                    </div>
                </div>

                <div class="col-md-4">
                 
                </div>

            </div>
        </div>
{{-- end of trashed categories --}}
    </div>
</x-app-layout>
