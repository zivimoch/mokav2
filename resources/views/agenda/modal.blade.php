<style>
    .modal {  
        overflow-y:auto;
    }
</style>
<style id="styleremove"></style>

<!-- Modal Agenda-->
<div class="modal fade" id="ajaxModel" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
  
        <div id="overlay" class="overlay dark">
          <div class="cv-spinner">
            <span class="spinner"></span>
          </div>
        </div>
        
        <div class="modal-header">
          <h5 class="modal-title" id="modelHeadingAgenda"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="alert alert-danger alert-dismissible invalid-feedback" id="error-message-agenda">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
          <span id="message-agenda"></span>
        </div>
        <div class="alert alert-success alert-dismissible invalid-feedback" id="success-message-agenda">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4><i class="icon fa fa-check"></i> Success!</h4>
          Data berhasil disimpan.
        </div>
        <div class="modal-body"  style="margin-bottom: -15px">
        <input type="hidden" name="uuid" id="uuid">
        <div class="form-group">
            <label><span class="text-danger">*</span>Judul kegiatan</label>
            <input type="text" class="form-control required-field-agenda" id="judul_kegiatan">
            <div class="invalid-feedback" id="valid-judul_kegiatan">
              Judul Kegiatan wajib diisi.
            </div>
        </div>
        <div class="row">
          <div class="col-md-6">
              <div class="form-group">
                <label><span class="text-danger">*</span>Tanggal</label>
                <input type="date" class="form-control required-field-agenda" id="tanggal_mulai">
                <div class="invalid-feedback" id="valid-tanggal_mulai">
                  Tanggal Mulai wajib diisi.
                </div>
            </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  <label><span class="text-danger">*</span>Jam mulai</label>
                  <input type="text" class="form-control required-field-agenda time-picker" id="jam_mulai" data-precision="5">
                  <div class="invalid-feedback" id="valid-jam_mulai">
                    Jam Mulai wajib diisi.
                  </div>
              </div>
          </div>
        </div>
        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="" class="form-control" id="keterangan-agenda" cols="30" rows="2"></textarea>
        </div>
        <div class="form-group">
            <label>Penjadwalan Layanan</label>
            <select class="form-control" id="penjadwalan_layanan" onchange="penjadwalan_layanan()">
              <option value="0">Tidak</option>
              <option value="1">Ya</option>
            </select>
        </div>
        <div class="form-group" id="list_klien">
          <label>Pilih Klien</label>
          <select class="select2" data-placeholder="Pilih nama" style="width: 100%;" id="klien_id_select" onchange="load_select2_petugas()"></select>
        </div>
        <div class="form-group">
          <label>Tags <br><span style="font-size: 12px">*jika tidak ada nama anda maka agenda tidak tersimpan di akun anda</span></label>
          <select multiple="multiple" data-placeholder="Pilih nama" style="width: 100%;" class="user_id_select" id="user_id_select"></select>
          <div class="invalid-feedback" id="valid-user_id_select">
            Minimal tag 1 orang.
          </div>
        </div>
          <div class="col-12" id="accordion-tindaklanjut" style="padding:0px !important">
              <div class="card card-primary card-outline">
              <a class="d-block w-100" data-toggle="collapse" href="#collapseOne">
              <div class="card-header">
              <h4 class="card-title">
              Tindak Lanjut
              </h4>
              <div class="card-tools">
                <input type="checkbox" class="btn-sm" id="terlaksana"
                        checked 
                        data-bootstrap-switch 
                        data-on-text="Terlaksana"
                        data-off-text="Dibatalkan"
                        data-off-color="danger" 
                        data-on-color="success">
              </div>
              </div>
              </a>
              <div id="collapseOne" class="collapse" data-parent="#accordion-tindaklanjut">
                <div class="alert alert-warning alert-dismissible">
                  <i class="icon fas fa-exclamation-triangle"></i> Data <b>Tindak Lanjut</b> hanya tercatat pada akun anda
                </div>
              <div class="card-body">
                {{-- <div class="form-group">
                  <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                  <input type="checkbox" class="custom-control-input" id="customSwitch3">
                  <label class="custom-control-label" for="customSwitch3">Terlaksana</label>
                  </div>
                </div> --}}
                  <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                          <label>Lokasi Kegiatan</label>
                          <input type="text" class="form-control" id="lokasi">
                      </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Jam selesai</label>
                            <?php
                              date_default_timezone_set("asia/jakarta");
                              $jam_selesai = date("h:i");
                            ?>
                            <input type="text" class="form-control time-picker" id="jam_selesai" data-precision="5" value="{{ $jam_selesai }}">
                        </div>
                    </div>
                  </div>
                  <div class="form-group">
                  <label>Dokumen pendukung <span style="font-size: 12px">(lihat dokumen tersedia <a href="{{ route('dokumen') }}" target="_blank">disini</a>)<br>*Laporan Hasil Kegiatan</span></label>
                  <select multiple="multiple" data-placeholder="Pilih judul dokumen" style="width: 100%;" id="dokumen_id_select"></select>
                    <div class="invalid-feedback" id="valid-dokumen_id_select">
                      Dokumen pendukung wajib diisi jika menTL Penjadwalan Layanan.
                    </div>  
                  </div>
                  <div class="form-group">
                      <label>Catatan</label>
                      <textarea name="" class="form-control" id="catatan" cols="30" rows="2"></textarea>
                  </div>
                  <div class="form-group">
                      <label>Link Survey Kepuasan</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="link-form" value="coming soon..." tabindex="-1" aria-hidden="true" style="background: #eaebeb;font-size: 14px;font-weight: bold;">
                        <div class="input-group-append">
                            <span class="input-group-text pointer" onclick="copyClipboard()" onmouseout="copyClipboardOut()" data-toggle="tooltip" data-placement="top" title="" data-original-title="Copy Link to Clipboard" id="copy-btn">
                                <i class="fa fa-fw" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                  </div>
                  <span style="font-size: 14px">*Laporan Tindak Lanjut tersimpan pada tanggal : <span id='ct' ></span></span>
                </div>
              </div>
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success btn-block" id="submitAgenda"><i class="fa fa-check"></i> Simpan</button>
        </div>
      </div>
    </div>
  </div>

  <script src="{{ asset('/source/js/validation.js') }}"></script>
  
  <script src="{{ asset('adminlte') }}/plugins/moment/moment.min.js"></script> 
  <script src="{{ asset('source') }}/js/jquery-clock-timepicker.min.js"></script>
  <script src="{{ asset('adminlte') }}/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
  
