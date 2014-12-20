<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>ALTERFISC</title>

        <meta name="description" content="overview &amp; stats" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <?=$this->load->view('includes/head')?>
    </head>

    <body>
       <?=$this->load->view('includes/nav')?>
        <div class="main-container" id="main-container">
            <script type="text/javascript">
                try{ace.settings.check('main-container' , 'fixed')}catch(e){}
            </script>

            <div class="main-container-inner">
                <a class="menu-toggler" id="menu-toggler" href="#">
                    <span class="menu-text"></span>
                </a>

                <?=$this->load->view('menu/admin_menu')?>

                <div class="main-content">
                    <?=$this->load->view($body)?>
                </div><!-- /.main-content -->

            </div><!-- /.main-container-inner -->

        </div><!-- /.main-container -->
      
      <?=$this->load->view('includes/scripts')?>
    </body>
</html>
