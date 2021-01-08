
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8" />
</head>
<body>
<h2>Reset Password Email</h2>
<h3>Hi {{$user_name}},</h3>
<p> We have sent you this email in response to your request to reset your password . After you reset your password, any credit card information stored in My Account will be deleted as a security measure.

    To reset your password, please follow the link below (available in 15 minutes):</p>
    <a href="{{$links}}" class="btn btn-danger"><strong>Click here</strong></a>
<p>We recommend that you keep your password secure and not share it with anyone.
        If you feel your password has been compromised,
        you can change it by going to your My Account Page and clicking on the "Change Email Address or Password" link.</p>

<p>If you need help, or you have any other questions, feel free to email electro.it@gmail.com.</p>

</body>
</html>
