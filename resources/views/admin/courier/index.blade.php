@extends('admin.layouts.master')
@section('title', 'Couriers & rates')
@section('content')
@include('admin.partials.page-header', [
    'title' => 'Couriers & rates',
    'subtitle' => 'Rates here pre-fill commission and service fee when you price an order.',
    'crumbs' => ['Configuration' => null, 'Couriers & rates' => null],
    'actions' => '<a href="'.e(route('admin-couriers.create')).'" class="btn btn-primary"><i class="bx bx-plus me-1"></i>New courier</a>',
])
<div class="card">
    <div class="card-body">
        @if($courier->isEmpty())
            <div class="adm-empty"><i class="bx bx-car"></i>No couriers yet.</div>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                <tr>
                    <th>Courier</th>
                    <th>Status</th>
                    <th class="text-end">Domestic commission</th>
                    <th class="text-end">Intl commission</th>
                    <th class="text-end">Service fee (dom / intl)</th>
                    <th>Pickup window</th>
                    <th class="text-end">Orders</th>
                    <th class="text-end">Actions</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($courier as $s)
                    <tr>
                        <td><a href="{{ route('admin-couriers.edit', $s->id) }}" class="fw-semibold">{{ $s->name }}</a></td>
                        <td>@if($s->status==1)<span class="adm-pill adm-pill-success">Active</span>@else<span class="adm-pill adm-pill-neutral">Inactive</span>@endif</td>
                        <td class="text-end">{{ $s->comission }}% <span class="text-muted small">/ doc {{ $s->comission_document }}%</span></td>
                        <td class="text-end">{{ $s->comission_intl }}% <span class="text-muted small">/ doc {{ $s->comission_document_intl }}%</span></td>
                        <td class="text-end text-nowrap">AED {{ $s->service_fee }} / {{ $s->service_fee_intl }}</td>
                        <td class="small">{{ $s->start_time }}–{{ $s->end_time }}</td>
                        <td class="text-end"><a href="{{ route('admin.order.index', ['courier' => $s->id]) }}">{{ number_format($usage[$s->id] ?? 0) }}</a></td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('admin-couriers.edit', $s->id) }}" class="btn btn-sm btn-light"><i class="bx bx-edit-alt me-1"></i>Edit rates</a>
                            <form action="{{ route('admin-couriers.update', $s->id) }}" method="POST" class="d-inline"
                                  data-confirm="{{ $s->status ? 'Deactivate '.$s->name.'? It stays on existing orders but is marked inactive.' : 'Activate '.$s->name.'?' }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="toggle_status" value="{{ $s->status ? 0 : 1 }}">
                                <button class="btn btn-sm {{ $s->status ? 'btn-outline-secondary' : 'btn-outline-success' }}" type="submit">{{ $s->status ? 'Deactivate' : 'Activate' }}</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection
