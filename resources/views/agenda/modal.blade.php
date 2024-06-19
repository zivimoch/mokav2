<style>
    .modal {  
        overflow-y:auto;
    }

    .form-group-layanan {
      display: none;
    }

    .invalid-feedback2 {
      width: 100%;
      background-color:red !important;
      color:white !important;
      font-size: 15px !important;
      padding: 2px 5px;
      font-weight: bold;
      display: none;
    }

    .clock-timepicker {
      width:100% !important;
    }
</style>
<style id="styleremove"></style>


<!-- Modal Agenda-->
<div class="modal fade" id="ajaxModel" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">

      <div id="overlayAgenda" class="overlay dark">
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

      <span style="float:right; text-align:right; margin-right:15px">
          <a class="btn btn-xs bg-gradient-warning" id="tombol_edit_agenda" onclick="toggleAgenda()">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a class="btn btn-xs bg-gradient-secondary" id="tombol_view_agenda" onclick="toggleAgenda()">
            <i class="fas fa-times"></i> Batal
        </a>
      </span>
      
      <div id="viewAgenda">
        <div class="modal-body"  style="margin-bottom: -15px">
          <table class="table table-bottom table-sm">
            <tr>
              <td style="width: 20%"><b>Judul Kegiatan<b></td>
              <td style="width:1%"><b>:</b></td>
              <td id="viewKegiatan"></td>
            </tr>
            <tr>
              <td style="width: 20%"><b>Nama Petugas </b></td>
              <td style="width: 1%"><b>:</b></td>
              <td id="viewPetugas"></td>
            </tr>
            <tr class="viewAgendaLayanan">
              <td style="width: 20%"><b>Nama Klien </b></td>
              <td style="width: 1%"><b>:</b></td>
              <td id="viewKlien"></td>
            </tr>
            <tr>
              <td style="width: 20%"><b>Jenis Agenda </b></td>
              <td style="width: 1%"><b>:</b></td>
              <td id="viewJenisAgenda"></td>
            </tr>
            <tr class="viewAgendaLayanan">
              <td style="width: 20%"><b>Deskripsi Proses </b></td>
              <td style="width: 1%"><b>:</b></td>
              <td id="viewProses"></td>
            </tr>
            <tr>
              <td colspan="3">
                <b>Tindak Lanjut Yang Dilakukan Oleh <span id="viewTLPetugas" style="color: blue"></span> : </b>
              </td>
            </tr>
            <tr>
              <td style="width: 20%"><b>Lokasi Kegiatan </b></td>
              <td style="width: 1%"><b>:</b></td>
              <td id="viewLokasi"></td>
            </tr>
            <tr>
              <td style="width: 20%"><b>Tanggal / Waktu </b></td>
              <td style="width: 1%"><b>:</b></td>
              <td id="viewTanggalWaktu"></td>
            </tr>
            <tr class="viewAgendaLayanan">
              <td style="width: 20%"><b>Detail Layanan </b></td>
              <td style="width: 1%"><b>:</b></td>
              <td id="viewLayanan"></td>
            </tr>
            <tr class="viewAgendaLayanan">
              <td style="width: 20%"><b>Deskripsi Hasil </b></td>
              <td style="width: 1%"><b>:</b></td>
              <td id="viewHasil"></td>
            </tr>
            <tr class="viewAgendaLayanan">
              <td style="width: 20%"><b>Rencana Tindak Lanjut </b></td>
              <td style="width: 1%"><b>:</b></td>
              <td id="viewRTL"></td>
            </tr>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-block" onclick="alert('fitur belum tersedia')"><i class="fas fa-print"></i> Print Laporan Kegiatan Ini</button>
        </div>
      </div>

      <div id="editAgenda" style="display: none">
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
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
              <label>Judul Kegiatan<span class="text-danger">*</span> </label>
              <input type="text" class="form-control required-field-agenda titlecase" id="judul_kegiatan">
              <div class="invalid-feedback2" id="valid-judul_kegiatan">
                Kegiatan wajib diisi.
              </div>
              <a href="#" onclick="listLayanan()">Lihat layanan yang tersedia untuk Perencanaan Intervensi</a>
          </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
              <label>Tanggal<span class="text-danger">*</span></label>
              <input type="date" class="form-control required-field-agenda" id="tanggal_mulai">
              <div class="invalid-feedback2" id="valid-tanggal_mulai">
                Tanggal Mulai wajib diisi.
              </div>
          </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Jam mulai<span class="text-danger">*</span></label>
                <input type="text" class="form-control required-field-agenda time-picker" id="jam_mulai-agenda" data-precision="5" style="width: 100% !important">
                <div class="invalid-feedback2" id="valid-jam_mulai-agenda">
                  Jam Mulai wajib diisi.
                </div>
            </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="form-group clearfix">
            <label>Jenis Agenda</label>
            <br>
            <div class="icheck-primary d-inline">
                <input type="radio" id="radioPrimary1" name="penjadwalan_layanan" checked value="1" onchange="penjadwalan_layanan()">
                <label for="radioPrimary1">
                    Agenda Layanan
                </label>
            </div>
            <div class="icheck-primary d-inline">
                <input type="radio" id="radioPrimary2" name="penjadwalan_layanan" value="0" onchange="penjadwalan_layanan()">
                <label for="radioPrimary2">
                    Agenda Non-Layanan
                </label>
            </div>
        </div>
        </div>
        <div class="col-md-4">
          <div class="form-group" style="background-color:#fff; transparent:50%">
            <label>Pilih Klien<span class="text-danger required-layanan">*</span></label>
            <select data-placeholder="Pilih nama" style="width: 100%;" id="klien_id_select" onchange="load_select2_petugas()"></select>
            <div class="col-md-12" style="background-color:aliceblue; padding:10px; display:none" id="detail_data_klien"></div>
            <div class="invalid-feedback2" id="valid-klien_id_select">
              Klien wajib ada.
            </div>  
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Tags</label>
            <select multiple="multiple" data-placeholder="Pilih nama" style="width: 100%;" class="user_id_select" id="user_id_select" style="height: 15px">
            </select>
            <div class="invalid-feedback2" id="valid-user_id_select">
              Minimal tag 1 orang.
            </div>
          </div>
        </div>
      </div>
      <div class="form-group form-group-layanan">
          <label>Deskripsi Proses<span class="text-danger required-layanan">*</span></label>
          <textarea name="" class="form-control tinymce" id="keterangan-agenda" style="background-color:red"></textarea>
          <div class="invalid-feedback2" id="valid-keterangan-agenda">
            Deskripsi Proses wajib diisi jika agenda layanan.
          </div>  
        </div>
      {{-- <div class="form-group">
          <label>Penjadwalan Layanan</label>
          <select class="form-control" id="penjadwalan_layanan" onchange="penjadwalan_layanan()">
            <option value="0">Tidak</option>
            <option value="1">Ya</option>
          </select>
      </div> --}}
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
                  <div class="col-md-4">
                      <div class="form-group">
                        <label>Lokasi Kegiatan<span class="text-danger">*</span></label>
                        <input type="text" class="form-control titlecase" id="lokasi">
                        <div class="invalid-feedback2" id="valid-lokasi">
                          Lokasi Kegiatan wajib diisi jika sedeng mengisi Jam Selesai.
                        </div> 
                    </div>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group">
                          <label>Jam Selesai<span class="text-danger">*</span></label>
                          <?php
                            date_default_timezone_set("asia/jakarta");
                            $jam_selesai = date("h:i");
                          ?>
                          <input type="text" class="form-control time-picker" id="jam_selesai" data-precision="5" style="width: 100% !important" value="{{ $jam_selesai }}">
                          <a href="#" id="reset-jam-selesai">Reset</a>
                        </div>
                  </div>
                  <div class="col-md-5">
                      <div class="form-group">
                        <label>Detail Layanan (bisa lebih dari 1)<span class="text-danger required-layanan">*</span></label>
                        <select multiple="multiple" style="width: 100%;" class="select-tag" id="keyword-agenda"></select>
                        <div class="invalid-feedback2" id="valid-keyword-agenda">
                          Keyword Hasil wajib diisi jika agenda layanan.
                        </div> 
                      </div>
                  </div>
                </div>
                {{-- <div class="form-group">
                <label>Dokumen pendukung <span style="font-size: 12px">(lihat dokumen tersedia <a href="{{ route('dokumen') }}" target="_blank">disini</a>)<br>*Laporan Hasil Kegiatan</span></label>
                <select multiple="multiple" data-placeholder="Pilih judul dokumen" style="width: 100%;" id="dokumen_id_select"></select>
                  <div class="invalid-feedback" id="valid-dokumen_id_select">
                    Dokumen pendukung wajib diisi jika menTL Penjadwalan Layanan.
                  </div>  
                </div> --}}
                <div class="form-group form-group-layanan">
                    <label>Deskripsi Hasil<span class="text-danger required-layanan">*</span></label>
                    <textarea name="" class="form-control tinymce" id="catatan-agenda" cols="30" rows="2"></textarea>
                    <div class="invalid-feedback2" id="valid-catatan-agenda">
                      Deskripsi Hasil wajib diisi jika agenda layanan.
                    </div>  
                </div>
                <div class="form-group form-group-layanan">
                    <label>Rencana Tindak Lanjut<span class="text-danger required-layanan">*</span></label>
                    <textarea name="" class="form-control tinymce" id="rtl-agenda" cols="30" rows="2"></textarea>
                    <div class="invalid-feedback2" id="valid-rtl-agenda">
                      Rencana Tindak Lanjut wajib diisi jika agenda layanan.
                    </div>  
                </div>
                {{-- <div class="form-group">
                    <label>Link Survey Kepuasan</label>
                    <div class="input-group">
                      <input type="text" class="form-control" id="link-form" value="coming soon..." tabindex="-1" aria-hidden="true" style="background: #eaebeb;font-size: 14px;font-weight: bold;">
                      <div class="input-group-append">
                          <span class="input-group-text pointer" onclick="copyClipboard()" onmouseout="copyClipboardOut()" data-toggle="tooltip" data-placement="top" title="" data-original-title="Copy Link to Clipboard" id="copy-btn">
                              <i class="fa fa-fw" aria-hidden="true"></i>
                          </span>
                      </div>
                  </div>
                </div> --}}
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
</div>

