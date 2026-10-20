@extends('admin.layouts.master')
@section('title', 'Wallet top-ups')
@section('content')
@include('admin.partials.page-header', [
    'title' => 'Wallet top-ups',
    'subtitle' => number_format($topups->count()).' top-ups · AED '.number_format($topups->sum('amount'), 2).' in total. New top-ups are no longer taken; this is the history.',
    'crumbs' => ['Wallet top-ups' => null],
])
<div class="card">
    <div class="card-body">
        <table id="datatable" class="table table-hover align-middle w-100">
            <thead>
            <tr><th>#</th><th>Customer</th><th class="text-end">Amount</th><th>Payment reference</th><th>Date</th></tr>
            </thead>
            <tbody>
                @foreach($topups as $topup)
                @php $cust = $customers[$topup->customer_id] ?? null; @endphp
                <tr>
                    <td data-order="{{ $topup->id }}">{{ $topup->id }}</td>
                    <td>
                        @if($cust)
                            <a href="{{ route('admin.single.customer', $cust->id) }}">{{ $cust->name }}</a><div class="small text-muted">{{ $cust->email }}</div>
                        @else
                            <span class="text-muted">Customer #{{ $topup->customer_id }}</span>
                        @endif
                    </td>
                    <td class="text-end text-nowrap" data-order="{{ $topup->amount }}">AED {{ number_format((float) $topup->amount, 2) }}</td>
                    <td><code class="small">{{ $topup->payment_intent }}</code></td>
                    <td data-order="{{ $topup->created_at->timestamp }}" class="small text-muted text-nowrap">{{ $topup->created_at->format('d M Y, H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@push('scripts')
<script>$(function () { $('#datatable').DataTable().order([0, 'desc']).draw(); });</script>
@endpush
