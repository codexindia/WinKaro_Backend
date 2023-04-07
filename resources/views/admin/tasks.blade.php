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
                                  <th>#</th>
                                    <th>Task Name</th>
                                    <th>Type</th>
                                    <th>Coins</th>
                                    <th>Status</th>
                                    <th>Actions</th>
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
                                  <td>{{ $i }}</td>
                                    <td>{{ $item->task_name }}</td>
                                    <td>{{ ucwords($item->type) }}</td>
                                    <td>
                                      {{ $item->reward_coin }}
                                    </td>
                                    <td><span class="badge bg-label-primary me-1"> {{ $item->status }}</span></td>
                                    <td>


                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                                {!! form::open(['route' => 'task.create']) !!}
                                <div class="row">
                                   
                                    <div class="col-md-6">
                                        {!! form::wtextbox('title') !!}
                                    </div>
                                    <div class="col-md-6">
                                        {!! form::wtextbox('publisher') !!}
                                    </div>
                                    <div class="col-md-6">
                                        {!! form::wtextbox('reward_coin') !!}
                                    </div>
                                    <div class="col-md-6">
                                      {!! form::wtextbox('action_url') !!}
                                  </div>
                                    <div class="col-md-6">
                                        {!! form::wtextbox('expire_after_hour') !!}
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="exampleFormControlSelect1" class="form-label">Choose Task Type</label>
                                        <select class="form-select" name="task_type" id="exampleFormControlSelect1"
                                            aria-label="Default select example">
                                            <option selected disabled>Choose One</option>
                                            <option value="youtube">Youtube Task</option>
                                            <option value="instagram">Instagram Task</option>
                                            <option value="yt_shorts">Youtube Shorts Task</option>
                                        </select>
                                        @error('task_type')
                                        <p class="text-danger" style="text-transform:capitalize;">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    {!! form::wsubmit('Create') !!}
                                </div>
                                {!! form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