<!-- Modal List Layanan-->
<div class="modal fade" id="listLayanan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div id="overlayListLayanan" class="overlay dark">
        <div class="cv-spinner">
          <span class="spinner"></span>
        </div>
      </div>

      <div class="modal-header">
        <h5 class="modal-title">List Detail Layanan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body"  style="margin-bottom: -15px;">
        <h6>Klik salah 1 detail layanan untuk dimunculkan di Judul Kegiatan</h6>
        <div id="list_layanan" style="height:400px; overflow-y:scroll"></div>
      </div>

      <div class="modal-footer"></div>

    </div>
  </div>
</div>

  <script src="{{ asset('/source/js/validation.js') }}"></script>
  
<script src="{{ asset('vendor/tinymce4/tinymce.min.js') }}"></script>
<script src="{{ asset('adminlte') }}/plugins/moment/moment.min.js"></script> 
  <script src="{{ asset('source') }}/js/jquery-clock-timepicker.min.js"></script>
  <script src="{{ asset('adminlte') }}/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script>
  
   // Function to toggle between view and edit modes
   function toggleAgenda() {
      $("#viewAgenda, #editAgenda").toggle();
      $("#tombol_edit_agenda, #tombol_view_agenda").toggle();
    }

    // Initial setup
    $("#editAgenda, #tombol_view_agenda").hide();
    $(document).ready(function() {
      $('#reset-jam-selesai').click(function(event) {
          event.preventDefault(); // Prevent the default link behavior
          $('#jam_selesai').val(''); // Set the value to null (empty string)
      });

      $('.select-tag').select2({
        tags: true,
        theme: 'bootstrap4'
      });  
    $('.time-picker').clockTimePicker();
    load_select2_klien();
    load_select2_petugas();
    load_select2_dokumen();
    load_select2_keyword();
    display_ct();
    $('#klien_id_select').prop('disabled', true);
    $('#keyword-agenda').prop('disabled', true);
    $('.required-layanan').hide();
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
      $("#overlayAgenda").show();

      if ($("#jam_selesai").val() != '' && $("#jam_selesai").val() != null) {
        $("#lokasi").addClass("required-field-agenda");
      } else {
        $("#lokasi").removeClass("required-field-agenda");
      }
          if (
              ($("#klien_id_select").val() != '' && $("#klien_id_select").val() != null) 
              && 
              ($("#jam_selesai").val() != '' && $("#jam_selesai").val() != null)
            ) {
            // jika ada klien dan dia mau bikin TL maka harus ada deskripsi hasil dan rtl
            $("#keyword-agenda").addClass("required-field-agenda");
            $("#catatan-agenda").addClass("required-field-agenda");
            $("#rtl-agenda").addClass("required-field-agenda");
          }else{
            $("#keyword-agenda").removeClass("required-field-agenda");
            $("#catatan-agenda").removeClass("required-field-agenda");
            $("#rtl-agenda").removeClass("required-field-agenda");
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
            $('#keyword-agenda').empty();
            $('#dokumen_id_select').empty();
            $('#user_id_select').val([]).change();
            $('#user_id_select').empty();
            $('#catatan').val('');
            // hapus required agar bisa save
            $("#keyword-agenda").removeClass("required-field-agenda");
            $("#dokumen_id_select").removeClass("required-field-agenda");
          }

          if(validateForm('agenda')){
            var selectedValues = $("#user_id_select").val();
            if (selectedValues.indexOf('{{ Auth::user()->id }}') == -1) {
              var confirmation = confirm("Nama anda tidak ada di Tags, apakah anda ingin agenda ini TIDAK TERSIMPAN di akun anda?");
              if (confirmation) {
                action = 1;
              }else{
                action = 0;
                setTimeout(function() {
                    $("#overlayAgenda").hide(); // Hide overlay after 1 second delay
                }, 500);
              }
            }else{
              action = 1;
            }

            if (action == 1) {
              let token   = $("meta[name='csrf-token']").attr("content");
                $.ajax({
                  url: "{{ route('agenda.store') }}",
                  type: "POST",
                  cache: false,
                  data: {
                    uuid: $('#uuid').val(),
                    judul_kegiatan: $('#judul_kegiatan').val(),
                    tanggal_mulai: $("#tanggal_mulai").val(),
                    jam_mulai: $("#jam_mulai-agenda").val(),
                    keterangan: tinyMCE.get('keterangan-agenda').getContent(), // deskripsi proses
                    klien_id: $("#klien_id_select").val(),
                    user_id: $("#user_id_select").val(),
                    lokasi: $("#lokasi").val(),
                    jam_selesai: $("#jam_selesai").val(),
                    keyword: $("#keyword-agenda").val(),
                    catatan: tinyMCE.get('catatan-agenda').getContent(),
                    rtl: tinyMCE.get('rtl-agenda').getContent(),
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
                        loadAgenda('{{  date("Y-m-d") }}',2);
                      }
                      // datatable kinerja
                      if($("#tabelAgenda").length > 0) {
                        $('#tabelAgenda').DataTable().ajax.reload(null, false);
                        // hightlight tabel agenda
                        data = response.data;
                        $('#uuid_agenda_hightlight').val(data.uuid);
                      }
                      // datatable layanan di detail kasus
                      if($("#tabelLayanan").length > 0) {
                        $('#tabelLayanan').DataTable().ajax.reload(null, false);
                        $('#tabelResumeLayanan').DataTable().ajax.reload(null, false);
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
                      $('#uuid').val('');
                      $('#judul_kegiatan').val('');
                      $('#tanggal_mulai').val('');
                      $('#jam_mulai-agenda').val('');
                      tinyMCE.get('keterangan-agenda').setContent(''); // deskripsi proses
                      tinyMCE.get('catatan-agenda').setContent(''); // deskripsi hasil
                      tinyMCE.get('rtl-agenda').setContent(''); // rencana tindak lanjut
                      $('#klien_id_select').val('').change();
                      $('#keyword-agenda').val('').change();
                      $('#lokasi').val('');
                      $('#jam_selesai').val('');
                      $('#catatan').val('');
                      // $('#user_id_select').empty();
                      $('#keyword-agenda').empty();
                      $('#dokumen_id_select').empty();
                    }
                  },
                  error: function (response){
                    setTimeout(function(){
                      $("#overlayAgenda").fadeOut(300);
                    },500);
      
                    $('#message-agenda').html(JSON.stringify(response));
                    $("#success-message-agenda").hide();
                    $("#error-message-agenda").show();
                  }
                }).done(function() { //loading submit form
                    setTimeout(function(){
                      $("#overlayAgenda").fadeOut(300);
                    },500);
                  });
            }
          }else{
            $('#message-agenda').html('Mohon cek ulang data yang wajib diinput.');
            $("#success-message-agenda").hide();
            $("#error-message-agenda").show();
            setTimeout(function(){
              $("#overlayAgenda").fadeOut(300);
            },500);
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
            $("#overlayAgenda").hide();
             return {
               results: response
             };
           },
           cache: false
         }
  
      });
    }
  
    function load_select2_petugas(klien_id='') {
      $( "#klien_id_select" ).val();
      klien_id = $( "#klien_id_select" ).val();
      if (klien_id != null) {
        $('#user_id_select').val([]).change();
        showData(klien_id);
      }
      let token   = $("meta[name='csrf-token']").attr("content");
      // menampilkan detail klien
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
            $("#overlayAgenda").hide();
             return {
               results: response
             };
           },
           cache: false
         }
      });
    }

    function load_select2_keyword() {
      let token   = $("meta[name='csrf-token']").attr("content");
      $( "#keyword-agenda" ).select2({
         ajax: { 
           url: "{{route('get_keyword')}}",
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
            $("#overlayAgenda").hide();
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
            $("#overlayAgenda").hide();
             return {
               results: response
             };
           },
           cache: false
         }
  
      });
    }

    function listLayanan() {
      $.ajax({
              url: "{{route('get_keyword')}}?tampilkan_semua=1", 
              type: "post",
              dataType: 'json',
              delay: 250,
              data: function (params) {
                return {
                    _token: token,
                    search: params.term // search term
                };
              },
              success: function (response){
                $('#listLayanan').modal('show'); 
                $('#list_layanan').html('');
                response.forEach(e => {
                    // Append the main text (e.g., "1. Konselor", "2. Psikolog", etc.)
                    $('#list_layanan').append(`<p>${e.text}</p>`);

                    // Create a new unordered list
                    let ul = $('<ul></ul>');

                    e.children.forEach(child => {
                        // Create a list item
                        let li = $('<li></li>');

                        // Create an anchor tag
                        let a = $('<a href="#"></a>').text(child.text);

                        // Add click event listener to the anchor tag
                        a.click(function() {
                            // Append the text to the input field
                            let currentValue = $('#judul_kegiatan').val();
                            $('#judul_kegiatan').val(currentValue + ' ' + $(this).text());
                        });

                        // Append the anchor tag to the list item
                        li.append(a);

                        // Append the list item to the unordered list
                        ul.append(li);
                    });

                    // Append the unordered list to the main container
                    $('#list_layanan').append(ul);
                });
              },
              error: function (response){
                setTimeout(function(){
                  $("#overlayListLayanan").fadeOut(300);
                },500);
              }
        }).done(function() { //loading submit form
          setTimeout(function(){
            $("#overlayListLayanan").fadeOut(300);
          },500);
        });
    }
      
     function displayMessage(message) {
         toastr.success(message, 'Event');
     } 

     function showData(klien_id) {
      $.ajax({
              url: "{{ env('APP_URL') }}/kasus/show/"+klien_id+"?klien_id="+klien_id, // defaultnya pake uuid (digunakan di halaman index list klien), tapi dihalaman ini dia cuman bisa kasih id klien bukan uuid
              type: "GET",
              cache: false,
              dataType: 'json',
              success: function (response){
                dob = new Date(response.tanggal_lahir);
                var today = new Date();
                var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
                $('#detail_data_klien').html(`<a href="{{ env('APP_URL') }}/kasus/show/`+response.uuid+`" target="_blank">`+response.nama+` (`+age+`)</a> `+response.no_klien)
              },
              error: function (response){
                setTimeout(function(){
                  $("#overlayAgenda").fadeOut(300);
                },500);
              }
        }).done(function() { //loading submit form
          setTimeout(function(){
            $("#overlayAgenda").fadeOut(300);
          },500);
        });
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
      if ($('input[name="penjadwalan_layanan"]:checked').val() == 0) {
        // jika bukan agenda non-layanan
        $('#klien_id_select').prop('disabled', true);
        $('#klien_id_select').val('').change();

        $('#keyword-agenda').prop('disabled', true);
        $('#keyword-agenda').val('').change();

        $('.required-layanan').hide();

        $(".form-group-layanan").hide();

        $("#keterangan-agenda").removeClass("required-field-agenda");
        $('#klien_id_select').removeClass("required-field-agenda");
        $('#valid-keyword-agenda').hide();
        $('#valid-keterangan-agenda').hide();
        $('#valid-klien_id_select').hide();
        $('#valid-catatan-agenda').hide();
        $('#valid-rtl-agenda').hide();
      } else {
        $(".form-group-layanan").show();

        $('#klien_id_select').addClass("required-field-agenda");
        $('#klien_id_select').prop('disabled', false);
        $('#keyword-agenda').prop('disabled', false);
        $('.required-layanan').show();

        $("#keterangan-agenda").addClass("required-field-agenda");
      }
   }
   
   function showModalAgenda(tanggal_mulai, agenda_id, petugas_id) {
    $("#overlayAgenda").show();
    //reset uuid
    $('#uuid').val('');
    $('#user_id_select').val([]).change();
    $('#user_id_select').empty();
    $('#user_id_select').html('');
    $('#user_id_select').append('<option value="{{ Auth::user()->id }}" selected>{{ Auth::user()->name }}</option>');
    $('#keyword-agenda').empty();
    $('#dokumen_id_select').empty();
    $("#collapseOne").removeClass("show");
    
    if (agenda_id != 0) {
      // jika tidak kosong agenda_id nya alias edit tindak lanjut
      
      $("#collapseOne").addClass("show");
        $("#collapseOne").show();
      $('#user_id_select').empty();
        $.get(`{{ env('APP_URL') }}/agenda/edit/`+agenda_id+`?petugas=`+petugas_id, function (data) {
            $('#modelHeadingAgenda').html("View & Edit Agenda");
            $('#viewAgenda').show();
            $('#editAgenda').hide();

            $('#viewKegiatan').html(data.judul_kegiatan);
            if (data.klien_id !== null) {
              var jenisAgenda = 'Agenda Layanan';
            }else{
              var jenisAgenda = 'Agenda Non-Layanan';
            }
            $('#viewJenisAgenda').html(jenisAgenda);
            $('#viewKlien').html(data.nama);
            data_tindak_lanjut = data.data_tindak_lanjut;
            $('#viewTLPetugas').html(data_tindak_lanjut.name+' ('+data_tindak_lanjut.jabatan+')');
            $('#viewTanggalWaktu').html(data.tanggal_mulai+', '+data.jam_mulai+' s/d '+data_tindak_lanjut.jam_selesai);
            $('#viewLokasi').html(data_tindak_lanjut.lokasi);
            $('#viewProses').html(data_tindak_lanjut.keterangan);
            $('#viewHasil').html(data_tindak_lanjut.catatan);
            $('#viewRTL').html(data_tindak_lanjut.rtl);

            $('#uuid').val(data_tindak_lanjut.uuid);
            $('#judul_kegiatan').val(data_tindak_lanjut.judul_kegiatan);
            $('#tanggal_mulai').val(data_tindak_lanjut.tanggal_mulai);
            $('#jam_mulai-agenda').val(data_tindak_lanjut.jam_mulai);
            $('#klien_id_select').val(data_tindak_lanjut.klien_id);
            $('#lokasi').val(data_tindak_lanjut.lokasi);
            $('#jam_selesai').val(data_tindak_lanjut.jam_selesai);

            $('#user_id_select').empty();
            $('#user_id_select').val([]).change();


            if (data_tindak_lanjut.created_by == {{ Auth::user()->id }} || '{{ Auth::user()->jabatan }}' == 'Manajer Kasus') {
              // show and hide juga di atur di tabel intervensi dan agenda karna butuh untuk tau row mana yang di klik
              $('#tombol_edit_agenda').show();
            } else {
              $('#tombol_edit_agenda').hide();
            }
            
            $('#tombol_view_agenda').hide();

            if (data_tindak_lanjut.keterangan !== null && data_tindak_lanjut.keterangan !== undefined) {
                tinyMCE.get('keterangan-agenda').setContent(data_tindak_lanjut.keterangan);
            }
            if (data_tindak_lanjut.catatan !== null && data_tindak_lanjut.catatan !== undefined) {
                tinyMCE.get('catatan-agenda').setContent(data_tindak_lanjut.catatan);
            }
            if (data_tindak_lanjut.rtl !== null && data_tindak_lanjut.rtl !== undefined) {
                tinyMCE.get('rtl-agenda').setContent(data_tindak_lanjut.rtl);
            }

            if (data.klien_id != null) {
              // jika agenda layanan
              $('input[name="penjadwalan_layanan"][value="1"]').prop('checked', true);
              $("#klien_id_select").append('<option value="'+data.klien_id+'" selected>'+data.nama+'</option>');

              $('#klien_id_select').addClass("required-field-agenda");
              $('#klien_id_select').prop('disabled', false);
              $('#keyword-agenda').prop('disabled', false);
              $('.required-layanan').show();

              $(".form-group-layanan").show();
              $("#keterangan-agenda").addClass("required-field-agenda");

              // munculkan data-data layanan
              $('.viewAgendaLayanan').show();
            }else{
              $('input[name="penjadwalan_layanan"][value="0"]').prop('checked', true);
              $("#klien_id_select").val('').change();
              // sembunyikan data-data layanan
              $('.viewAgendaLayanan').hide();
            }
            
            if (data.user_id != null) {
              $('#user_id_select').val([]).change();
              petugas = data.user_id;
              petugas.forEach(e => {
                $("#user_id_select").append('<option value="'+e.id+'" selected>'+e.name+'</option>');
                $('#viewPetugas').append(e.name+', ');              
                if (e.id != "{{ Auth::user()->id }}") {
                  // mencegah menghapus orang lain selain dirinya
                  $('#styleremove').append('.select2-selection__choice[title="'+e.name+'"] .select2-selection__choice__remove {display: none;}.select2-results__option[aria-selected=true] {display: none;}');
                }
              });
            }

            $('#keyword-agenda').val([]).change();
            keyword = data.keyword;
            keyword.forEach(e => {
              $("#viewLayanan").append(e.value+', ');
              $("#keyword-agenda").append('<option value="'+e.value+'" selected>'+e.value+'</option>');
            });

            $('#dokumen_id_select').val([]).change();
            dokumen = data.dokumoverlayAgendaen_id;
            dokumen.forEach(e => {
              $("#dokumen_id_select").append('<option value="'+e.id+'" selected>'+e.judul+'</option>');
            });
            penjadwalan_layanan();
            $("#collapseOne").addClass("show");
        });
    }else{
      // jika tambah
      $('#modelHeadingAgenda').html('Tambah Agenda'); 
      $(".form-group-layanan").hide();
      $('#viewAgenda').hide();
      $('#editAgenda').show();
      $('#tombol_edit_agenda').hide();
      $('#tombol_view_agenda').hide();
    }
    
    $("#success-message-agenda").hide();
    $("#error-message-agenda").hide();
    
    // hapus semua inputan
    $('#judul_kegiatan').val('');
    $('#jam_mulai-agenda').val('');
    tinyMCE.get('keterangan-agenda').setContent('');
    $('input[name="penjadwalan_layanan"][value="0"]').prop('checked', true);
    $('#klien_id_select').prop('disabled', true);
    $('#klien_id_select').removeClass('required-field-agenda');
    $('#keyword-agenda').removeClass('required-field-agenda');
    $('#keterangan-agenda').removeClass('required-field-agenda');
    $('#catatan-agenda').removeClass('required-field-agenda');
    $('#rtl-agenda').removeClass('required-field-agenda');
    $('#klien_id_select').val('').change();
    $('#keyword-agenda').prop('disabled', true);
    $('#keyword-agenda').val('').change();
    $('.required-layanan').hide();
    $('#lokasi').val('');
    $('#jam_selesai').val('');
    tinyMCE.get('catatan-agenda').setContent('');
    tinyMCE.get('rtl-agenda').setContent('');
    $('#tanggal_mulai').val(tanggal_mulai); 
    $('#viewKegiatan').html('');
    $('#viewPetugas').html('');
    $('#viewTanggalWaktu').html('');
    $('#viewLokasi').html('');
    $('#viewJenisAgenda').html('');
    $('#viewLayanan').html('');
    $('#viewProses').html('');
    $('#viewHasil').html('');
    $('#viewRTL').html('');
    $('#user_id_select').empty();
    $('#user_id_select').val([]).change();
    // masukan nama kita sebagai default
    $("#user_id_select").append('<option value="{{ Auth::user()->id }}" selected>{{ Auth::user()->name }}</option>');

    $('#ajaxModel').modal('show'); 
    $('#ajaxModelDetail').modal('hide'); 
    
    if ($("#id_klien_modal_agenda").length > 0) {
      // jika di halaman show klien maka tambah agenda untuk klien di show ini
      $('input[name="penjadwalan_layanan"][value="1"]').prop('checked', true);
      $('#klien_id_select').prop('disabled', false);
      $('#klien_id_select').addClass("required-field-agenda");
      $('#keyword-agenda').prop('disabled', false);
      $('.required-layanan').show();

      $(".form-group-layanan").show();
      $("#keterangan-agenda").addClass("required-field-agenda");
      $('#keyword-agenda').change();

      $("#klien_id_select").append('<option value="'+$("#id_klien_modal_agenda").val()+'" selected>'+$("#nama_klien_modal_agenda").val()+'</option>');
      $('#klien_id_select').change();

      $('#user_id_select').append('<option value="{{ Auth::user()->id }}" selected>{{ Auth::user()->name }}</option>');
      $('#user_id_select').change();
    }

    // Hide overlay after all processes are done
    setTimeout(function() {
                $("#overlayAgenda").hide(); // Hide overlay after 1 second delay
            }, 500);
}


