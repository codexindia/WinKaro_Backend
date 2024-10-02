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
                                    <input type="text" class="form-control" value="{{ request()->get('q') }}"
                                        name="q" id="inputPassword2" placeholder="Name, Mobile , Email">
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
                                    <th class="text-center">Status</th>
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
                                            @if ($lists->UserBlocked()->count() > 0)
                                                <span class="badge bg-danger">Deactive</span>
                                            @else
                                                <span class="badge bg-success">Active</span>
                                            @endif
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

                        <div class="card mb-4">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-header">Profile Details</h5>
                                <div class="mt-3 pe-5">
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">Coin Debit/Credit</button>
                                </div>
                            </div>
                            <hr>
                            </hr>
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
                                                <input class="form-control" type="text" id="phoneNumber"
                                                    name="phone" value="{{ $data->phone }}" placeholder="9102938182"
                                                    readonly />
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
                               
                                @if ($data->UserBlocked()->count() > 0)
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
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Debit Or Credit Coins</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">


                                    <form id="coinForm" method="post" action="{{ route('users.action_transaction') }}">
                                        @csrf
                                        <input type="hidden" value="{{ $data->id }}" name="user_id">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Amount</label>
                                            <input type="number" name="amount" class="form-control" required>

                                        </div>
                                        <select class="form-select" name="type" aria-label="Default select example"
                                            required>
                                            <option value="" selected>Select Transaction</option>
                                            <option value="debit">Debit</option>
                                            <option value="credit">Credit</option>

                                        </select>


                                    </form>





                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" id="coinFormSubmit" class="btn btn-success">Execute
                                        Transaction</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (session('success'))
                        <script type="text/javascript">
                            swal("Great!!", "{{ session('success') }}", "success");
                        </script>
                    @endif
                    <script type="text/javascript">
                        $("#coinFormSubmit").click(function() {
                            var formData = $("#coinForm").serializeArray();
                            if (formData[0].value == "") {
                                swal("Opps!!", "Invalid Amount You Have Enter", "warning");
                                return false;
                            } else if (formData[1].value == "") {
                                swal("Opps!!", "Select Transaction Type", "warning");
                                return false;
                            }
                            $("#coinForm").submit(); // Submit the form
                        });

                        function checkbox() {
                            if (!$('#accountActivation').is(':checked')) {
                                swal("Opps!!", "Please Tick The Checkbox To Perform This Action", "warning");
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
