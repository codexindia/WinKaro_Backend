@extends('admin.Layouts.Main')
@section('title')
    {{ 'Area Managers' }}
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
                <div class="card-body">
                    <form id="" method="POST" action="{{ route('manager.createNewSubmit') }}">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                {{ Form::wtextbox('full_name') }}
                            </div>
                            <div class="mb-3 col-md-6">
                                {{ Form::wtextbox('phone_number') }}
                            </div>
                            <div class="mb-3 col-md-6">
                                {{ Form::wtextbox('assigned_pincode') }}
                            </div>
                            <div class="mb-3 col-md-6">
                                {{ Form::wtextbox('password') }}
                            </div>


                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Submit</button>
                            <a href="{{ url()->previous() }}"> <button type="button"
                                    class="btn btn-outline-secondary">Cancel</button></a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
