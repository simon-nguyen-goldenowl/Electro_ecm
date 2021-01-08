

@extends('Layout')
@section('content')
    <div class="section">
        <div class="container">
            <div class="row">
                <h1>Password reset form</h1>
                <p>Fill this form to reset your password</p>
                <div class="alert alert-danger print-error-msg" style="display:none">
                    <ul></ul>
                </div>
                <form>
                    @csrf
                    <div class="form-group">
                        <label for="password">New Password: </label>
                        <input type="password" class="form-control" id="re_password" name="email" placeholder="Your New Password" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Confirm Password: </label>
                        <input type="password" class="form-control" id="re_confirm_password" name="confirm_email" placeholder="Confirm Password" required>
                        <span id='re_message'></span>
                    </div>
                </form>
                <button id="reset_submit" onclick="checkPassword()" class="primary-btn order-submit">Change</button>
            </div>
        </div>
        <p id="message" hidden>{{session()->get('message')}}</p>
    </div>
@stop
@push('scripts')
    <script>
        function checkPassword() {
            let password = $("#re_password").val();
            let confirm_password = $("#re_confirm_password").val();
            if(password !== confirm_password){
                $("#re_message").html("password is not match").css('color', 'red');
            } else {
                let key = params.get('key');
                $.ajax({
                    type: 'post',
                    url: '/password/{{$id}}/reset',
                    data: {
                        _method: "patch",
                        'reset_key': key,
                        'password': password,
                    },
                    success: function (data) {
                        alert('your password is updated. Log in to shop now');
                        location.replace('/')
                    },
                    error: function (data){
                        let errors = data.responseJSON.errors;
                        showError(errors);
                    }
                })
            }
        }
        function showError(msg){
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                let id = 're_' + key
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                $('#'+id).css('border-color', 'red');
                if(id === 're_password'){
                    $("#re_confirm_password").css('border-color', 'red');
                }
            });
        }
    </script>
@endpush
