@extends('admin.Layouts.Main')
@section('title')
    {{ 'Offers' }}
@endsection
@section('main-container')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <h5 class="card-header">Install App Offer</h5>
                        <!-- Account -->

                        <hr class="my-0" />
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form id="formAccountSettings" method="POST" action="{{ route('offers.app_install_publish') }}">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        {{ Form::wtextbox('video_link',$old != null ? $old->video_link : '') }}
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        {{ Form::wtextbox('app_link',$old != null ? $old->app_link : '') }}
                                    </div>


                                </div>
                                <div class="mt-2">
                                    <button type="submit" class="btn btn-primary me-2">Publish</button>
                                    <a href="{{ url()->previous() }}"> <button type="button"
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
