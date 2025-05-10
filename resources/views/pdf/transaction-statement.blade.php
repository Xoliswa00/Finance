<!-- resources/views/pdf/transaction-statement.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <style>
        /* Add your CSS styles for the PDF here */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Transaction Statement</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Status</th>
            <th>User ID</th>
            <th>Description</th>
            <th>Amount</th>
            <th>Payment Method</th>
            <th>Transaction Date</th>
            <th>Payment Status</th>
            <th>Created At</th>
            <th>Updated At</th>
        </tr>

        @foreach ($transactions as $transaction)
        <tr>
            <td>{{ $transaction->id }}</td>
            <td>{{ $transaction->status }}</td>
            <td>{{ $transaction->user_id }}</td>
            <td>{{ $transaction->description }}</td>
            <td>{{ $transaction->amount }}</td>
            <td>{{ $transaction->payment_method }}</td>
            <td>{{ $transaction->transaction_date }}</td>
            <td>{{ $transaction->payment_status }}</td>
            <td>{{ $transaction->created_at }}</td>
            <td>{{ $transaction->updated_at }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
