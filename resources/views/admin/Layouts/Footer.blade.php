 <!-- Footer -->
 <footer class="content-footer footer bg-footer-theme">
     <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
         <div class="mb-2 mb-md-0">
             ©
             <script>
                 document.write(new Date().getFullYear());
             </script>
             , Pixel Profit All Right Reserved
         </div>

     </div>
 </footer>
 <!-- / Footer -->

 <div class="content-backdrop fade"></div>
 </div>
 <!-- Content wrapper -->
 </div>
 <!-- / Layout page -->
 </div>

 <!-- Overlay -->
 <div class="layout-overlay layout-menu-toggle"></div>
 </div>
 <!-- / Layout wrapper -->


 <!-- Core JS -->
 <!-- build:js assets/vendor/js/core.js -->
 <script src="{{ url('AdminAssets/assets/vendor/libs/jquery/jquery.js') }}"></script>
 <script src="{{ url('AdminAssets/assets/vendor/libs/popper/popper.js') }}"></script>
 <script src="{{ url('AdminAssets/assets/vendor/js/bootstrap.js') }}"></script>
 <script src="{{ url('AdminAssets/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

 <script src="{{ url('AdminAssets/assets/vendor/js/menu.js') }}"></script>
 <!-- endbuild -->

 <!-- Vendors JS -->
 <script src="{{ url('AdminAssets/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

 <!-- Main JS -->
 <script src="{{ url('AdminAssets/assets/js/main.js') }}"></script>

 <!-- Page JS -->
 <script src="{{ url('AdminAssets/assets/js/dashboards-analytics.js') }}"></script>

 <!-- Place this tag in your head or just before your close body tag. -->
 <script async defer src="https://buttons.github.io/buttons.js"></script>


 @yield('scripts')

 
 </body>

 </html>
