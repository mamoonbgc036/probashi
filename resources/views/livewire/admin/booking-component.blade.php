<div>
    <h1>Booking List</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Package</th>
                <th>From Date</th>
                <th>To Date</th>
                <th>Number of Days</th>
                <th>Price</th>
                <th>Booking Price</th>
                <th>Total Amount</th>
                <th>Payment Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
                <tr>
                    <td>{{ $booking->id }}</td>
                    <td>{{ $booking->user->name }}</td>
                    <td>{{ $booking->package->name }}</td>
                    <td>{{ $booking->from_date }}</td>
                    <td>{{ $booking->to_date }}</td>
                    <td>{{ $booking->number_of_days }}</td>
                    <td>£{{ $booking->price }}</td>
                    <td>£{{ $booking->booking_price }}</td>
                    <td>£{{ $booking->total_amount }}</td>
                    <td>{{ $booking->payment_status }}</td>
                    <td>
                        <a href="{{ route('admin.bookings.show', ['id' => $booking->id]) }}" class="btn btn-primary">View Details</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
