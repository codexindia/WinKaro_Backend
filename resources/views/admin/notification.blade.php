@extends('admin.Layouts.Main')
@section('title')
    {{ 'Notifications' }}
@endsection
@section('main-container')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <h5 class="card-header">Send Notificatons</h5>
                        <!-- Account -->

                        <hr class="my-0" />
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form id="formAccountSettings" method="POST" action="{{ route('notification.push_alert') }}">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        {{ Form::wtextbox('title') }}
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        {{ Form::wtextbox('message') }}
                                    </div>


                                </div>
                                <div class="mt-2">
                                    <button type="submit" class="btn btn-primary me-2">Send</button>
                                    <a href="{{ url()->previous() }}"> <button type="button"
                                            class="btn btn-outline-secondary">Cancel</button></a>
                                </div>
                            </form>
                        </div>
                        <!-- /Account -->
                    </div>

                </div>
            </div>
            {{-- <div class="card">
                <h5 class="card-header">Last Notifications Lists</h5>
                <div class="table table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Title</th>
                                <th class="text-center">Message</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Provider</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($getlist as $data)
                                <tr>
                                    <td class="text-center">{{ $data->id }}</td>
                                    <td class="text-center fw-bold">{{ $data->title }}</td>
                                    <td class="text-center" style="max-width: 13rem;">
                                        {{ $data->message }}

                                    </td>
                                    <td class="text-center">
                                        @if ($data->status == 'true')
                                            <span class="badge bg-label-success me-1">Pushed</span>
                                        @else
                                            <span class="badge bg-label-danger me-1">Not Pushed</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <img style="max-height: 45px;"
                                            src="{{ url('AdminAssets/Source/assets/img/OneSignal_Logo-removebg-preview.png') }}"
                                            alt="Avatar" class="rounded-circle" />
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
                <div class="p-3">
                    {{ $getlist->links('pagination::bootstrap-5') }}
                </div>
            </div> --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <h5 class="card-header">App Popup Message</h5>
                        <!-- Account -->

                        <hr class="my-0" />
                        <div class="card-body">
                            @if (session('success_popup'))
                                <div class="alert alert-success">
                                    {{ session('success_popup') }}
                                </div>
                            @endif
                            {!! Form::open(['route' => 'notification.push_popup', 'files' => true]) !!}

                            <div class="row">

                                <div class="mb-3 col-md-6">
                                    {{ Form::wtextbox('description', $old != null ? $old->description : '') }}
                                </div>
                                <div class="mb-3 col-md-6">
                                    {{ Form::wtextbox('action_url', $old != null ? $old->action_url : '') }}
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="formFile" class="form-label">Choose Image To Upload</label>
                                    <input class="form-control" type="file" id="formFile" name="image">
                                    @error('image')
                                        <p class="text-danger" style="text-transform:capitalize;">{{ $message }}</p>
                                    @enderror
                                </div>
                                @if ($old != null && $old->image_src != null)
                                    <div class="mb-3 col-md-6">
                                        <label for="formFile" class="form-label">Image</label>
                                        <img src="{{ $old->image_src }}" class="form-control"
                                            style="max-height:12rem; max-width:13rem;" alt="" srcset="">
                                    </div>
                                @endif
                                {{ Form::wcheckbox('active', 'Active', $old != null ? $old->status : '') }}


                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Save</button>
                                <a href="{{ url()->previous() }}"> <button type="button"
                                        class="btn btn-outline-secondary">Cancel</button></a>
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <!-- /Account -->
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
