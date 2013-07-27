<!DOCTYPE html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <title>Get 1/4 - The Pen and Paper Programming Challenge</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Programming Challenge Interface">
    <meta name="author" content="YSES">

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap-responsive.min.css">
  
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
  </head>

  <body>    

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <div class="row-fluid">
            <div class="nav pull-left">
              <a class="brand" href="/user">pChallenge :: admin</a>
            </div>
            <div class="nav pull-right">
              <?php if(isset($this->session->userdata['user'])){
                $user = $this->session->userdata['user'];
                ?>
              <ul class="nav pull-right">
                <li class="dropdown">
                  <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"><?php echo $user->uname;?><b class="caret"></b></a>
                  <ul class="dropdown-menu" role="menu" aria-labelledby="drop3">
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="edit_info.html"><i class='icon-wrench'> </i>&nbsp;&nbsp;Account Settings</a></li>
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="/logout"><i class='icon-off'> </i>&nbsp;&nbsp;Logout</a></li>
                    <li role="presentation" class="divider"></li>
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#"><i class='icon-pencil'> </i>&nbsp;&nbsp;Help</a></li>
                  </ul>
                </li>
              </ul>
              <?php } else{?>
              <form class = "navbar-form pull-left" action = "/login/auth" method = "post" > 
                <input type = "text" placeholder = "Username" name="username" />
                <input type = "password" placeholder = "Password" name="password"/>
                <td colspan='2'><button class = "btn btn-primary" type = "submit">Sign in</button>
              </form>
              <?php }?>
            </div>
          </div>
        </div>
      </div>
    </div>