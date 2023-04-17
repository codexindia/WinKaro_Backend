@extends('admin.Layouts.Main')
@section('title')
    {{ 'Withdraw Manager' }}
@endsection
@section('main-container')
    @if ($view == 'List')
        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
                <div class="card">


                    <h5 class="card-header">Withdraw Requests</h5>


                    <div class="table-responsive text-nowrap">

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">User Name</th>
                                    <th class="text-center">Coins</th>
                                    <th class="text-center">Reference ID</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center" colspan="3">Action</th>

                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @php
                                    $i = 0;
                                    
                                @endphp
                                @foreach ($get as $item)
                                    @php
                                        $i++;
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $i }}</td>
                                        <td class="text-center">{{ $item->GetName->name }}</td>
                                        <td class="text-center">{{ $item->coins }}</td>
                                        <td class="text-center">{{ $item->ref_id }}</td>

                                        @if ($item->status == 'processing')
                                            <td class="text-center"><span class="badge bg-label-primary me-1">
                                                    {{ $item->status }}</span></td>
                                        @else
                                            <td class="text-center"><span class="badge bg-label-danger me-1">
                                                    {{ $item->status }}</span></td>
                                        @endif
                                        <td class="text-center">{{ date('m-d-Y h:i:s a', strtotime($item->expire_at)) }}
                                        </td>
                                        <td class="text-center"><i data-bs-toggle="modal" data-bs-target="#backDropModal{{ $i }}"
                                                class="uil uil-eye text-primary" style="font-size:20px;"></i></td>
                                        <td class="text-center"><a href="{{ route('withdraw.action',(['Action' => 'Reject','id' => $item->id])) }}"><i class="uil uil-ban text-danger"
                                                style="font-size:20px;"></i></a></td>
                                        <td class="text-center"><a href="{{ route('withdraw.action',(['Action' => 'Approve','id' => $item->id])) }}"><i class="uil uil-check-circle text-success"
                                                style="font-size:20px;"></i></a></td>
                                    </tr>



                                    {{-- modal start --}}
                <div class="modal fade" id="backDropModal{{ $i }}" data-bs-backdrop="static" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title" id="backDropModalTitle">Payment Address ({{ $item->GetName->name }})
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @php
                                    $decode = json_decode($item->account_data,true);
                                @endphp
                                <div class="row mx-auto">
                                    <h5 class="card-title mb-3">Type : {{ ucwords($decode['type']) }}</h5>
                                    <h5 class="card-title mb-0">Destination : {{ $decode['account_number'] }}</h5>
                                </div>

                            </div>
                            <div class="modal-footer">

                            </div>
                        </div>
                    </div>
                </div>
                {{-- modal end --}}
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
        </div>
    @else
    @endif
@endsection
