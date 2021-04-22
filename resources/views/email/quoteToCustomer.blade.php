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
        .line-price {
            text-align: right;
        }
        .grand {
            font-weight: 700;
            margin-bottom: 2em;
        }
    </style>
</head>
<body>
    <p>Dear {{ $quote->customer_name }},</p>
    <p>Please find below the quote from our recent visit.</p>
    <table>
        <tr>
            <th>Product</th>
            <th>Count</th>
            <th>Line Price</th>
        </tr>
        @foreach ($quote->productsInQuote as $productInQuote)
        <tr>
            <td>{{ $productInQuote->product->name }}</td>
            <td>{{ $productInQuote->count }}</td>
            <td class="line-price">£{{ number_format($productInQuote->linePrice() * 0.01, 2) }}</td>
        </tr>
        @endforeach
    </table>
    <p>Sub Total: £{{number_format($quote->subTotal() * 0.01, 2)}}</p>
    <p>VAT Total: £{{number_format($quote->vatTotal() * 0.01, 2)}}</p>
    <p class="grand">Grand Total: £{{number_format($quote->grandTotal() * 0.01, 2)}}</p>
    <p>If you have any questions or queries please don't hesitate to get in contact.</p>
    <p>Yours Sincerely,<br>
    Example Builder</p>
</body>
</html>


