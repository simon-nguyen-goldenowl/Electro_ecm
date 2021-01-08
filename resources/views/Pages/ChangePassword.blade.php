


@extends('Layout')
@section('content')
    <div class="section">
        <div class="container">
            <div class="row">
                <h1>Password change form</h1>
                <p>Fill this form to change your password</p>
                <div class="alert alert-danger print-error-msg" style="display:none">
                    <ul></ul>
                </div>
                <form>
                    @csrf
                    <div class="form-group">
                        <label for="password">Username: </label>
                        <input type="text" class="form-control" id="c_username" name="username" placeholder="Your username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Old Password: </label>
                        <input type="password" class="form-control" id="c_password" name="old_password" placeholder="Your Old Password" required>
                    </div>
                    <div class="form-group">
                        <label for="password">New Password: </label>
                        <input type="password" class="form-control" id="c_new_password" name="email" placeholder="Your New Password" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Confirm Password: </label>
                        <input type="password" class="form-control" id="confirm_new_password" name="confirm_email" placeholder="Confirm Password" required>
                        <span id='c_message'></span>
                    </div>
                </form>
                <button id="change_submit" onclick="checkPassword()" class="primary-btn order-submit">Change</button>
            </div>
        </div>
        <p id="message" hidden>{{session()->get('message')}}</p>
    </div>
@stop
@push('scripts')
    <script>
        function checkPassword() {
            let password = $("#c_new_password").val();
            let confirm_password = $("#confirm_new_password").val();
            if(password !== confirm_password){
                $("#c_message").html("password is not match").css('color', 'red');
            } else {
                $.ajax({
                    type: 'post',
                    url: '/password/{{session()->get('user')}}/change',
                    data: {
                        _method: "patch",
                        'username': $("#c_username").val(),
                        'password': $("#c_password").val(),
                        'new_password': password,
                    },
                    success: function (data) {
                        if(data === false) {
                            alert('Wrong user or password. Try again');
                            location.reload();
                        } else {
                            alert('Your password is changed successfully');
                            location.replace('/');
                        }
                    },
                    error: function (data){
                        let errors = data.responseJSON.errors;
                        showError(errors);
                    }
                })
                function showError(msg){
                    $(".print-error-msg").find("ul").html('');
                    $(".print-error-msg").css('display','block');
                    $.each( msg, function( key, value ) {
                        let id = 'c_' + key
                        $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                        $('#'+id).css('border-color', 'red');
                        if(id === 'c_new_password'){
                            $("#confirm_new_password").css('border-color', 'red');
                        }
                    });
                }
            }
        }
    </script>
@endpush
