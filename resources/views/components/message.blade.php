@php
    $class = 'hidden';
    $message = '';
    if (session('success')) {
        $class = 'alert alert-success';
        $message = session('success');
    }
    if (session('error')) {
        $class = 'alert alert-danger';
        $message = session('error');
    }
@endphp
@if (session('success') || session('error'))
    <div class="{{ $class }}" role="alert">
        {{ $message }}
    </div>
@endif