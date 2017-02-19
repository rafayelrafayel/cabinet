<!DOCTYPE html>
<html>
    <head>
        <title> Vivacell</title>
        <link href="../../css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="../../css/login.css" media="screen" rel="stylesheet" type="text/css">
    </head>
    <?php
    use helpers\Html;
    use helpers\SoapClientClass;

//Just for test
    //if(isset($_POST['loginForm'])){
    //$phone = $_POST['phone'];
    //$password = $_POST['password'];
//    SoapClientClass::call('VerifyAndQueryAccount', [
//        'phoneNumber' => '94327860',
//        'password' => 'C3bNVPF7',
//    ]);
    //};
    ?>
    <body>
        <div class="site-login">
            <form method="POST" enctype="multipart/form-data">
                    <?= Html::inputField(['name' => 'phone']) ?>
                    <?= Html::inputPassword(['name' => 'password']) ?>
                    <?= Html::buttonSubmit(['name' => 'loginForm', 'display_name' => 'Login', 'classes' => ' btn btn-success']) ?>
            </form>
        </div>

    </body>
</html>