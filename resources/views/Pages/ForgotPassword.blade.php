
@extends('Layout')
@section('content')
    <div class="section">
        <div class="container">
            <div class="row">
                <h1>Forgot your password?</h1>
                <p>Provide your email here to reset your password</p>
                <form action="/password/check-mail" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-danger" value="Send">
                    </div>
                </form>
            </div>
        </div>
        <p id="message" hidden>{{session()->get('message')}}</p>
    </div>
@stop
@push('scripts')
    <script>
        notify()
        function notify() {
            let val = $("#message").text();
            if(val !== '' ){
                alert(val)
            }
        }
    </script>
@endpush
