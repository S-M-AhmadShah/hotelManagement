<!DOCTYPE html>
<html>
<head>
    <title>Redirecting to JazzCash...</title>
</head>
<body>
    <form id="jazzcash-form" method="POST" action="{{ $url }}">
        @foreach ($postData as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
    </form>
    <script>
        document.getElementById('jazzcash-form').submit();
    </script>
</body>
</html>
