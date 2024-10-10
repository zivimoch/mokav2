<style>
  /* style search klien di navbar */
  .list-group-item {
      border: none; /* Remove border for cleaner look */
  }
  
  .list-group-item:hover {
      background-color: #f8f9fa; /* Light background on hover */
  }
  
  .list-group-item-active {
      background-color: #007bff; /* Highlight color */
      color: #ffffff; /* Text color on highlight */
  }
  /* style search klien di navbar end */

  @media (max-width: 767px) {
  .dropdown-menu {
    right: 0;
    width: 100%;
  } 
  .dropdown{
    position: relative;
  }
}
.nav-icon {
  margin-right: 3px
}

@media  (max-width:960px) { .dropdown-menu { width: 360px !important; } }
</style>
@if (Auth::user()->settings_navbar_bg_color == 'default')
  <nav class="main-header navbar navbar-expand-md navbar-black navbar-dark">
@else
  <nav class="main-header navbar navbar-expand-md navbar-black navbar-dark" style="background-color: {{ Auth::user()->settings_navbar_bg_color }};">
@endif
  <div class="container">
    <a href="{{ route('dashboard') }}" class="navbar-brand">
      <img src="{{ asset('img') }}/logo-moka.png" alt="MOKA Logo" class="brand-image" style="opacity: .8; max-width:150px; border-radius: 50%;">
      {{-- <b><span style="background-color: yellow;color:black; padding:3px 3px 3px 5px">MOKA</span><span style="background-color: #fff;color:black; padding:3px 3px 3px 3px">ONLINE</span></b> --}}
      <b>MOKA 
        {{-- <span style="color:yellow;">ONLINE</span>' --}}
      </b>
    </a>
    <div class="collapse navbar-collapse order-3" id="navbarCollapse">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a href="{{ route('monitoring') }}" class="nav-link"><i class="nav-icon fas fa-tv"></i> Monitoring</a>
        </li>
        <li class="nav-item">
          <a href="{{ route('kasus') }}" class="nav-link"><i class="nav-icon fas fa-search"></i> Kasus</a>
        </li>
        {{-- <li class="nav-item">
          <a href="{{ route('dokumen') }}" class="nav-link"><i class="nav-icon fas fa-file-alt"></i> Dokumen</a>
        </li> --}}
        @if (in_array(Auth::user()->jabatan, ['Super Admin', 'Sekretariat', 'Kepala Instansi']))
          <li class="nav-item">
            <a href="{{ route('kinerja') }}?tahun={{ date('Y') }}&bulan={{ date('m') }}" class="nav-link"><i class="nav-icon fas fa-tasks"></i> LapKin</a>
          </li>
        @endif
        @if (Auth::user()->jabatan == 'Super Admin')
          <li class="nav-item">
            <a href="{{ route('websettings') }}" class="nav-link"><i class="fas fa-cogs"></i> Web Settings</a>
          </li>
        @endif
      </ul>
      
      
      <div class="form-inline ml-0 ml-md-3 position-relative">
        <div class="input-group input-group-sm">
            <input type="text" id="klien_search" class="form-control form-control-navbar" placeholder="Cari nama / no regis" onfocus="klien_search()" oninput="klien_search()">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="button" id="search_btn">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div id="search_results" class="list-group" style="position: absolute; top: 100%; left: 0; z-index: 1000; display: none; width: 100%;"></div>
    </div>

    </div>

    <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <!-- Right navbar links -->
    <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
      <li class="nav-item dropdown">
        <a href="{{ route('formpenerimapengaduan.index') }}" class="btn btn-success btn-sm" style="margin : 7px 0px 0px 0px; padding : 3px 5px 3px 5px">
          <i class="fas fa-bullhorn"></i> Lapor 
        </a>
      </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-trigger" id="notif_text" data-toggle="dropdown" href="#">
                <i id="notif_bell" class="far fa-bell"></i> <span id="notif_count"></span> <i class="fa fa-caret-down"></i>
            </a>
            <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right" style="width : 400px;">                                            
              <center style="font-weight : bold; margin-bottom : 5px">Task & Notification</center>
              <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                  <li class="nav-item">
                      <a class="nav-link active" style="color : black" id="task-tab" data-toggle="tab" href="#task" role="tab" aria-controls="task" aria-selected="true">Task (<span id="count_task"></span>)</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" style="color : black" id="notif-tab" data-toggle="tab" href="#notif" role="tab" aria-controls="notif" aria-selected="false">Notification (<span id="count_notif"></span>)</a>
                  </li>
              </ul>
              <div class="tab-content">
                  <div class="tab-pane fade show active" id="task" role="tabpanel" aria-labelledby="task-tab">
                    <div class="list-group" id="task_list" style="max-height: 500px; overflow:scroll; overflow-x: hidden; scrollbar-width: thin;">
                    </div>
                  </div>
                  <div class="tab-pane fade" id="notif" role="tabpanel" aria-labelledby="notif-tab">
                      <center style="margin-top: 10px;"><b><a href="#" onclick="read_all()">Tandai semua telah dibaca</a></b></center>
                      <div class="list-group" id="notif_list" style="max-height: 500px; overflow:scroll; overflow-x: hidden; scrollbar-width: thin;">
                      </div>
                  </div>
              </div>
              <center style="margin-top: 10px;"><b><a href="{{ route('notifikasi') }}">Lihat semua notifikasi</a></b></center>
          </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-user"></i> <i class="fa fa-caret-down"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
              <a href="{{ route('users.show', Auth::user()->uuid) }}" class="list-group-item list-group-item-action flex-column align-items-start"> 
                <div class="d-flex"> 
                  <small class="mr-2">
                    <i class="far fa-user"></i>
                  </small> 
                  <h6 style="margin-bottom: -2px">
                    Ubah Profil <b> {{ Auth::user()->name }}</b>
                  </h6>
                </div> 
              </a>
              <a href="{{ route('kinerja.detail') }}?tahun={{ date('Y') }}&bulan={{ date('m') }}&user_id={{ Auth::user()->uuid }}" class="list-group-item list-group-item-action flex-column align-items-start"> 
                <div class="d-flex"> 
                  <small class="mr-2">
                    <i class="fas fa-tasks"></i>
                  </small> 
                  <h6 style="margin-bottom: -2px">
                    Laporan Kinerja
                  </h6>
                </div> 
              </a>
              <a href="https://s.id/usermanualmoka" target="_blank" class="list-group-item list-group-item-action flex-column align-items-start"> 
                <div class="d-flex"> 
                  <small class="mr-2" style="font-size:15px">
                    <i class="fas fa-info-circle"></i>
                  </small> 
                  <h6 style="margin-bottom: -2px">
                    Panduan Penggunaan
                  </h6>
                </div> 
              </a>
              <a href="https://s.id/bantumoka" target="_blank" class="list-group-item list-group-item-action flex-column align-items-start"> 
                <div class="d-flex"> 
                  <small class="mr-2" style="font-size:15px">
                    <i class="fas fa-question-circle"></i>
                  </small> 
                  <h6 style="margin-bottom: -2px">
                    Pusat Bantuan (Tanya Via WA)
                  </h6>
                </div> 
              </a>
              <a href="#" class="">
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button style="width: 100%"
                    onclick="event.preventDefault();
                  this.closest('form').submit();">
                      <i class="fas fa-arrow-alt-circle-right"></i> Logout
                    </button>
                </form>
              </a>
            </div>
        </li>
    </ul>
  </div>
  </nav>