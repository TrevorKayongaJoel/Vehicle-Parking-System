@extends('layouts.attendantapp', ['activePage' => 'payments', 'title' => 'Add Payment'])


@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header">
            <h4>Add Cash/Fake Payment</h4>
        </div>
        <div class="card-body">
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
                    <input type="number" step="0.01" name="amount" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Reference (optional)</label>
                    <input type="text" name="reference" class="form-control">
                </div>
                <div class="form-group">
                    <label>Notes (optional)</label>
                    <textarea name="notes" class="form-control"></textarea>
                </div>
                <button class="btn btn-primary">Add Payment</button>
            </form>
        </div>
    </div>
</div>
@endsection
