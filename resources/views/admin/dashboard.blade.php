@extends('admin.Layouts.Main')
@section('title')
    {{ 'Dashboard' }}
@endsection
@section('main-container')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">

                <div class="col-sm">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">

                                <div class="avatar card d-flex aligns-items-center justify-content-center p-2"
                                style="background-color: #0092E425;">
                                <img src="{{ url('AdminAssets/assets/img/icons/unicons/users-alt.svg') }}"
                                    alt="chart success" class="rounded" />
                                </div>

                            </div>
                            <span>Total Users</span>
                            <h3 class="card-title text-nowrap mb-1">{{ $main['total_users'] }}</h3>
                            <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +100.00%</small>
                        </div>
                    </div>
                </div>

                <div class="col-sm">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">

                                <div class="avatar card d-flex aligns-items-center justify-content-center p-2"
                                style="background-color: #3DE40025;">
                                <img src="{{ url('AdminAssets/assets/img/icons/unicons/money-withdrawal.svg') }}"
                                    alt="chart success" class="rounded" />
                                </div>

                            </div>
                            <span>Withdraw Request</span>
                            <h3 class="card-title text-nowrap mb-1">{{ $main['pending_withdraw'] }}</h3>
                            <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +100.00%</small>
                        </div>
                    </div>
                </div>

                <div class="col-sm">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">

                                <div class="avatar card d-flex aligns-items-center justify-content-center p-2"
                                    style="background-color: #E4490025;">
                                    <img src="{{ url('AdminAssets/assets/img/icons/unicons/cloud-question.svg') }}"
                                        alt="chart success" class="rounded" />
                                </div>

                            </div>
                            <span>Pending Submissions</span>
                            <h3 class="card-title text-nowrap mb-1">{{ $main['pending_submissions'] }}</h3>
                            <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +100.00%</small>
                        </div>
                    </div>
                </div>

                <div class="col-sm">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">

                                <div class="avatar card d-flex aligns-items-center justify-content-center p-2"
                                    style="background-color: #ECE53325;">
                                    <img src="{{ url('AdminAssets/assets/img/icons/unicons/ban.svg') }}"
                                        alt="chart success" class="rounded" />
                                </div>

                            </div>
                            <span>Expired Task</span>
                            <h3 class="card-title text-nowrap mb-1">{{ $main['expired_task'] }}</h3>
                            <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +100.00%</small>
                        </div>
                    </div>
                    
                </div>

            </div>
        </div>
    @endsection
