
@extends('Layout')
@section('content')
    <div class="section">
        <div class="container">
            <div class="row">
                <h1>Register</h1>
                <p>Please fill in this form to create an account.</p>
                <div class="alert alert-danger print-error-msg" style="display:none">
                    <ul></ul>
                </div>
                @csrf
                    <div class="form-group">
                        <input class="input" id="rusername" type="text" name="name" placeholder="UserName">
                    </div>
                    <div class="form-group">
                        <input class="input" id="rpassword" type="password" name="name" placeholder="Password">
                        <span></span>
                    </div>
                    <div class="form-group">
                        <input class="input" id="rconfirm_password" type="password" name="name" placeholder="Confirm Password">
                        <span id='message'></span>
                    </div>
                    <div class="form-group">
                        <input class="input" id="remail" type="email" name="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <input class="input" id="rname" type="text" name="address" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <input class="input" id="raddress" type="text" name="address" placeholder="Address">
                    </div>
                    <div class="form-group">
                        <input class="input" type="tel" id="rphone" name="phone" placeholder="Phone number">
                    </div>
                <button id="register_submit" onclick="checkPassword()" class="primary-btn order-submit">Register</button>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function checkPassword() {
            let password = $("#rpassword").val();
            let confirm_password = $("#rconfirm_password").val();
            if(password !== confirm_password){
                $("#message").html("password is not match").css('color', 'red');
            } else {
                $.ajax({
                    type: 'post',
                    url: '/users',
                    data: {
                        'name': $("#rname").val(),
                        'address': $("#raddress").val(),
                        'phone': $("#rphone").val(),
                        'username': $("#rusername").val(),
                        'password': password,
                        'email': $("#remail").val(),
                    },
                    success: function (data){
                        alert('Your account is created. Log in to shop now');
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
                let id = 'r' + key
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                $('#'+id).css('border-color', 'red');
                if(id === 'rpassword'){
                    $("#rconfirm_password").css('border-color', 'red');
                }
            });
        }
    </script>
@endpush
