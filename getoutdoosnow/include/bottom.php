   </div>
   <footer style="position: relative">
        <nav class="navbar navfooter navbar-inverse" role="navigation" style="margin-bottom: 0px;">
            <div class="container">
                <div class="row">
                    <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
                        <span class="sr-only">Toggle navigation</span>
                    </button>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="/support.php">Support</a>
                        </li>
                        <li>
                            <a href="">Follow Us</a>
                        </li>
                        <li>
                            <a class="hidden-desktop" target="_blank" href="https://www.facebook.com/GetOutdoorsNow/">
                                <img height="20px" width="auto" src="https://upload.wikimedia.org/wikipedia/commons/c/cd/Facebook_logo_(square).png"/>
                            </a>
                        </li>
                        <li>
                            <a class="hidden-desktop" target="_blank" href="https://twitter.com/Get_OutdoorsNow">
                                <img height="20px" width="auto" src="http://shaeallison.webfactional.com/apps/coachella/photos/twitter.png"/>
                            </a>
                        </li>
                    </ul>
                </div>
                    </div>



                <!-- /.navbar-collapse -->

               </div>
            </nav>
    </footer>
    <script src="/js/bootstrap.min.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <?php
    //dump session vars
    if(isset($_GET['sessiondump']) && $_GET['sessiondump'] == "true") {
        ?>
        <div style="  position: fixed;


  z-index: 100000000;
  width: 100%;
  bottom:0;">
            <?php echo '<pre>';
            var_dump($_SESSION);
            echo '</pre>';

            ?>
        </div>
    <?php
}
    ?>
    </div>
</body>

</html>






