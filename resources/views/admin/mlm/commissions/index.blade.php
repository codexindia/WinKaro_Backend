@extends('admin.Layouts.Main')
@section('title')
    {{ 'Commsion Manager' }}
@endsection
@push('styles')
    <style>

    </style>
@endpush
@section('main-container')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            
            @if (session('error'))
                <div class="alert alert-danger mt-3">{{ session('error') }}</div>
            @endif
            <div class="card">


                <div class="card-body">
                    <div class="container mt-5">
                        <h2>Set MLM Commissions</h2>
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <form action="{{ route('commissions.update') }}" method="POST">
                            @csrf
                            <table class="table table-bordered mt-3">
                                <thead>
                                    <tr>
                                        <th>Level</th>
                                        <th>Commission (%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 1; $i <= 10; $i++)
                                        <tr>
                                            <td>Level {{ $i }}</td>
                                            <td>
                                                <input type="number" class="form-control" name="commissions[]" value="{{ $commissions->where('level', $i)->first()->percentage ?? 0 }}" min="0" max="100" step="0.01">
                                            </td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                            <button type="submit" class="mt-3 btn btn-primary">Save</button>
                        </form>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $('input[type="number"]').on('input', function() {
                                var value = $(this).val();
                                if (value < 0) {
                                    $(this).val(0);
                                } else if (value > 100) {
                                    $(this).val(100);
                                }
                            });
                        });
                    </script>
                </div>

            </div>
        </div>
    @endsection
