@extends('admin.admin_master')

@section('admin')

    <div class="py-12">
        <div class="container mb-4">
            <div class="row">
                <h4> Contact Page</h4>
                <a href="{{ route('create.contact')}}" class="btn btn-primary ml-2 mb-2">Add Contact</a> <br>

                <div class="col-md-12">
                    <div class="card">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ session('success') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="card-header">
                            <h4 class="card-title">All Contact Data</h4>
                        </div>
                        <div class="card-body">

                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                    <th scope="col" width="5%">SL No</th>
                                    <th scope="col" width="30%">Contact Address</th>
                                    <th scope="col" width="20%">Contact Email</th>
                                    <th scope="col" width="15%">Contact Phone</th>
                                    <th scope="col" width="15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if($contacts->count() > 0)
                                        @php($i = 1)
                                    @foreach ($contacts as $contact)
                                        <tr>
                                            <th scope="row">{{ $i++ }}</th>
                                            <td>{{ $contact->address }}</td>
                                            <td>{{ $contact->email }}</td>
                                            <td>{{ $contact->phone }}</td>
                                            
                                            
                                            <td>
                                                <a href="{{ route('edit.contact', $contact->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="{{ route('delete.contact', $contact->id) }}"
                                                    onclick="return confirm('Are you sure you want to delete this contact?');"
                                                    class="btn btn-danger btn-sm">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <strong>No Contact Data Found</strong>
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