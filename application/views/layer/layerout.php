<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <meta name="format-detection" content="telephone=no">
        <meta charset="UTF-8">

        <meta name="description" content="Violate Responsive Admin Template">
        <meta name="keywords" content="Super Admin, Admin, Template, Bootstrap">

        <title>ALTERFISC</title>
            
        <!-- CSS -->
        <link href="<?=base_url('assets')?>/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?=base_url('assets')?>/css/animate.min.css" rel="stylesheet">
        <!--<link href="<?=base_url('assets')?>/css/font-awesome.min.css" rel="stylesheet">-->  
        <link href="<?=base_url('assets')?>/css/form.css" rel="stylesheet">
        <link href="<?=base_url('assets')?>/css/calendar.css" rel="stylesheet">
        <link href="<?=base_url('assets')?>/css/style.css" rel="stylesheet">
        <link href="<?=base_url('assets')?>/css/icons.css" rel="stylesheet">
        <link href="<?=base_url('assets')?>/css/generics.css" rel="stylesheet"> 
<!--         <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">-->
        <link href="<?=base_url('assets')?>/font-awesome-4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>

    </head>
    <body id="skin-tectile">

        <header id="header" class="media">
            <a href="" id="menu-toggle"></a> 
            <a class="logo pull-left" href="<?=base_url($this->session->userdata('base_perfil'))?>">ALTERFISC 1.0</a>
            
            <div class="media-body">
                <div class="media" id="top-menu">
                    <div id="time" class="pull-right">
                        <span id="hours"></span>
                        :
                        <span id="min"></span>
                        :
                        <span id="sec"></span>
                    </div>
                    
                </div>
            </div>
        </header>
        
        <div class="clearfix"></div>
        
        <section id="main" class="p-relative" role="main">
            
            <!-- Sidebar -->
            <aside id="sidebar">
                
                <!-- Sidbar Widgets -->
                <div class="side-widgets overflow">
                    <!-- Profile Menu -->
                    <div class="text-center s-widget m-b-25 dropdown" id="profile-menu">
                        <a href="" data-toggle="dropdown">
                            <img class="profile-pic animated" src="<?=base_url('assets')?>/img/profile-pics/no_found.jpg" alt="">
                        </a>
                        <ul class="dropdown-menu profile-menu">
                            <li><a href="">My Profile</a> <i class="icon left">&#61903;</i><i class="icon right">&#61815;</i></li>
                            <li><a href="">Messages</a> <i class="icon left">&#61903;</i><i class="icon right">&#61815;</i></li>
                            <li><a href="">Settings</a> <i class="icon left">&#61903;</i><i class="icon right">&#61815;</i></li>
                            <li><a href="">Sign Out</a> <i class="icon left">&#61903;</i><i class="icon right">&#61815;</i></li>
                        </ul>
                        <h4 class="m-0"><?=$this->session->userdata('USERNAME')?></h4>
                    </div>
                    
                    <!-- Calendar -->
                    <div class="s-widget m-b-25">
                        <div id="sidebar-calendar"></div>
                    </div>
                    
                </div>
                
                <!-- Side Menu -->
                <?=$this->load->view($menu)?>
            </aside>
        
            <!-- Contentenido pagina media -->
            <section id="content" class="container">
            <?=$this->load->view($body)?>
            </section>

            <!-- Older IE Message -->
            <!--[if lt IE 9]>
                <div class="ie-block">
                    <h1 class="Ops">Ooops!</h1>
                    <p>You are using an outdated version of Internet Explorer, upgrade to any of the following web browser in order to access the maximum functionality of this website. </p>
                    <ul class="browsers">
                        <li>
                            <a href="https://www.google.com/intl/en/chrome/browser/">
                                <img src="img/browsers/chrome.png" alt="">
                                <div>Google Chrome</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://www.mozilla.org/en-US/firefox/new/">
                                <img src="img/browsers/firefox.png" alt="">
                                <div>Mozilla Firefox</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://www.opera.com/computer/windows">
                                <img src="img/browsers/opera.png" alt="">
                                <div>Opera</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://safari.en.softonic.com/">
                                <img src="img/browsers/safari.png" alt="">
                                <div>Safari</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://windows.microsoft.com/en-us/internet-explorer/downloads/ie-10/worldwide-languages">
                                <img src="img/browsers/ie.png" alt="">
                                <div>Internet Explorer(New)</div>
                            </a>
                        </li>
                    </ul>
                    <p>Upgrade your browser for a Safer and Faster web experience. <br/>Thank you for your patience...</p>
                </div>   
            <![endif]-->
        </section>
        
        <!-- Javascript Libraries -->
        <link rel="stylesheet" href="<?=base_url('assets')?>/js/themes/blue/style.css" type="text/css" id="" media="print, projection, screen" />
        <script src="<?=base_url('assets')?>/js/jquery-latest.js"></script>
        <script src="<?=base_url('assets')?>/js/jquery.tablesorter.js"></script>

        <script type="text/javascript" src="<?=base_url('assets')?>/js/addons/pager/jquery.tablesorter.pager.js"></script>

        <!-- jQuery -->
        <?php if($this->uri->segment(2) != 'corps') {?>
            <?php if($this->uri->segment(3) != 'pendiente_retorno_general') {?>
       <script src="<?=base_url('assets')?>/js/jquery.min.js"></script> <!- jQuery Library -->
            <?}?>
       <?}?>

        <script src="<?=base_url('assets')?>/js/jquery-ui.min.js"></script> <!-- jQuery UI -->
        <script src="<?=base_url('assets')?>/js/jquery.easing.1.3.js"></script> <!-- jQuery Easing - Requirred for Lightbox + Pie Charts-->

        <!-- Bootstrap -->
        <script src="<?=base_url('assets')?>/js/bootstrap.min.js"></script>

        <!-- Charts -->
        <script src="<?=base_url('assets')?>/js/charts/jquery.flot.js"></script> <!-- Flot Main -->
        <script src="<?=base_url('assets')?>/js/charts/jquery.flot.time.js"></script> <!-- Flot sub -->
        <script src="<?=base_url('assets')?>/js/charts/jquery.flot.animator.min.js"></script> <!-- Flot sub -->
        <script src="<?=base_url('assets')?>/js/charts/jquery.flot.resize.min.js"></script> <!-- Flot sub - for repaint when resizing the screen -->

        <script src="<?=base_url('assets')?>/js/sparkline.min.js"></script> <!-- Sparkline - Tiny charts -->
        <script src="<?=base_url('assets')?>/js/easypiechart.js"></script> <!-- EasyPieChart - Animated Pie Charts -->
        <!--<script src="<?=base_url('assets')?>/js/charts.js"></script> < All the above chart related functions -->

        <!-- Map -->

        <!--  Form Related -->
        <script src="<?=base_url('assets')?>/js/icheck.js"></script> <!-- Custom Checkbox + Radio -->

        <!-- UX -->
        <script src="<?=base_url('assets')?>/js/scroll.min.js"></script> <!-- Custom Scrollbar -->

        <!-- Other -->
        <script src="<?=base_url('assets')?>/js/calendar.min.js"></script> <!-- Calendar -->
        <script src="<?=base_url('assets')?>/js/feeds.min.js"></script> <!-- News Feeds -->
        <script src="<?=base_url('assets')?>/js/datetimepicker.min.js"></script> <!-- Date & Time Picker -->        

        <!-- All JS functions -->
        <script src="<?=base_url('assets')?>/js/functions.js"></script>
    </body>
</html>
