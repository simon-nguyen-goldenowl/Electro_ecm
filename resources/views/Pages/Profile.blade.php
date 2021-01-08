

@extends('Layout')
@section('content')
    <div class="section">
        <div class="container">
            <div class="row">
                <h1>Your Profile</h1>
                <p>Please fill in this form if you want to update your profile.</p>
                <div class="alert alert-danger print-error-msg" style="display:none">
                    <ul></ul>
                </div>
                @csrf
                <div class="form-group">
                    <label for="username">Username (cannot change): </label>
                    <input class="input" id="pusername" type="text" name="username" value="{{$user->username}}" disabled>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input class="input" id="pemail" type="email" name="email" value="{{$user->email}}">
                </div>
                <div class="form-group">
                    <label for="name">Full name:</label>
                    <input class="input" id="pname" type="text" name="name" value="{{$user->name}}">
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <input class="input" id="paddress" type="text" name="address" value="{{$user->address}}">
                </div>
                <div class="form-group">
                    <label for="phone">Phone number:</label>
                    <input class="input" type="tel" id="pphone" name="phone" value="{{$user->phone}}">
                </div>
                <button id="register_submit" onclick="updateProfile()" class="primary-btn order-submit">Update</button>
                <a href="/profile/password-change"><button class="primary-btn order-submit">Change Password</button></a>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function updateProfile() {
            $.ajax({
                type: 'patch',
                url: '/users/{{$user->id}}',
                data: {
                    'name': $("#pname").val(),
                    'address': $("#paddress").val(),
                    'phone': $("#pphone").val(),
                    'username': $("#pusername").val(),
                    'email': $("#pemail").val(),
                },
                success: function (data){
                    alert('your account is updated');
                    location.replace('/')
                },
                error: function (data){
                    let errors = data.responseJSON.errors;
                    showError(errors);
                }
            })
        }
        function showError(msg){
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                let id = 'p' + key
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                $('#'+id).css('border-color', 'red');
            });
        }
    </script>
@endpush
