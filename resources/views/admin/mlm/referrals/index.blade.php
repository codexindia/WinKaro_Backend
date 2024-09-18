@extends('admin.Layouts.Main')
@section('title')
    {{ 'Search Referrals' }}
@endsection
@push('styles')
    <style>
       
    </style>
@endpush
@section('main-container')
    
        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                @endif
                <div class="card">


                   <div class="card-body">
                    <form action="{{ route('referrals.search') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="refer_code">Refer Code:</label>
                            <input type="text" class="form-control" id="refer_code" value="{{ request('refer_code') }}" name="refer_code" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-4">Search</button>
                    </form>
                   
                    @if(isset($mainUser))
                    <div class="table-responsive text-nowrap">

                        <h5 class="mt-5">Main User: {{ $mainUser->name }}</h5>
                      
                        <table class="table table-bordered mt-3 referral-table">
                            <thead>
                                <tr>
                                    @for ($i = 1; $i <= 10; $i++)
                                        <th>Level {{ $i }}</th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($referrals as $referral)
                                    @include('admin.mlm.partials.referral', ['referral' => $referral, 'level' => 1])
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @endif
                </div>

            </div>
        </div>
    
@endsection
