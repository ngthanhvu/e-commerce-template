<!-- <footer class="py-4 bg-light mt-auto">
     <div class="container-fluid px-4">
          <div class="d-flex align-items-center justify-content-between small">
               <div class="text-muted">Copyright &copy; Your Website 2023</div>
               <div>
                    <a href="#">Privacy Policy</a>
                    &middot;
                    <a href="#">Terms &amp; Conditions</a>
               </div>
          </div>
     </div>
</footer> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script>
     window.addEventListener('DOMContentLoaded', event => {

          // Toggle the side navigation
          const sidebarToggle = document.body.querySelector('#sidebarToggle');
          if (sidebarToggle) {
               // Uncomment Below to persist sidebar toggle between refreshes
               // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
               //     document.body.classList.toggle('sb-sidenav-toggled');
               // }
               sidebarToggle.addEventListener('click', event => {
                    event.preventDefault();
                    document.body.classList.toggle('sb-sidenav-toggled');
                    localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
               });
          }

     });
</script>
</body>

</html>