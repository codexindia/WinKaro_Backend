@extends('admin.Layouts.Main')
@section('title')
    {{ 'App Update' }}
@endsection
@section('main-container')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <h5 class="card-header">Push Update Alert</h5>
                        <!-- Account -->

                        <hr class="my-0" />
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form id="formAccountSettings" method="POST" action="{{ route('settings.appupdate.push') }}">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        {{ Form::wtextbox('version_code') }}
                                        <p class="text-success">Current Version Code :- @if($old != null){{ $old->version_code }}@else Not Available @endif</p>
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        {{ Form::wtextbox('app_link') }}
                                    </div>


                                </div>
                                <div class="">
                                    <button type="submit" class="btn btn-primary me-2">Send</button>
                                    <a href="{{ route('dashboard') }}"> <button type="button"
                                            class="btn btn-outline-secondary">Cancel</button></a>
                                </div>
                            </form>
                        </div>
                        <!-- /Account -->
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
