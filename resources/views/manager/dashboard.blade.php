@extends('manager.Layouts.Main')
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
                            <h3 class="card-title text-nowrap mb-1">{{ $totalUsers }}</h3>
                            <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> Total Users
                                (LifeTime)</small>
                        </div>
                    </div>
                </div>
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
                            <span>Today Users</span>
                            <h3 class="card-title text-nowrap mb-1">{{ $todayUsers }}</h3>
                            <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i>For Date
                                ({{ date('d/m') }})</small>
                        </div>
                    </div>
                </div>

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
                            <span>Today Completed</span>
                            <h3 class="card-title text-nowrap mb-1">{{ $todayCompleted }}</h3>
                            <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> Today Task
                                Count</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
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
                            <span>Available Coins</span>
                            <h3 class="card-title text-nowrap mb-1">{{ $availableCoins }}</h3>
                            <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> Withdrawable
                                Coin</small>
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
                            <span>Pending Coins</span>
                            <h3 class="card-title text-nowrap mb-1">{{ $pendingCoins }}</h3>
                            <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> Recevied After
                                Approval</small>
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
                            <span>Total Completed</span>
                            <h3 class="card-title text-nowrap mb-1">{{ $totalCompleted }}</h3>
                            <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> OvarAll Count of All
                                Completed Task</small>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    @endsection
