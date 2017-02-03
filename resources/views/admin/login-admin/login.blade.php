<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">

    <title>Fan4.live Admin</title>

    {!! Html::style( asset('assets/admin/css/screen.css')) !!}
	
    <!-- Bootstrap CSS -->    
    {!! Html::style( asset('assets/admin/css/bootstrap.min.css')) !!}
    <!-- bootstrap theme -->
    {!! Html::style( asset('assets/admin/css/bootstrap-theme.css')) !!}
    <!--external css-->
    <!-- font icon -->
    {!! Html::style( asset('assets/admin/css/elegant-icons-style.css')) !!}
    {!! Html::style( asset('assets/admin/css/font-awesome.css')) !!}
    <!-- Custom styles -->
    {!! Html::style( asset('assets/admin/css/style.css')) !!}
    {!! Html::style( asset('assets/admin/css/style-responsive.css')) !!}

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
  <body class="login-img3-body">
    <div class="container">
     @include('admin.forms.login-form')
    </div>
  </body>
</html>
