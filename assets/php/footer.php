 </div>
 </div>
 <footer class="bg-white sticky-footer">
     <div class="container my-auto">
         <div class="text-center my-auto copyright"><span>Copyright © SportApp <?php echo date('Y');?></span></div>
     </div>
 </footer>
 </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
 </div>
 <!-- Bootstrap core JavaScript-->
 <script src="assets/vendor/jquery/jquery.min.js"></script>
 <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
 <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
 <script src="assets/js/sb-admin-2.min.js"></script>
 <script src="assets/vendor/chart.js/Chart.min.js"></script>
 <script src="assets/vendor/datatables/dataTables.jquery.min.js"></script>
 <!-- <script src="assets/vendor/datatables/buttons.bootstrap4.min.js"></script>-->
 <script src="assets/vendor/datatables/scroller.bootstrap4.min.js"></script>
 <script src="assets/vendor/datatables/datatables.buttons.min.js"></script>
 <script src="assets/vendor/datatables/buttons.flash.min.js"></script>
 <script src="assets/vendor/datatables/jszip.min.js"></script>
 <script src="assets/vendor/datatables/pdfmake.min.js"></script>
 <script src="assets/vendor/datatables/vfs_fonts.js"></script>
 <script src="assets/vendor/datatables/buttons.html5.min.js"></script>
 <script src="assets/vendor/datatables/buttons.print.min.js"></script>
 <script src="assets/js/initdatatables.js"></script>
 <script src="assets/vendor/confirm/confirm.min.js"></script>
 <script src="assets/vendor/jquery/jquery.cookie.js"></script>
 <script src="assets/vendor/moment/moment.js"></script>
 <script src="assets/vendor/moment/moment-local.js"></script>
 <script src="assets/vendor/context/jquery.ui.position.min.js"></script>
 <script src="assets/vendor/context/jquery.contextMenu.min.js"></script>
 <script src="assets/vendor/select2/js/select2.full.min.js"></script>
<script src="assets/vendor/fullcalendar/main.min.js"></script>
<script src="assets/vendor/fullcalendar/locales/es.js"></script>
 <script>
     $(window).resize(function() {
         if ($(window).width() < 992) {
             $('#accordionSidebar').addClass('toggled');
             $('.sidebar-heading').css('font-size', '0.50rem');
         } else {
             $('#accordionSidebar').removeClass('toggled');
             $('.sidebar-heading').css('font-size', '0.65rem');
         }
     });

 </script>
 </body>
 <?php mysqli_close($conexion); ?>

 </html>
