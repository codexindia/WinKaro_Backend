@extends('admin.Layouts.Main')
@section('title')
    {{ 'Offers' }}
@endsection
@section('main-container')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
            <div class="row">
                {{-- For Telegram Submissions --}}
                <div class="col">
                    <div class="card">
                        <div class="row m-3">
                            <div class="col">
                                <h5 class="card-header">Telegram Offers Checklist</h5>
                            </div>
                        </div>
                        <div class="table-responsive text-nowrap">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Full Name</th>
                                        <th class="text-center">Telegram UserName</th>

                                        <th class="text-center" colspan="2">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @php
                                        $i = 0;
                                        
                                    @endphp
                                    @foreach ($telegram_checklist as $item)
                                        @php
                                            $i++;
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $i }}</td>
                                            <td class="text-center">{{ $item->Getname->name }}</td>
                                            <td class="text-center">{{ json_decode($item->attributes, true)['username'] }}
                                            </td>

                                            <td class="text-center"><a href="{{ route('offers.telegram.status',([$item->id,'reject'])) }}"><i
                                                class="uil uil-times-circle text-danger"
                                                style="font-size:1.4rem;"></i></a></td>
                                            <td class="text-center"><a href="{{ route('offers.telegram.status',([$item->id,'accept'])) }}"><i
                                                        class="uil uil-arrow-circle-right text-success"
                                                        style="font-size:1.4rem;"></i></a></td>
                                           
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- pagination --}}
                        <div class="container d-flex justify-content-end mt-3">
                            {!! $telegram_checklist->links() !!}
                        </div>
                        {{-- pagination --}}
                    </div>
                </div>
                {{-- End Telegram Submissions --}}
                {{-- For Lateast Clamied --}}
                <div class="col">
                    <div class="card">
                        <div class="row m-3">
                            <div class="col">
                                <h5 class="card-header">Last 10 Claimed Data</h5>
                            </div>
                        </div>
                        <div class="table-responsive text-nowrap">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Full Name</th>
                                        <th class="text-center">Offer</th>
                                        <th class="text-center">Time</th>

                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @php
                                        $i = 0;
                                        
                                    @endphp
                                    @foreach ($getalloffers as $item)
                                        @php
                                            $i++;
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $i }}</td>
                                            <td class="text-center">{{ $item->GetName->name }}</td>
                                            <td class="text-center">{{ $item->name }}</td>

                                            <td class="text-center">{{ $item->created_at->format('d/m/Y') }}</td>


                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- pagination --}}
                        <div class="container d-flex justify-content-end mt-3">
                            {!! $getalloffers->links() !!}
                        </div>
                        {{-- pagination --}}
                    </div>
                </div>
                {{-- End Lateast Clamied --}}
            </div>
        </div>
    </div>
@endsection