tinymce.init({
  table_class_list: [{
      title: 'None',
      value: ''
    },
    {
      title: 'Editable Table',
      value: 'editablecontent'
    }
  ],
  height : "250",
  content_style: "body { font-family: Arial; }",
  selector: ".tinymce",
  menubar: 'file edit insert view format',
  toolbar: 'forecolor backcolor fontselect fontsizeselect | insertfile | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image responsivefilemanager | formatselect | fullscreen | ',
  lineheight_formats: "8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 20pt 22pt 24pt 26pt 36pt",
  plugins: [
    "advlist autolink lists link charmap print preview hr anchor pagebreak",
    "searchreplace wordcount visualblocks visualchars code fullscreen",
    "insertdatetime nonbreaking save table contextmenu directionality",
    "emoticons template paste textcolor colorpicker textpattern"
  ],
  contextmenu: 'copy custompaste',
  paste_as_text: true,
  font_formats: "Candara=candara;Cambria=cambria;Calibri=calibri;Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Oswald=oswald; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats",
  style_formats: [{
      title: 'Line height',
      items: [{
          title: 'Default',
          inline: 'span',
          styles: {
            'line-height': 'normal',
            display: 'inline-block'
          }
        },
        {
          title: '1',
          inline: 'span',
          styles: {
            'line-height': '1',
            display: 'inline-block'
          }
        },
        {
          title: '1.1',
          inline: 'span',
          styles: {
            'line-height': '1.1',
            display: 'inline-block'
          }
        },
        {
          title: '1.2',
          inline: 'span',
          styles: {
            'line-height': '1.2',
            display: 'inline-block'
          }
        },
        {
          title: '1.3',
          inline: 'span',
          styles: {
            'line-height': '1.3',
            display: 'inline-block'
          }
        },
        {
          title: '1.4',
          inline: 'span',
          styles: {
            'line-height': '1.4',
            display: 'inline-block'
          }
        },
        {
          title: '1.5',
          inline: 'span',
          styles: {
            'line-height': '1.5',
            display: 'inline-block'
          }
        },
        {
          title: '2 (Double)',
          inline: 'span',
          styles: {
            'line-height': '2',
            display: 'inline-block'
          }
        }
      ]
    }
  ],
  convert_fonts_to_spans: true,
  paste_word_valid_elements: "b,strong,i,em,h1,h2,u,p,ol,ul,li,a[href],span,color,font-size,font-color,font-family,mark,table,tr,td",
  paste_retain_style_properties: "all",
  automatic_uploads: true,
  image_advtab: true,
  images_upload_url: "",
  file_picker_types: 'image',
  paste_data_images: true,
  relative_urls: false,
  remove_script_host: false,
  file_picker_callback: function(cb, value, meta) {
    var input = document.createElement('input');
    input.setAttribute('type', 'file');
    input.setAttribute('accept', 'image/*');
    input.onchange = function() {
      var file = this.files[0];
      var reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onload = function() {
        var id = 'post-image-' + (new Date()).getTime();
        var blobCache = tinymce.activeEditor.editorUpload.blobCache;
        var blobInfo = blobCache.create(id, file, reader.result);
        blobCache.add(blobInfo);
        cb(blobInfo.blobUri(), {
          title: file.name
        });
      };
    };
    input.click();
  },
  setup: function (editor) {
    // Adding custom paste menu item using the older method for TinyMCE 4.x or fallback
    editor.addMenuItem('custompaste', {
      text: 'Paste',
      context: 'tools',
      onclick: function() {
        navigator.clipboard.readText().then(text => {
          editor.insertContent(text);
        }).catch(err => {
          console.error('Failed to read clipboard contents: ', err);
        });
      }
    });

    // Fallback for browsers that do not support navigator.clipboard
    editor.on('contextmenu', function (e) {
      if (!navigator.clipboard) {
        alert('Your browser does not support clipboard API. Please use Ctrl+V to paste.');
        e.preventDefault();
      }
    });
  }
});

    // Resolve conflict in jQuery UI tooltip with Bootstrap tooltip
    tinymce.PluginManager.add("editor-ruler", function(editor) {
  
  var domHtml;
  var lastPageBreaks;
  var pagen = tinymce.util.I18n.translate("p.");
  
  function refreshRuler() {
    try {
      domHtml = $(editor.getDoc().getElementsByTagName('HTML')[0]);
    } catch (e) {
      return setTimeout(refreshRuler, 50);
    }
  
    var dpi = 96
    var cm = dpi / 2.54;
    var a4px = cm * (29.7); // A4 height in px, -5.5 are my additional margins in my PDF print
  
    // ruler begins (in px)
    var startMargin = 0;
  
    // max size (in px) = document size + extra to be sure, idk, the height is too small for some reason
    var imgH = domHtml.height() + a4px * 5;
  
    var pageBreakHeight = 4; // height of the pagebreak line in tinyMce
  
    var pageBreaks = []; // I changed .mce-pagebreak with .page-break !!!
    domHtml.find('.page-break').each(function() {
      pageBreaks[pageBreaks.length] = $(this).offset().top;
    });
  
    pageBreaks.sort();
  
    // if pageBreak is too close next page, then ignore it
    if (lastPageBreaks == pageBreaks) {
      return; // no change
    }
  
    lastPageBreaks = pageBreaks;
  
    // console.log("Redraw ruler");
  
    var s = '';
    s += '<svg width="100%" height="' + imgH + '" xmlns="http://www.w3.org/2000/svg">';
  
    s += '<style>';
    s += '.pageNumber{font-weight:bold;font-size:20px;font-family:verdana;text-shadow:1px 1px 1px rgba(0,0,0,.6);}';
    s += '</style>';
  
    var pages = Math.ceil(imgH / a4px);
  
    var i, j, curY = startMargin;
    for (i = 0; i < pages; i++) {
      var blockH = a4px;
  
      var isPageBreak = 0;
      for (var j = 0; j < pageBreaks.length; j++) {
        if (pageBreaks[j] < curY + blockH) {
  
          // musime zmensit velikost stranky
          blockH = pageBreaks[j] - curY;
  
          // pagebreak prijde na konec stranky
          isPageBreak = 1;
          pageBreaks.splice(j, 1);
        }
      }
  
      curY2 = curY + 38;
      s += '<line x1="0" y1="' + curY2 + '" x2="100%" y2="' + curY2 + '" stroke-width="1" stroke="red"/>';
  
      // zacneme pravitko
      s += '<pattern id="ruler' + i + '" x="0" y="' + curY + '" width="37.79527559055118" height="37.79527559055118" patternUnits="userSpaceOnUse">';
      s += '<line x1="0" y1="0" x2="100%" y2="0" stroke-width="1" stroke="black"/>';
      s += '<line x1="24" y1="0" x2="0" y2="100%" stroke-width="1" stroke="black"/>';
      s += '</pattern>';
      s += '<rect x="0" y="' + curY + '" width="100%" height="' + blockH + '" fill="url(#ruler' + i + ')" />';
  
      // napiseme cislo strany
      s += '<text x="10" y="' + (curY2 + 19 + 5) + '" class="pageNumber" fill="#e03e2d">' + pagen + (i + 1) + '.</text>';
  
      curY += blockH;
      if (isPageBreak) {
        //s+= '<rect x="0" y="'+curY+'" width="100%" height="'+pageBreakHeight+'" fill="#ffffff" />';
        curY += pageBreakHeight;
      }
    }
  
    s += '</svg>';
  
    domHtml.css('background-image', 'url("data:image/svg+xml;utf8,' + encodeURIComponent(s) + '")');
  }
  
  function deleteRuler() {
  
    domHtml.css('background-image', '');
  }
  
  var toggleState = false;
  
  editor.on("NodeChange", function() {
    if (toggleState == true) {
      refreshRuler();
    }
  });
  
  
  editor.on("init", function() {
    if (toggleState == true) {
      refreshRuler();
    }
  });
  
  editor.ui.registry.addIcon("square_foot", '<svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24" viewBox="0 0 24 24" width="24">' +
    '<g><rect fill="none" height="24" width="24"/></g><g><g><path d="M17.66,17.66l-1.06,1.06l-0.71-0.71l1.06-1.06l-1.94-1.94l-1.06,1.06l-0.71-0.71' +
    'l1.06-1.06l-1.94-1.94l-1.06,1.06 l-0.71-0.71l1.06-1.06L9.7,9.7l-1.06,1.06l-0.71-0.71l1.06-1.06L7.05,7.05L5.99,8.11L5.28,7.4l1.06-1.06L4,4' +
    'v14c0,1.1,0.9,2,2,2 h14L17.66,17.66z M7,17v-5.76L12.76,17H7z"/></g></g></svg>');
  
  editor.ui.registry.addToggleMenuItem("ruler", {
    text: "Show ruler",
    icon: "square_foot",
    onAction: function() {
      toggleState = !toggleState;
      if (toggleState == false) {
        deleteRuler();
      } else {
        refreshRuler();
      }
    },
    onSetup: function(api) {
      api.setActive(toggleState);
      return function() {};
    }
  });
  
  });
</script>