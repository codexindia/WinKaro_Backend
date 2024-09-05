@extends('manager.Layouts.Main')
@section('title')
    {{ 'Manage Withdraw' }}
@endsection
@section('main-container')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br />
                    @endforeach
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif



            <div class="alert alert-info">
               Your Withdraw Will Process Within 24 Hours After Request
            </div>
            <div class="card" style="background-color: #696cff33;">

                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 style="color:#696cff;">Available Coins</h5>
                            <h4 class="fw-bold" style="color:#696cff;"><img
                                    src="{{ url('AdminAssets/assets/img/wallet.svg') }}"
                                    alt="chart success" style="height: 30px;" class="rounded" />
                                {{ $availableBalance }} Coins | ₹{{ $availableBalance/ 100 }}</h4>
                        </div>
                        <div class="col">
                            <div class="d-flex justify-content-end">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#basicModal"
                                    class="btn btn-primary mt-4"><i class="uil uil-plus"></i> Withdraw</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card">
                <h5 class="card-header"> Request History</h5>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Transaction ID</th>
                                    <th>Coins</th>
                                    <th>Rupees</th>
                                    <th>Date</th>
                                    <th>Status</th>

                                </tr>
                            </thead>
                            <tbody>
                               
                                @foreach ($withdrawals as $item)
                                  
                                    <tr>
                                        <td>
                                            {{ $loop->index+1 }}
                                        </td>
                                        <td>
                                            {{ $item->transaction_id }}
                                        </td>
                                        <td class="fw-bold">
                                            {{ $item->coins }}
                                        </td>
                                        <td class="fw-bold">
                                            ₹{{ $item->coins/100 }}
                                        </td>
                                        <td>
                                            {{ $item->created_at->format('d-m-Y') }}
                                        </td>
                                        <td>
                                            @if ($item->status == 'pending')
                                                <span class="badge bg-label-info me-1">Pending</span>
                                            @elseif($item->status == 'approved')
                                                <span class="badge bg-label-success me-1">Approved</span>
                                            @elseif($item->status == 'rejected')
                                                <span class="badge bg-label-danger me-1">Rejected</span>
                                            @else
                                                <span class="badge bg-label-danger me-1">{{ $item->status }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>





            <!-- Modal -->
            <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel1">Request For Withdraw</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col mb-3">
                                    <form action="{{ route('manager.withdraw.submit') }}" method="post">
                                        @csrf
                                      
                                        {{ Form::wtextbox('coins') }}
                                       
                                        {{ Form::wtextbox('upi_id') }}
                                        
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary">Request</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