<script>
    $(document).ready(function () {
    $('.time-picker').clockTimePicker();
    load_select2_klien();
    load_select2_petugas();
    load_select2_dokumen();
    display_ct();
    $("#list_klien").hide();
    $('#terlaksana').on('switchChange.bootstrapSwitch', function (event, state) {
      if (state) {
        $("#collapseOne").addClass("show");
        $("#collapseOne").show();
      } else {
        $("#collapseOne").removeClass("show");
        $("#collapseOne").hide();
      }
    }); 

    $("input[data-bootstrap-switch]").each(function(){
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
      })
  
     $.ajaxSetup({
         headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
     });
  
        $('#submitAgenda').click(function() {
          if (($("#klien_id_select").val() != '' && $("#klien_id_select").val() != null) && ($("#jam_selesai").val() != '' && $("#jam_selesai").val() != null)) {
            // jika ada klien dan dia mau bikin TL maka harus ada dokumennya juga
            $("#dokumen_id_select").addClass("required-field-agenda");
          }else{
            $("#dokumen_id_select").removeClass("required-field-agenda");
          }

          if($('#terlaksana').is(':checked')){
            terlaksana = 1;
          }else{
            // jika tidak terlaksana maka tindak lanjutnya kosong kecuali jam selesai agar dihitung checked
            terlaksana = 0;
            $('#lokasi').val('');
            var dt = new Date();
            var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
            $('#jam_selesai').val(time);
            $('#dokumen_id_select').empty();
            $('#catatan').val('');
            // hapus required agar bisa save
            $("#dokumen_id_select").removeClass("required-field-agenda");
          }

          if(validateForm('agenda')){
            let token   = $("meta[name='csrf-token']").attr("content");
            $.ajax({
              url: "{{ route('agenda.store') }}",
              type: "POST",
              cache: false,
              data: {
                uuid: $('#uuid').val(),
                judul_kegiatan: $('#judul_kegiatan').val(),
                tanggal_mulai: $("#tanggal_mulai").val(),
                jam_mulai: $("#jam_mulai").val(),
                keterangan: $("#keterangan-agenda").val(),
                klien_id: $("#klien_id_select").val(),
                user_id: $("#user_id_select").val(),
                lokasi: $("#lokasi").val(),
                jam_selesai: $("#jam_selesai").val(),
                catatan: $("#catatan").val(),
                dokumen_pendukung: $("#dokumen_id_select").val(),
                terlaksana: terlaksana,
                _token: token
              },
              success: function (response){
                if (response.success != true) {
                  $('#message-agenda').html(JSON.stringify(response));
                  $("#success-message-agenda").hide();
                  $("#error-message-agenda").show();
                }else{
                  $('#message-agenda').html(response.message);
                  $("#success-message-agenda").show();
                  $("#error-message-agenda").hide();
                  // fullcalendar dashboard
                  if($("#calendar").length > 0) {
                    calendar.fullCalendar('refetchEvents');
                    calendar.fullCalendar('unselect');
                    today = new Date();
                    today = today.toISOString().split('T')[0];
                    loadAgenda(today,2);
                  }
                  // datatable kinerja
                  if($("#tabelAgenda").length > 0) {
                    $('#tabelAgenda').DataTable().ajax.reload();
                    // hightlight tabel agenda
                    data = response.data;
                    $('#uuid_agenda_hightlight').val(data.uuid);
                  }
                  // datatable layanan di detail kasus
                  if($("#tabelLayanan").length > 0) {
                    $('#tabelLayanan').DataTable().ajax.reload();
                    $('#tabelResumeLayanan').DataTable().ajax.reload();
                    // hightlight tabel layanan
                    data = response.data;
                    $('#uuid_layanan_hightlight').val(data.uuid);
                  }
                  // opsi di create dokumen
                  if($("#uuid_tindak_lanjut").length > 0) {
                    load_select2_agenda();
                  }
                  // untuk load progress layanan di detail kasus 
                  if ($(".persen_title_layanan").length > 0 && $("#klien_id_select").val() != null) {
                    check_kelengkapan_perencanaan($("#klien_id_select").val());
                  }
                  // kirim realtime notifikasi
                  socket.emit('notif_count', {
                    receiver_id : response.notif_receiver
                  });
                  loadnotif();
                  // hapus semua inputan
                  $('#judul_kegiatan').val('');
                  $('#tanggal_mulai').val('');
                  $('#jam_mulai').val('');
                  $('#keterangan-agenda').val('');
                  $('#klien_id_select').val('').change();
                  $('#lokasi').val('');
                  $('#jam_selesai').val('');
                  $('#catatan').val('');
                  $('#user_id_select').empty();
                  $('#dokumen_id_select').empty();
                }
              },
              error: function (response){
                setTimeout(function(){
                  $("#overlay").fadeOut(300);
                },500);
  
                $('#message-agenda').html(JSON.stringify(response));
                $("#success-message-agenda").hide();
                $("#error-message-agenda").show();
              }
            }).done(function() { //loading submit form
                setTimeout(function(){
                  $("#overlay").fadeOut(300);
                },500);
              });
          }else{
            $('#message-agenda').html('Mohon cek ulang data yang wajib diinput.');
            $("#success-message-agenda").hide();
            $("#error-message-agenda").show();
          }
          $('#ajaxModel').scrollTop(0);
        });
      
     });
  
    function load_select2_klien() {
      let token   = $("meta[name='csrf-token']").attr("content");
      $( "#klien_id_select" ).select2({
         ajax: { 
           url: "{{route('get_klien')}}",
           type: "post",
           dataType: 'json',
           delay: 250,
           data: function (params) {
             return {
                _token: token,
                search: params.term // search term
             };
           },
           processResults: function (response) {
            $("#overlay").hide();
             return {
               results: response
             };
           },
           cache: false
         }
  
      });
    }
  
    function load_select2_petugas(klien_id='') {   
      klien_id = $( "#klien_id_select" ).val();
      if (klien_id != null) {
        $('#user_id_select').val([]).change()
      }
      let token   = $("meta[name='csrf-token']").attr("content");
      $( ".user_id_select" ).select2({
         ajax: { 
           url: "{{route('get_petugas')}}?klien_id="+klien_id,
           type: "post",
           dataType: 'json',
           delay: 250,
           data: function (params) {
             return {
                _token: token,
                search: params.term, // search term
                klien_id: klien_id
             };
           },
           processResults: function (response) {
            $("#overlay").hide();
             return {
               results: response
             };
           },
           cache: false
         }
      });
    }
  
    function load_select2_dokumen() { 
      let token   = $("meta[name='csrf-token']").attr("content");
      $( "#dokumen_id_select" ).select2({
         ajax: { 
           url: "{{route('get_dokumen')}}",
           type: "POST",
           dataType: 'json',
           delay: 250,
           data: function (params) {
             return {
                _token: token,
                search: params.term // search term
             };
           },
           processResults: function (response) {
            $("#overlay").hide();
             return {
               results: response
             };
           },
           cache: false
         }
  
      });
    }
      
     function displayMessage(message) {
         toastr.success(message, 'Event');
     } 
  
    function display_c(){
      var refresh=1000; // Refresh rate in milli seconds
      mytime=setTimeout('display_ct()',refresh)
    }
  
    function display_ct() {
      var x = new Date();
      var x1=x.getDate() + "-" + x.getMonth() + 1+ "-" +  x.getFullYear(); 
      x1 = x1 + " " +  x.getHours( )+ ":" +  x.getMinutes() + ":" +  x.getSeconds();
      document.getElementById('ct').innerHTML = x1;
      display_c();
    }
       
    function penjadwalan_layanan() {
      if ($('#penjadwalan_layanan').val() == 0) {
        $("#list_klien").hide();
        $('#klien_id_select').val('').change();
      } else {
        $("#list_klien").show();
      }
   }
   
   function showModalAgenda(tanggal_mulai, agenda_id) {
    //reset uuid
    $('#uuid').val('');
  
    $('#user_id_select').empty();
    $('#user_id_select').html('');
    $('#user_id_select').append('<option value="{{ Auth::user()->id }}" selected>{{ Auth::user()->name }}</option>');
    $('#dokumen_id_select').empty();
    $("#collapseOne").removeClass("show");
    
    if (agenda_id != 0) {
    $('#user_id_select').empty();
      $.get(`{{ env('APP_URL') }}/agenda/edit/`+agenda_id, function (data) {
          $('#modelHeadingAgenda').html("Edit Agenda");
  
          $('#uuid').val(data.uuid);
          $('#judul_kegiatan').val(data.judul_kegiatan);
          $('#tanggal_mulai').val(data.tanggal_mulai);
          $('#jam_mulai').val(data.jam_mulai);
          $('#keterangan-agenda').val(data.keterangan);
          $('#klien_id_select').val(data.klien_id);
          $('#lokasi').val(data.lokasi);
          $('#jam_selesai').val(data.jam_selesai);
          $('#catatan').val(data.catatan);
          if (data.klien_id != null) {
            $('#penjadwalan_layanan').val(1);
            $("#klien_id_select").append('<option value="'+data.klien_id+'" selected>'+data.nama+'</option>');
          }else{
            $('#penjadwalan_layanan').val(0);
            $("#klien_id_select").val('').change();
          }
          if (data.user_id != null) {
            $('#user_id_select').val([]).change();
            petugas = data.user_id;
            petugas.forEach(e => {
              $("#user_id_select").append('<option value="'+e.id+'" selected>'+e.name+'</option>');
              if (e.id != "{{ Auth::user()->id }}") {
                // mencegah menghapus orang lain selain dirinya
                $('#styleremove').append('.select2-selection__choice[title="'+e.name+'"] .select2-selection__choice__remove {display: none;}.select2-results__option[aria-selected=true] {display: none;}');
              }
            });
          }
          $('#dokumen_id_select').val([]).change();
          dokumen = data.dokumen_id;
          dokumen.forEach(e => {
            $("#dokumen_id_select").append('<option value="'+e.id+'" selected>'+e.judul+'</option>');
          });
          penjadwalan_layanan();
          $("#collapseOne").addClass("show");
      });
    }
    
    $("#success-message-agenda").hide();
    $("#error-message-agenda").hide();
    $("#overlay").hide();
    
    // hapus semua inputan
    $('#judul_kegiatan').val('');
    $('#jam_mulai').val('');
    $('#keterangan-agenda').val('');
    $('#penjadwalan_layanan').val(0);
    $('#list_klien').hide(); 
    $('#klien_id_select').val('').change();
    $('#lokasi').val('');
    $('#jam_selesai').val('');
    $('#catatan').val('');
    $('#tanggal_mulai').val(tanggal_mulai); 
    $('#modelHeadingAgenda').html('Tambah Agenda'); 
    $('#ajaxModel').modal('show'); 
    $('#ajaxModelDetail').modal('hide'); 
    
    if ($("#nama_klien_modal_agenda").length > 0) {
      // jika di halaman show klien maka tambah agenda untuk klien di show ini
      $('#penjadwalan_layanan').val(1);
      $("#list_klien").show();
      $("#klien_id_select").append('<option value="'+$("#id_klien_modal_agenda").val()+'" selected>'+$("#nama_klien_modal_agenda").val()+'</option>');
    }
   }
</script>