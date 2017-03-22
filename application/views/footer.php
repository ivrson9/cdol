                <!-- FOOTER -->
                <div class="col-md-offset-2 main" style="padding-top:30px; float: none; margin: 0 auto;">
                    <p class="text-center">Copyright ⓒ Cdol. All rights reserved.</p>
                </div>
            </div><!--/row-->

        </div><!--/.container-->

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script>
            window.jQuery || document.write('<script src="/cdol/static/lib/bootstrap/docs/assets/js/vendor/jquery.min.js"><\/script>')
            // usage is straightforward:
            $(document).ready(function() {
                $('.js-activated').dropdownHover().dropdown();
            });

            function get_session(){
                return "<?=$this->session->userdata('id')?>";
            }
        </script>


        <script src="/cdol/static/lib/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="/cdol/static/lib/bootstrap/docs/assets/js/ie10-viewport-bug-workaround.js"></script>

        <script src="/cdol/static/js/bootstrap-hover-dropdown.js"></script>

        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
        <script src="/cdol/static/lib/bootstrap/docs/assets/js/ie-emulation-modes-warning.js"></script>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
            <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->
    </body>
</html>
