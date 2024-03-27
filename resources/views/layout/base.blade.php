<!DOCTYPE html>
<html 
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free">
  
  {{-- Header --}}
     @include('layout.header')
  {{-- END Header --}}

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
     <div class="layout-container">
          {{-- Sidebar --}}
          @include('layout.sidebar')
          {{-- END Sidebar --}}

          <!-- Layout container -->
          <div class="layout-page">
               {{-- Navbar --}}
               @include('layout.navbar')
               {{-- END Navbar --}}

               <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                         @yield('content')
                    </div>
                    <!-- END Content -->

                    <!-- Footer -->
                    @include('layout.footer')
                    <!-- END Footer -->

                    <div class="content-backdrop fade"></div>
               </div>
               
          </div>
          <!-- END Layout container -->
     </div>
  </div>

  {{-- JS --}}
     @include('layout.js')
  {{-- END JS --}}
</body>
</html>