<html>
    <head>
    <title>Shuzi Online Store Home Page</title>
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel='stylesheet' type='text/css' />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    </script>
    <!----webfonts---->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
    <!----//webfonts---->
    <!----start-alert-scroller---->
    <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.easy-ticker.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
        $('#demo').hide();
        $('.vticker').easyTicker();
    });
    </script>

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/slippry.css">
    <script src="<?php echo base_url(); ?>assets/js/scripts-f0e4e0c2.js" type="text/javascript"></script>
    <script>
          jQuery('#jquery-demo').slippry({
          // general elements & wrapper
          slippryWrapper: '<div class="sy-box jquery-demo" />', // wrapper to wrap everything, including pager
          // options
          adaptiveHeight: false, // height of the sliders adapts to current slide
          useCSS: false, // true, false -> fallback to js if no browser support
          autoHover: false,
          transition: 'fade'
        });
    </script>
    <!----start-pricerage-seletion---->

    <script type='text/javascript'>
        $(document).ready(function(){
            $("#showProduct").click(function(){
                var categ = $("#selectcate").val();
                var skey = $("#searchinput").val();
                $.ajax({
                    type:"GET",
                    url:"<?php echo site_url('account/search'); ?>", 
                    data:{categ: categ, skey: skey}
                }).done(function(res){
                    $("#txtHint").html(res);
                });
            });
        });
               
    </script>            
    </head>	
        <body>
            <!--<p>Welcome to Shuzi Online Store!</p>-->
            <div class='header'>
                <div class='top-header'>
                    <div class='wrap'>
                    
                        <div class='top-header-left'>
                            <ul>
                                <li><a href="<?php echo site_url('account/displayCart'); ?>">Cart</a></li>
                            </ul>
                        </div>
                        <div class='top-header-center'>
                            <div class='top-header-center-alert-left'>
                                <h3>Welcome to Shuzi Car Company!</h3>
                            </div>
                            <div class='clear'> </div>
                        </div>
                        <div class='top-header-right'>
                            <ul>
<?php
                if (!empty($this->session->userdata['cloginsuccess']) && $this->session->userdata['cloginsuccess']==true){
?>					<li><a href="<?php echo site_url('account/accountProfile'); ?>"><?php echo $this->session->userdata('cusername'); ?>'s Account</a><span> </span></li>
                    <li><a href="<?php echo site_url('account/clogout'); ?>">Logout</a></li>;
<?php           }else{
?>  
                    <li><a href="<?php echo site_url('account/clogin_new?url='.current_url()); ?> ">Login</a><span> </span></li>
                    <li><a href="<?php echo site_url('account/addProfile'); ?>">Join</a></li>
    
<?php           }
?>

                            </ul>
                        </div>
                        <div class='clear'> </div>
                    </div><!-- end of class 'wrap' -->
                </div><!-- end of class 'top-header'-->
                
                <div class='mid-header'>
                    <div class='wrap'>
                        <div class='mid-grid-left'>
                            <form name='navi'>
                                <span>Category</span>
                                <select name='selectcate' id='selectcate'>
                                <option value='all' selected>All Category</option>";
 <?php
                                if(!$prodcutcategory){
                                    echo '<p>No Such Product Category.</p>';            
                                }else{
                                
                                    foreach($prodcutcategory as $row){
                                        echo"<option value='".$row['productcategoryid']."'>".$row['productcategoryname']."</option>";  
                                          
                                    }
                                }
?>
                               
                                </select>
                                <span> &nbsp;</span>
                                <input type='text' id='searchinput' name='searchkey' placeholder='Search here!'/>
                                <input type='button' value='Search' id='showProduct'/>
                                
                            </form>
                        </div>
                        <div class='mid-grid-right'>
                            <!--<a class='logo' href="<?php echo site_url(); ?>"><span> </span></a>--!>
                            <a href="<?php echo site_url(); ?>">
                            <img src="<?php echo base_url(); ?>assets/images/logo.png" style='height:10%'/>
                            </a>
                        </div>
                        <div class='clear'> </div>
                    </div>
                </div><!-- end of class 'mid-header'-->
                
            </div><!--end of header -->
                <div id='txtHint'>
                                
                
                
