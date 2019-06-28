<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:69:"C:\xampp\htdocs\weice\public/../application/admin\view\add\tuadd.html";i:1560811471;}*/ ?>
<!DOCTYPE html>
<html><head>
    <meta charset="utf-8">
    <title></title>

    <meta name="description" content="Dashboard">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!--Basic Styles-->
    <link href="http://127.0.0.1/weice/public/static/admin/style/bootstrap.css" rel="stylesheet">
    <link href="http://127.0.0.1/weice/public/static/admin/style/font-awesome.css" rel="stylesheet">
    <link href="http://127.0.0.1/weice/public/static/admin/style/weather-icons.css" rel="stylesheet">

    <!--Beyond styles-->
    <link id="beyond-link" href="http://127.0.0.1/weice/public/static/admin/style/beyond.css" rel="stylesheet" type="text/css">
    <link href="http://127.0.0.1/weice/public/static/admin/style/demo.css" rel="stylesheet">
    <link href="http://127.0.0.1/weice/public/static/admin/style/typicons.css" rel="stylesheet">
    <link href="http://127.0.0.1/weice/public/static/admin/style/animate.css" rel="stylesheet">

</head>
<body>
<!-- 头部 -->
<div class="navbar">
    <div class="navbar-inner">
        <div class="navbar-container">
            <!-- Navbar Barnd -->
            <div class="navbar-header pull-left">
                <a href="#" class="navbar-brand">
                    <small>
                        <img src="http://127.0.0.1/weice/public/static/admin/images/logo.png" alt="">
                    </small>
                </a>
            </div>
            <!-- /Navbar Barnd -->
            <!-- Sidebar Collapse -->
            <div class="sidebar-collapse" id="sidebar-collapse">
                <i class="collapse-icon fa fa-bars"></i>
            </div>
            <!-- /Sidebar Collapse -->
            <!-- Account Area and Settings -->
            <div class="navbar-header pull-right">
                <div class="navbar-account">
                    <ul class="account-area">
                        <li>
                            <a class="login-area dropdown-toggle" data-toggle="dropdown">
                                <div class="avatar" title="View your public profile">
                                    <img src="http://127.0.0.1/weice/public/static/admin/images/adam-jansen.jpg">
                                </div>
                                <section>
                                    <h2><span class="profile"><span>admin</span></span></h2>
                                </section>
                            </a>
                            <!--Login Area Dropdown-->
                            <ul class="pull-right dropdown-menu dropdown-arrow dropdown-login-area">
                                <li class="username"><a>David Stevenson</a></li>
                                <li class="dropdown-footer">
                                    <a href="/admin/user/logout.html">
                                        退出登录
                                    </a>
                                </li>
                                <li class="dropdown-footer">
                                    <a href="/admin/user/changePwd.html">
                                        修改密码
                                    </a>
                                </li>
                            </ul>
                            <!--/Login Area Dropdown-->
                        </li>
                        <!-- /Account Area -->
                        <!--Note: notice that setting div must start right after account area list.
                            no space must be between these elements-->
                        <!-- Settings -->
                    </ul>
                </div>
            </div>
            <!-- /Account Area and Settings -->
        </div>
    </div>
</div>

<!-- /头部 -->

<div class="main-container container-fluid">
    <div class="page-container">
        <!-- Page Sidebar -->
        <div class="page-sidebar" id="sidebar">
            <!-- Page Sidebar Header-->
            <div class="sidebar-header-wrapper">
                <input class="searchinput" type="text">
                <i class="searchicon fa fa-search"></i>
                <div class="searchhelper">Search Reports, Charts, Emails or Notifications</div>
            </div>
            <!-- /Page Sidebar Header -->
            <!-- Sidebar Menu -->
            <ul class="nav sidebar-menu">
                <!--Dashboard-->

                <li>
                    <a href="#" class="menu-dropdown">
                        <i class="menu-icon fa fa-user"></i>
                        <span class="menu-text">图集管理</span>
                        <i class="menu-expand"></i>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="<?php echo url('admin/index/tulist'); ?>">
                                <span class="menu-text">图集列表</span>
                                <i class="menu-expand"></i>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#" class="menu-dropdown">
                        <i class="menu-icon fa fa-file-text"></i>
                        <span class="menu-text">视频管理</span>
                        <i class="menu-expand"></i>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="volist.html">
                                <span class="menu-text">视频列表</span>
                                <i class="menu-expand"></i>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#" class="menu-dropdown">
                        <i class="menu-icon fa fa-gear"></i>
                        <span class="menu-text">用户管理</span>
                        <i class="menu-expand"></i>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="uslist.html">
                <span class="menu-text">
                    用户列表                                   </span>
                                <i class="menu-expand"></i>
                            </a>
                        </li>
                        <li>
                            <a href="frlist.html">
                <span class="menu-text">
                    好友列表
                </span>
                                <i class="menu-expand"></i>
                            </a>
                        </li>
                        <li>
                            <a href="falist.html">
                <span class="menu-text">
                    粉丝列表
                </span>
                                <i class="menu-expand"></i>
                            </a>
                        </li>

                    </ul>
                </li>

            </ul>
            <!-- /Sidebar Menu -->
        </div>
        <!-- /Page Sidebar -->
        <!-- Page Content -->
        <div class="page-content">
            <!-- Page Breadcrumb -->
            <div class="page-breadcrumbs">
                <ul class="breadcrumb">
                    <li>
                        <a href="#">视频列表</a>
                    </li>
                    <li class="active">添加视频</li>
                </ul>
            </div>
            <!-- /Page Breadcrumb -->

            <!-- Page Body -->
            <div class="page-body">

                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <div class="widget">
                            <div class="widget-header bordered-bottom bordered-blue">
                                <span class="widget-caption">增加视频</span>
                            </div>
                            <div class="widget-body">
                                <div id="horizontal-form">
                                    <form enctype="multipart/form-data" class="form-horizontal" role="form" action="<?php echo url('admin/route/up'); ?>" method="post">
                                        <div class="form-group">
                                            <label for="openid" class="col-sm-2 control-label no-padding-right">用户ID</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" id="openid" placeholder="" name="openid" value="" required="" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="image" class="col-sm-2 control-label no-padding-right">上传图集</label>
                                            <div class="col-sm-6">
                                                <input  class="form-control" id="image" placeholder="" name="image[]" required="" type="file">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="describes" class="col-sm-2 control-label no-padding-right">描述</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" id="describes" placeholder="" name="describes" value="" required="" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="tabname" class="col-sm-2 control-label no-padding-right">标签</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" id="tabname" placeholder="" name="tabname" value="" required="" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit" class="btn btn-default">保存信息</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /Page Body -->
        </div>
        <!-- /Page Content -->
    </div>
</div>

<!--Basic Scripts-->
<script src="http://127.0.0.1/weice/public/static/admin/style/jquery_002.js"></script>
<script src="http://127.0.0.1/weice/public/static/admin/style/bootstrap.js"></script>
<script src="http://127.0.0.1/weice/public/static/admin/style/jquery.js"></script>
<!--Beyond Scripts-->
<script src="http://127.0.0.1/weice/public/static/admin/style/beyond.js"></script>



</body></html>