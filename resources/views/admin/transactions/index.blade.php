@extends('admin.layouts.master')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered dt-responsive  nowrap w-100">
                    <thead>
                    <tr>
                        <th scope="col">#ID</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Reference</th>
                        <th scope="col">Create At</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\TransactionModel::get() as $t)
                        <tr>
                        <th scope="row">{{ $t->id }}</th>
                        <td>AED {{ $t->amount }}</td>
                        <td>{{ $t->ref_point }}</td>
                        <td>{{ $t->created_at->diffForHumans(); }}</td>
                        <td></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
@endsection