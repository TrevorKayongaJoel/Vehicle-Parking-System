@extends('layouts.adminapp', ['activePage' => 'payments', 'title' => 'Add Payment'])

@section('content')
<div class="container mt-5">
    <div class="card shadow rounded border-0">
        <div class="card-header bg-dark text-white">
            <h4>Add Fake/Cash Payment</h4>
        </div>
        <div class="card-body">
            @if(session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('payments.store') }}">
                @csrf

                <div class="form-group">
                    <label>Payment Type</label>
                    <select name="type" class="form-control" required>
                        <option value="cash">Cash</option>
                        <option value="fake">Fake</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Amount</label>
                    <input type="number" name="amount" class="form-control" step="0.01" required>
                </div>

                <div class="form-group">
                    <label>Reference</label>
                    <input type="text" name="reference" class="form-control">
                </div>

                <div class="form-group">
                    <label>Notes</label>
                    <textarea name="notes" class="form-control" rows="3"></textarea>
                </div>

                <button type="submit" class="btn btn-success">Record Payment</button>
            </form>
        </div>
    </div>
</div>
@endsection
