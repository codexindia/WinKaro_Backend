@extends('admin.Layouts.Main')
@section('title')
    {{ 'All Customers' }}
@endsection
@section('main-container')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            @if ($view == 'List')
                <div class="card">
                    <div class="py-2 d-flex justify-content-between">
                        <div class="">
                            <h5 class="card-header">Users List</h5>
                        </div>
                        <div>
                            <form class="row g-3 px-3 pt-3">
                                <div class="col-auto">
                                  <label for="inputPassword2" class="visually-hidden">Search User</label>
                                  <input type="text" class="form-control" value="{{ request()->get('q') }}" name="q" id="inputPassword2" placeholder="Name, Mobile , Email">
                                </div>
                                <div class="col-auto">
                                  <button type="submit" class="btn btn-primary mb-3">Search</button>
                                </div>
                              </form>
                        </div>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">Pictuer</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Available Balance</th>
                                    <th class="text-center">Joined At</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">


                                @foreach ($list as $lists)
                                    <tr>
                                        <td class="text-center"> <img style="max-height: 45px;"
                                                src="{{ $lists->profile_pic }}" alt="Avatar" class="rounded-circle" />
                                        </td>
                                        <td class="text-center fw-bold">{{ $lists->name }}</td>
                                        <td class="text-center">

                                            {{ $lists->email }}


                                        </td>
                                        <td class="text-center">
                                            <strong> <i style="font-size:1.3rem;" class="uil uil-coins text-warning"></i>
                                                &nbsp;{{ $lists->balance }}</strong>
                                        </td>
                                        <td class="text-center">
                                            <strong> {{ $lists->created_at->format('d/m/Y h:i:sA') }}</strong>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('users.view_details', $lists->id) }}">
                                                <i class="fa-regular fa-eye text-primary" style="font-size:20px;"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="container d-flex justify-content-end mt-3">
                        {!! $list->links() !!}
                    </div>
                </div>
            @elseif ($view == 'details')
                <div class="row">
                    <div class="col-md-12">
                        {{-- <ul class="nav nav-pills flex-column flex-md-row mb-3">
                                <li class="nav-item">
                                    <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i>
                                        Account</a>
                                </li>
                               
                            </ul> --}}
                        <div class="card mb-4">
                            <h5 class="card-header">Profile Details</h5>
                            <!-- Account -->
                            <div class="card-body">
                                <div class="d-flex align-items-start align-items-sm-center gap-4">
                                    <img src="{{ $data->profile_pic }}" alt="user-avatar" class="d-block rounded"
                                        height="100" width="100" id="uploadedAvatar" />
                                    <div class="button-wrapper">

                                        <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="This Feture Will Available On Next Update">
                                            <span class="d-none d-sm-block">Upload new photo</span>
                                            <i class="bx bx-upload d-block d-sm-none"></i>

                                        </label>

                                        <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-0" />
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                <form id="formAccountSettings" method="POST" onsubmit="return false">
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="firstName" class="form-label">Full Name</label>
                                            <input class="form-control" type="text" value="{{ $data->name }}"
                                                id="firstName" name="Name" value="John" autofocus readonly />
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label for="email" class="form-label">E-mail</label>
                                            <input class="form-control" type="text" id="email" name="email"
                                                value="{{ $data->email }}" placeholder="john.doe@example.com" readonly />
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label" for="phoneNumber">Phone Number</label>
                                            <div class="input-group input-group-merge">
                                                <input class="form-control" type="text" id="phoneNumber" name="phone"
                                                    value="{{ $data->phone }}" placeholder="9102938182" readonly />
                                            </div>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label" for="Coins">Available Coins</label>
                                            <div class="input-group input-group-merge">
                                                <input class="form-control" type="text" id="Coins" name="Coins"
                                                    value="{{ $data->balance }}" placeholder="Coins" readonly />
                                            </div>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="organization" class="form-label">Registered At</label>
                                            <input type="text" class="form-control" id="organization"
                                                name="organization" value="{{ $data->created_at->format('d-m-Y') }}"
                                                readonly />
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="organization" class="form-label">Refered By</label>
                                            <input type="text" class="form-control" id="organization"
                                                name="organization"
                                                value="@if ($data->GetReferredBy != null) {{ $data->GetReferredBy->name }}@else Not Referred @endif"
                                                readonly />
                                        </div>

                                    </div>
                                    {{-- <div class="mt-2">
                                        <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                        <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                                    </div> --}}
                                </form>
                            </div>
                            <!-- /Account -->
                        </div>
                        <div class="card">
                            <h5 class="card-header">Deactive Account</h5>
                            <div class="card-body">

                                @if ($data->UserBlocked()->exists())
                                    <div class="mb-3 col-12 mb-0">
                                        <div class="alert alert-info">
                                            <h6 class="alert-heading fw-bold mb-1">Are you sure you want to Activation
                                                This
                                                account?</h6>
                                            <p class="mb-0">Once you Active This account, They Can Login Again</p>
                                        </div>
                                    </div>

                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="accountActivation"
                                            id="accountActivation" required />

                                        <label class="form-check-label" for="accountActivation">I confirm account
                                            Activation</label>
                                    </div>
                                    <a
                                        href="{{ route('users.action_perform', ['Action' => 'Active', 'id' => $data->id]) }}">
                                        <button type="button" onclick="return checkbox()" id="block_un_btn"
                                            class="btn btn-success deactivate-account">Activate
                                            Account</button></a>
                                @else
                                    <div class="mb-3 col-12 mb-0">
                                        <div class="alert alert-warning">
                                            <h6 class="alert-heading fw-bold mb-1">Are you sure you want to Deactivation
                                                This
                                                account?</h6>
                                            <p class="mb-0">Once you Deactive This account, They Can't Login Again</p>
                                        </div>
                                    </div>

                                    <div class="form-check mb-3">

                                        <input class="form-check-input" type="checkbox" name="accountActivation"
                                            id="accountActivation" required />
                                        <label class="form-check-label" for="accountActivation">I confirm account
                                            deactivation</label>
                                    </div>
                                    <a
                                        href="{{ route('users.action_perform', ['Action' => 'Deactive', 'id' => $data->id]) }}">
                                        <button type="button" id="block_un_btn" onclick="return checkbox()"
                                            class="btn btn-danger deactivate-account">Deactivate
                                            Account</button></a>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
                @section('scripts')
                    <script type="text/javascript">
                        function checkbox() {
                            if (!$('#accountActivation').is(':checked')) {
                                swal( "Opps!!","Please Tick The Checkbox To Perform This Action","warning");
                                return false;
                            } else {
                               return true;
                            }

                        }
                    </script>
                @endsection
            @endif
        </div>
    </div>
@endsection
