@extends('admin.Layouts.Main')
@section('title')
    {{ 'Area Managers Edit' }}
@endsection
@section('main-container')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h4>Edit Area Manager</h4>
                </div>
                <div class="card-body">
                    <form id="" method="POST" action="{{ route('manager.editSubmitAreaManager') }}">
                        @csrf
                        <input type="hidden" name="userId" value="{{ $areamanager->id }}">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                
                                {{ Form::wtextbox('full_name',$areamanager->fullName) }}
                            </div>
                            <div class="mb-3 col-md-6">
                                {{ Form::wtextbox('phone_number',$areamanager->phoneNumber) }}
                            </div>
                            <div class="mb-3 col-md-6">
                                {{ Form::wtextbox('assigned_pincode',$areamanager->assignedPincode) }}
                            </div>
                            <div class="mb-3 col-md-6">
                                {{ Form::wtextbox('commission',$areamanager->commissionPercentage) }}
                            </div>
                            <div class="mb-3 col-md-6">
                                {{ Form::wtextbox('password',null) }}
                            </div>


                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Update</button>
                            <a href="{{ url()->previous() }}"> <button type="button"
                                    class="btn btn-outline-secondary">Cancel</button></a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
