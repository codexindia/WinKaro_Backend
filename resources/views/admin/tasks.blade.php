@extends('admin.Layouts.Main')
@section('title')
    {{ 'Task Manager' }}
@endsection
@section('main-container')
    @if ($view == 'list')
        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="card">

                    <div class="row m-3">
                        <div class="col">
                            <h5 class="card-header">Task List</h5>
                        </div>
                        <div class="col mt-1">
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('task.new') }}"><button class="btn btn-primary">Create New Task</button></a>
                            </div>
                        </div>
                    </div>


                    <div class="table-responsive text-nowrap">

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Task Name</th>
                                    <th class="text-center">Type</th>

                                    <th class="text-center">Coins</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Expire At</th>
                                    <th colspan="2" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @php
                                    $i = 0;

                                @endphp
                                @foreach ($data as $item)
                                    @php
                                        $i++;
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $i }}</td>
                                        <td class="text-center">{{ $item->task_name }}</td>
                                        <td class="text-center">{{ ucwords($item->type) }}</td>

                                        <td class="text-center">
                                            {{ $item->reward_coin }}
                                        </td>
                                        @if ($item->status == 'active')
                                            <td class="text-center"><span class="badge bg-label-primary me-1">
                                                    {{ $item->status }}</span></td>
                                        @else
                                            <td class="text-center"><span class="badge bg-label-danger me-1">
                                                    {{ $item->status }}</span></td>
                                        @endif
                                        <td class="text-center">{{ date('m-d-Y h:i:s a', strtotime($item->expire_at)) }}
                                        </td>
                                        <td class="text-center"><a href="{{ route('task.edit', $item->id) }}"><i
                                                    class="uil uil-edit text-success" style="font-size: 25px;"></i></a></td>
                                        <td class="text-center"><a href="{{ route('task.delete', $item->id) }}" onclick="return confirm('You Want To Delete')"><i
                                                    class="uil uil-trash text-danger" style="font-size: 25px;"></i></a></td>
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
                            <h5 class="card-header">Create New Task</h5>


                            <div class="card-body">
                                @if (isset($main))
                                    {!! form::open(['route' => 'task.update', 'files' => true]) !!}
                                @else
                                    {!! form::open(['route' => 'task.create', 'files' => true]) !!}
                                @endif
                                <div class="row">

                                    <div class="col-md-6">
                                        @if (isset($main))
                                            <input type="hidden" name="id" value="{{ $main->id }}">
                                        @endif
                                        @if (isset($main))
                                            {!! form::wtextbox('title', $main->title) !!}
                                        @else
                                            {!! form::wtextbox('title') !!}
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        @if (isset($main))
                                            {!! form::wtextbox('publisher', $main->publisher) !!}
                                        @else
                                            {!! form::wtextbox('publisher') !!}
                                        @endif


                                    </div>
                                    <div class="col-md-6">
                                        @if (isset($main))
                                            {!! form::wtextbox('reward_coin', $main->reward_coin) !!}
                                        @else
                                            {!! form::wtextbox('reward_coin') !!}
                                        @endif


                                    </div>
                                    <div class="col-md-6">
                                        @if (isset($main))
                                            {!! form::wtextbox('action_url', $main->action_url) !!}
                                        @else
                                            {!! form::wtextbox('action_url') !!}
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        @if (isset($main))
                                            @php
                                                $from = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $main->created_at);
                                                $to = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $main->expire_at);
                                                $diff_in_hours = $from->diffInHours($to);
                                            @endphp
                                            {!! form::wtextbox('expire_after_hour', $diff_in_hours) !!}
                                        @else
                                            {!! form::wtextbox('expire_after_hour') !!}
                                        @endif

                                    </div>
                                    <div class="col-md-6 mb-2">
                                        @if (isset($main))
                                            <label for="exampleFormControlSelect1" class="form-label">Choose Task
                                                Type</label>
                                            <select class="form-select" name="task_type" id="exampleFormControlSelect1"
                                                aria-label="Default select example">
                                                <option selected disabled>Choose One</option>
                                                <option @if ($main->type == 'youtube') selected @endif value="youtube">
                                                    Youtube Task</option>
                                                <option @if ($main->type == 'instagram') selected @endif
                                                    value="instagram">Instagram Task</option>
                                                <option @if ($main->type == 'website_check_in') selected @endif
                                                    value="website_check_in">Website Check In</option>
                                            </select>
                                        @else
                                            <label for="exampleFormControlSelect1" class="form-label">Choose Task
                                                Type</label>
                                            <select class="form-select" name="task_type" id="exampleFormControlSelect1"
                                                aria-label="Default select example">
                                                <option selected disabled>Choose One</option>
                                                <option value="youtube">Youtube Task</option>
                                                <option value="instagram">Instagram Task</option>
                                                <option value="website_check_in">Website Check In</option>
                                            </select>
                                        @endif
                                        @error('task_type')
                                            <p class="text-danger" style="text-transform:capitalize;">{{ $message }}</p>
                                        @enderror
                                    </div>

                                </div>
                                @if (isset($main))
                                    <div class="col-md-6 mb-2">
                                        <div class="mb-3">
                                            <label for="formFile" class="form-label">Thumbnail </label>
                                        </div>
                                        <img src="{{ $main->thumbnail_image }}" style="max-height:18rem;" alt="">
                                    </div>
                                @endif
                                <div class="form-group mx-auto">
                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">Choose Thumbnail To Upload</label>
                                        <input class="form-control" type="file" id="formFile" name="thumbnail">
                                    </div>
                                    @error('thumbnail')
                                        <p class="text-danger" style="text-transform:capitalize;">{{ $message }}</p>
                                    @enderror
                                </div>

                                <h6>Question And Answer</h6>
                                @for ($i = 1; $i <= 10; $i++)
                                    <div class="row">
                                        <div class="col-4 mb-2">
                                            {!! form::wtextbox('question_' . $i) !!}
                                        </div>
                                        <div class="col-4">
                                            {!! form::wtextbox('answer_' . $i) !!}
                                        </div>
                                        <div class="col-4 d-flex align-items-center pt-3">
                                            {!! form::wcheckbox('check_' . $i, 'required') !!}
                                        </div>
                                    </div>
                                @endfor

                                @if (isset($main))
                                    {!! form::wsubmit('Update') !!}
                                @else
                                    {!! form::wsubmit('Create') !!}
                                @endif
                                {!! form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
