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
                            <h5 class="card-header">Orders List</h5>
                        </div>
                        <div class="col mt-1">
                            <button class="btn btn-primary d-flex justify-content-end">Create New Task</button>
                        </div>
                    </div>


                    <div class="table-responsive text-nowrap">

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th>Coins</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                <tr>
                                    <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>Angular
                                            Project</strong></td>
                                    <td>Albert Cook</td>
                                    <td>

                                    </td>
                                    <td><span class="badge bg-label-primary me-1">Active</span></td>
                                    <td>


                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">

            </div>
        </div>
    @endif
@endsection
