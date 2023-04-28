@extends('admin.Layouts.Main')
@section('title')
    {{ 'Task Manage' }}
@endsection
@section('main-container')
    @if ($view == 'list')
        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="card">

                    <div class="row m-3">
                        <div class="col">
                            <h5 class="card-header">Task Submissions</h5>
                        </div>

                    </div>


                    <div class="table-responsive text-nowrap">

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">User Name</th>
                                    <th class="text-center">Task Name</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">Coins</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>

                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @php
                                    $i = 0;
                                    
                                @endphp
                                @foreach ($getmain as $item)
                                    @php
                                        $i++;
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $i }}</td>
                                        <td class="text-center">{{ $item->GetName->name }}</td>
                                        <td class="text-center">{{ ucwords($item->GetTask->task_name) }}</td>
                                        <td class="text-center">{{ ucwords($item->type) }}</td>

                                        <td class="text-center">
                                            <i style="font-size:1.3rem;" class="uil uil-coins text-warning"></i>
                                            {{ $item->reward_coin }}
                                        </td>
                                        @if ($item->status == 'processing')
                                            <td class="text-center"><span class="badge bg-label-primary">
                                                    {{ $item->status }}</span></td>
                                        @else
                                            <td class="text-center"><span class="badge bg-label-danger">
                                                    {{ $item->status }}</span></td>
                                        @endif
                                        <td class="text-center"><a
                                                href="{{ route('task.submission_details', $item->id) }}"><i
                                                    class="uil uil-arrow-circle-right text-success"
                                                    style="font-size:1.4rem;"></i></a></td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="container d-flex justify-content-end mt-3">
                        {!! $data->links() !!}
                      </div>
                </div>
            </div>
        </div>
    @else
        <script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
        <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />

        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="row">
                    <div class="col-md-12">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="card mb-4">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-header">Task Submission Details</h5>
                                </div>
                                <div class="col">
                                    <h5 class="card-header">Task Submission Record</h5>
                                </div>
                            </div>

                            <div class="card-body">

                                <div class="row">
                                    <div class="col">
                                        <table class="table table-bordered mb-4">

                                            <tbody>
                                                <tr>
                                                    <td>
                                                        Date
                                                    </td>
                                                    <td> <strong>{{ $data->created_at->format('d-M-Y h:i:s a') }}</strong>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        Customer Name
                                                    </td>
                                                    <td>
                                                        <strong>{{ $data->Getname->name }}</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Customer Phone
                                                    </td>
                                                    <td> <strong>{{ $data->Getname->phone }}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Reward Coin
                                                    </td>
                                                    <td> <strong> <i style="font-size:1.3rem;"
                                                                class="uil uil-coins text-warning">
                                                                &nbsp;{{ $data->reward_coin }}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Task Name
                                                    </td>
                                                    <td> <strong>{{ $data->GetTask->task_name }}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Task Type
                                                    </td>
                                                    <td> <strong>{{ ucwords($data->type) }}</strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col">
                                        <video id="player" style="max-height:17rem;" playsinline controls>
                                            <source src="{{ $data->proof_src }}" type="video/mp4" />
                                        </video>
                                    </div>

                                </div>
                                <div class="d-flex justify-content-end gap-2 mt-3">
                                    @if($data->status == "processing")
                                    <a href="{{ route('dashboard') }}"> <button type="button"
                                            class="btn btn-secondary">Back</button></a>
                                    <button type="button" class="btn btn-danger" onclick="reject($(this).attr('proof_id'))"
                                        proof_id={{ $data->id }}>Reject</button>

                                    <button type="button" class="btn btn-success" id="approve"
                                        onclick="accept($(this).attr('proof_id'))"
                                        proof_id={{ $data->id }}>Approve</button>
                                        @endif


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    function accept(proof_id) {
                        swal({
                                title: "Are you sure?",
                                text: "You Want To Approve This Task",
                                icon: "info",
                                buttons: true,
                                dangerMode: true,
                            })
                            .then((willDelete) => {

                                if (willDelete) {
                                    $.post("{{ route('task.change_status', 'Accept') }}", {
                                            proof_id: proof_id,
                                            _token: '{{ csrf_token() }}'
                                        },
                                        function(data, status) {
                                            if (data.status == 'true') {
                                                swal("Good job!", data.message, "success").then((value) => {
                                                    location.reload();
                                                });

                                            } else
                                                swal("Invalid", data.message, "error");
                                        },
                                        "json")
                                }

                            });
                    }

                    function reject(proof_id) {
                        swal("Kindly Provide Reson Of Rejection", {
                                content: "input",
                            })
                            .then((value) => {
                                $.post("{{ route('task.change_status', 'Reject') }}", {
                                        proof_id: proof_id,
                                        reason: value,
                                        _token: '{{ csrf_token() }}'
                                    },
                                    function(data, status) {
                                        if (data.status == 'true') {
                                            swal("Good job!", data.message, "success").then((value) => {
                                                location.reload();
                                            });

                                        } else
                                            swal("Invalid", data.message, "error");
                                    },
                                    "json")
                            });
                    }


                    $(document).ready(function() {
                        const player = new Plyr('#player');
                    });
                </script>
            </div>
        </div>
    @endif
@endsection
