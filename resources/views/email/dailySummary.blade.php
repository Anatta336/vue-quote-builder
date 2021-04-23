<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quote</title>
</head>
{{-- some email clients strip out the first <head>, so styling in a second! --}}
<head>
    <style>
        body {
            font-family: sans-serif;
            line-height: 1.6;
        }
        table {
            border: 1px solid #000;
        }
        td {
            padding: 3px;
        }
    </style>
</head>
<body>
    <p>Quotes created in the past 24 hours:</p>
    <table>
        <tr>
            <th>Customer</th>
            <th>Subtotal</th>
            <th>Link</th>
        </tr>
        @foreach ($quotes as $quote)
        <tr>
            <td>{{ $quote->customer_name }}</td>
            <td>£{{ number_format($quote->subTotal() * 0.01, 2) }}</td>
            <td><a href="{{ Illuminate\Support\Facades\Config::get('app.url') . '/quotes/' . $quote->id }}">View</a></td>
        </tr>
        @endforeach
    </table>
</body>
</html>


