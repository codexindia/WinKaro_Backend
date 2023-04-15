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
                            @if ($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}<br />
                                    @endforeach
                                </div>
                            @endif
                            <form id="formAccountSettings" method="POST" action="{{ route('notification.push_alert') }}">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="Title" class="form-label">Title</label>
                                        <input class="form-control @error('title') is-invalid @enderror" type="text"
                                            value="{{ old('title') }}" id="Title" name="title"
                                            placeholder="This Is A Title" autofocus />
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label for="Meassage" class="form-label">Meassage</label>
                                        <input class="form-control @error('message') is-invalid @enderror" type="text"
                                            id="Meassage" name="message" value="{{ old('message') }}"
                                            placeholder="Todays Best Offers" />
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
        </div>

    </div>
@endsection
