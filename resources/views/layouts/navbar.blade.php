<style>
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
<nav class="main-header navbar navbar-expand-md navbar-black navbar-dark">
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
          <a href="{{ route('agenda') }}" class="nav-link"><i class="nav-icon far fa-calendar-alt"></i> Agenda</a>
        </li>  --}}
        <li class="nav-item">
          <a href="{{ route('dokumen') }}" class="nav-link"><i class="nav-icon fas fa-file-alt"></i> Dokumen</a>
        </li>
      </ul>
      <div class="btn-group">
        <a href="{{ route('formpenerimapengaduan.index') }}" class="btn btn-success btn-sm">
          <i class="fas fa-bullhorn"></i> Lapor KBG 
        </a>
      </div>
    </div>
    <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <!-- Right navbar links -->
    <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-trigger" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i> <span id="notif_count"></span> <i class="fa fa-caret-down"></i>
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
                      <div class="list-group" id="notif_list" style="max-height: 500px; overflow:scroll; overflow-x: hidden; scrollbar-width: thin;">
                      </div>
                  </div>
              </div>
              <center style="margin-top: 10px;"><b><a href="">Lihat semua notifikasi</a></b></center>
          </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-user"></i> <i class="fa fa-caret-down"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <a href="#" class="dropdown-item">
                hehe
              </a>
              <a href="#" class="dropdown-item">
                hehe
              </a>
              <a href="#" class="dropdown-item">
                hehe
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