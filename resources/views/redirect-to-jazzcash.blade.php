<!DOCTYPE html>
<html>
<head>
    <title>Redirecting to JazzCash</title>
</head>
<body>
    {{-- {{dd($params);}} --}}
    <h3>Redirecting to JazzCash...</h3>
    <form action="https://sandbox.jazzcash.com.pk/CustomerPortal/transactionmanagement/merchantform"
    method="POST">
        @foreach($params as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
    </form>
</body>
</html>
