@extends('admin.admin_master')

@section('admin')

    <div class="py-12">
        <div class="container mb-4">
            <div class="row">
                <h4 class="mb-2"> Admin Message</h4>
               
                <div class="col-md-12">
                    <div class="card">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ session('success') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="card-header">
                            <h4 class="card-title">All Message</h4>
                        </div>
                        <div class="card-body">

                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                    <th scope="col" width="5%">SL No</th>
                                    <th scope="col" width="10%">Name</th>
                                    <th scope="col" width="15%">Email</th>
                                    <th scope="col" width="15%">Subject</th>
                                    <th scope="col" width="30%">Message</th>
                                    <th scope="col" width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if($messages->count() > 0)
                                        @php($i = 1)
                                    @foreach ($messages as $message)
                                        <tr>
                                            <th scope="row">{{ $i++ }}</th>
                                            <td>{{ $message->name }}</td>
                                            <td>{{ $message->email }}</td>
                                            <td>{{ $message->subject }}</td>
                                            <td>{{ $message->message }}</td>
                                            
                                            
                                            <td>
                                                <a href="{{ route('delete.message', $message->id) }}"
                                                    onclick="return confirm('Are you sure you want to delete this message?');"
                                                    class="btn btn-danger btn-sm">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <strong>No Message Found</strong>
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
{{-- end of contact --}}
    </div>


    
@endsection