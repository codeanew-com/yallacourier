{{-- Suspend/ban/disable (opens the shared dialog) or reactivate (with confirmation). Params: customer, size? --}}
@can('manageAccess', $customer)
    @if($customer->isBlocked())
        <form method="post" action="{{ route('admin.customer.status', $customer->id) }}" class="d-inline"
              data-confirm="Reactivate {{ $customer->name }}? They will be able to log in again.">
            @csrf
            <input type="hidden" name="action" value="reactivate">
            <button type="submit" class="btn {{ $size ?? 'btn-sm' }} btn-outline-success"><i class="bx bx-check-shield me-1"></i>Reactivate</button>
        </form>
    @else
        <button type="button" class="btn {{ $size ?? 'btn-sm' }} btn-outline-danger" data-bs-toggle="modal" data-bs-target="#accessModal"
                data-url="{{ route('admin.customer.status', $customer->id) }}" data-name="{{ $customer->name }}">
            <i class="bx bx-block me-1"></i>Suspend / ban
        </button>
    @endif
@endcan
