@extends('admin.Layouts.Main')
@section('title')
    {{ 'Area Managers' }}
@endsection
@section('main-container')
    @if ($view == 'List')
        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="card">


                    <div class="row m-3">
                        <div class="col">
                            <h5 class="card-header">Area Managers</h5>
                        </div>
                        <div class="col mt-1">
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('manager.createNewPage') }}"><button class="btn btn-primary">Create Manager</button></a>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive text-nowrap">

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">FullName</th>
                                    <th class="text-center">available Balance</th>
                                    <th class="text-center">Phone Number</th>
                                    <th class="text-center">Assigned Pincode</th>
                                    <th class="text-center">Registered At</th>
                                    <th class="text-center">Action</th>

                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                              
                                @foreach ($allAreaManagers as $AreaManagers)
                                    
                                    <tr>
                                        <td class="text-center">{{ $loop->index+1 }}</td>
                                        <td class="text-center">{{ $AreaManagers->fullName }}</td>
                                        <td class="text-center">{{ $AreaManagers->availableBalance }} 
                                        <td class="text-center">{{ $AreaManagers->phoneNumber }}</td>

                                        <td class="text-center">{{ $AreaManagers->assignedPincode }}</td>
                                        <td class="text-center">{{ date('m-d-Y h:i:s a', strtotime($AreaManagers->created_at)) }}
                                        </td>
                                       
                                        <td class="text-center">Edit</td>
                                    </tr>



                                   
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="container d-flex justify-content-end mt-3">
                        {!! $allAreaManagers->links() !!}
                    </div>
                </div>
               
            </div>
        </div>
    @else
    @endif
@endsection
