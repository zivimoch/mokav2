@extends('layouts.template')

@section('content')
<style>
  .cursor-disabled {
    cursor:not-allowed;
  }

  #tambahAgenda {
  display: none;
  position: fixed;
  bottom: 20px;
  right: 30px;
  z-index: 99;
  padding: 15px;
  border-radius: 4px;
}
</style>
    {{-- DataTable --}}
     <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-8">
            <h1 class="m-0"><i class="fas fa-tasks"></i> Laporan Kinerja <span style="color: blue">{{ $user->name.' ('.$user->jabatan.')' }}</span></h1>
          </div><!-- /.col -->
          <div class="col-sm-4 text-right">
            <input type="checkbox" class="btn-xs" id="kontainerwidth"
            {{ Auth::user()->settings_kontainer_width == 'normal' ? 'checked' : '' }}
                  data-bootstrap-switch 
                  data-on-text="Normal"
                  data-off-text="Fullwidth"
                  data-off-color="default" 
                  data-on-color="default">
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card">
            {{-- <div class="card-header">
            <h3 class="card-title">DataTable with default features</h3>
            </div> --}}
            {{-- <a href="{{ route('kinerja.detail') }}?tahun={{ date('Y') }}&bulan=01&user_id={{ Auth::user()->id }}"><button>Kinerja Bulan Januari klik Disini</button></a> --}}
            <div class="card-body" style="overflow-x: scroll">
              <form action="{{ route('kinerja.detail') }}" method="GET">
                <input type="hidden" name="user_id" value="{{ request()->user_id }}">
                <div class="input-group">
                    <select name="bulan" class="custom-select">
                        @foreach(range(1, 12) as $monthNumber)
                            @php
                                $monthName = date('F', mktime(0, 0, 0, $monthNumber, 1));
                                $selected = ($monthNumber == request()->bulan) ? 'selected' : '';
                            @endphp
                            <option value="{{ $monthNumber }}" {{ $selected }}>{{ $monthName }}</option>
                        @endforeach
                    </select>
                    <div class="input-group-append">
                        <select name="tahun" class="custom-select">
                            @php
                                $currentYear = request()->tahun;
                                $startYear = 2020;
                                $endYear = date('Y');
                            @endphp
                            @for ($year = $startYear; $year <= $endYear; $year++)
                                @php
                                    $selected = ($year == $currentYear) ? 'selected' : '';
                                @endphp
                                <option value="{{ $year }}" {{ $selected }}>{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Tampilkan</button>
                    </div>
                </div>
            </form>
            <input type="hidden" id="uuid_agenda_hightlight" value="{{ Request::get('row-agenda') }}">
            <input type="hidden" id="belumtl">
              <table id="tabelAgenda" class="table table-sm table-bordered  table-hover" style="cursor:pointer">
        
                <thead>
                  <tr>
                      <th>Tanggal</th>
                      <th>Jam</th>
                      <th>Agenda</th>
                      <th>Tindak Lanjut</th>
                      <th>DiTL</th>
                      @if (Auth::user()->jabatan == 'Sekretariat') 
                          <th>Valid</th>
                      @endif
                </tr>
                  </thead>
                  <tbody></tbody>
                  @if (Auth::user()->jabatan == 'Sekretariat')                      
                    <tfoot>
                      <th colspan="5"><center>Centang Semua</center></th>
                      <th><div class="icheck-danger d-inline d-flex justify-content-around"><input type="checkbox" id="checkAll" {{ $persen == 100? 'checked':'' }}><label for="checkAll"></label></div></th>
                    </tfoot>
                  @endif
                </table>

                  <div class="row">
                    <div class="col-md-6 text-center">
                        Jakarta, {{ \Carbon\Carbon::now()->endOfMonth()->format('d/m/Y'); }}</br>
                        Yang Membuat,</br>
                        <img src="{{ asset('img/tandatangan/ttd_user/'.Auth::user()->tandatangan) }}" alt="">
                        <br>
                        {{ Auth::user()->name }}
                    </div>
                </div>
            </div>
            
            </div>
      </div><!-- /.container-fluid -->
    </section>

<!-- Modal Dokumen -->
<div class="modal fade" id="dokumenModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">

      <div id="overlay" class="overlay dark">
        <div class="cv-spinner">
          <span class="spinner"></span>
        </div>
      </div>
      
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-card">
          <div class="form-group">

            <body data-editor="DecoupledDocumentEditor" data-collaboration="false">
              <div id="mytoolbar" style="width: 1000px"></div>
              <main>
                <div class="centered">
                  <div class="row-editor">
                    <textarea name="konten" readonly class="textarea-replace editor textarea-tinymce" id="konten">
                    </textarea>
                  </div>
                </div>
              </main>
            </body>
          </div>
        </div>
        <b>Agenda Terkait :</b>
        <div id="dokumen_tl"></div>
      </div>
      <div class="modal-footer" id="buttonsDokumen">
      </div>
    </div>
  </div>
</div>
<button id="tambahAgenda" class="btn btn-success btn-lg" onclick="showModalAgenda('{{ date(`Y-m-d`) }}',0)">Tambah Agenda</button>
<script src="{{ asset('adminlte') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/jszip/jszip.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{ asset('adminlte') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="https://cdn.rawgit.com/ashl1/datatables-rowsgroup/fbd569b8768155c7a9a62568e66a64115887d7d0/dataTables.rowsGroup.js"></script>

<script src="{{ asset('adminlte') }}/plugins/select2/js/select2.full.min.js"></script>

<script src="{{ asset('/source/js/validation.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
<script src="{{ asset('vendor/tinymce4/tinymce.min.js') }}"></script>

<script>
  window.onscroll = function() {scrollFunction()};
  function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
      $('#tambahAgenda').show();
    } else {
      $('#tambahAgenda').hide();
    }
  }
 $("#checkAll").click(function () {
     $('input:checkbox').not(this).prop('checked', this.checked);
     validasi('all', {{ $user->id }});
 });

 function validasi(id, user_id) {
  if (id != 'all') {
    checked = $('#checkboxSuccess'+id).is(':checked');
  } else {
    checked = $('#checkAll').is(':checked');
  }
  if (checked) {
    valid = 1;
  }else{
    valid = 0;
  }

  let token = $("meta[name='csrf-token']").attr("content");
  
  $.ajax({
  url: "{{ route('kinerja_valid') }}",
  type: "POST",
  cache: false,
  data: {
      uuid: id,
      valid: valid,
      user_id: user_id,
      tahun_agenda: {{ request()->tahun }},
      bulan_agenda: {{ request()->bulan }},
      _token: token
  },
  success: function (response){
    toastr.success('Berhasil update data', 'Event');
  },
  error: function (response){
      setTimeout(function(){
      $("#overlay").fadeOut(300);
      },500);
      console.log(response);
  }
  }).done(function() { //loading submit form
      setTimeout(function(){
      $("#overlay").fadeOut(300);
      },500);
  });
 }
    
    $('#tabelAgenda').DataTable({
      "ordering": false,
      "processing": true,
      "serverSide": true,
      "responsive": false, 
      "lengthChange": false, 
      "autoWidth": false,
      "ajax": "{{ env('APP_URL') }}/agenda/api_index?tahun={{ request()->get('tahun') }}&bulan={{ request()->get('bulan') }}&user_id={{ request()->get('user_id') }}",
      "rowsGroup": [0],
      'createdRow': function( row, data, dataIndex ) {
          $(row).attr('id', data.uuid);
          rowHightlight = $('#uuid_agenda_hightlight').val();
          if (data.uuid_agenda == rowHightlight) {
            $(row).attr('class', 'hightlighting');
          }
      },
      "columns": [
        {
            "mData": "tanggal_mulai",
            "width":"10%",
            "mRender": function (data, type, row) {
              return '<b>'+row.hari+'</b>, '+row.tanggal_mulai_formatted;
            }
        },
        {
            "mData": "jam_mulai",
            "mRender": function (data, type, row) {
              if (row.jam_selesai != null) {
                return row.jam_mulai+' - '+row.jam_selesai;
              }else{
                return row.jam_mulai;
              }
            }
        },
        {
            "mData": "judul_kegiatan",
            "mRender": function (data, type, row) {
              judul_kegiatan = '';
              if (row.judul_kegiatan != null) {
                judul_kegiatan = '<b>'+row.judul_kegiatan+'</b>';
              }

              return judul_kegiatan;
            }
        },
        {
            "mData": "catatan",
            "mRender": function (data, type, row) {
              lokasi = '';

              if (row.lokasi) {
                lokasi = '<b>Lokasi :</b> <br>'+row.lokasi;
              }

              if(row.judul != null){
                uuid_dokumen = row.uuid_dokumen;
                var array2 = uuid_dokumen.split(",|");

                dokumen = row.judul;
                dokumens = '';
                var array = dokumen.split(",|");
                for (i=1;i<array.length;i++){
                string = array2[i];
                uuid_dokumen = string.replace(/,/g, "");
                dokumens += '<a href="#" onclick="showModalDokumen(`'+uuid_dokumen+'`)"><span class="badge bg-primary" style="font-size:15px"><i class="nav-icon fas fa-file-alt"></i> '+array[i]+'</span></a> ';
                };
                dokumens = dokumens+'<br>';
              }else{
                dokumens = '';
              }

              if(row.keyword != null){
                detail_layanan = row.keyword;
                detail_layanans = '';
                var array = detail_layanan.split(",|");
                for (i=1;i<array.length;i++){
                detail_layanans += '<span class="badge bg-success" style="font-size:15px"><i class="nav-icon fas fa-tag"></i> '+array[i].replace(/,/g, '')+'</span> ';
                };
              }else{
                detail_layanans = '';
              }

              if (row.terlaksana) {
                return lokasi+'<br>'+dokumens+detail_layanans;
              } else {
                return '<span class="badge bg-danger">Dibatalkan</span>';
              }
            }
        },
        {
          "data" : "jam_selesai",
            "mRender": function (data, type, row) {
              if (row.jam_selesai == null) {
                    checked = '';
                } else {
                    checked = 'checked';
                }
                // if (row.created_by == {{ Auth::user()->id }}) {
                //     return '<div  class="icheck-success d-inline ml-2"><input type="checkbox" value="" '+checked+'><label for="todoCheck'+row.uuid+'"></label></div>';
                //     // return '<div  class="icheck-success d-inline ml-2"><input class="checkboxSelesai '+selesaiLayanan+'" type="checkbox" value="" id="todoCheck'+row.uuid+'" '+checked+' '+disabled+' onclick="showModalAgenda(`'+row.tanggal_mulai+'`,`'+row.uuid+'`,`'+row.created_by+'`)"><label for="todoCheck'+row.uuid+'"></label></div>';
                //     $('#tombol_edit_agenda').show();
                // } else {
                //     return '<div  class="icheck-success d-inline ml-2" onclick="alert(`Anda tidak memiliki hak akses untuk menginputkan laproan tindak lanjut untuk agenda ini. Minta seseorang yang ada di agenda untuk mentag/menambahkan anda.`)"><input type="checkbox" value="" '+checked+'><label for="todoCheck'+row.uuid+'"></label></div>';
                //     $('#tombol_edit_agenda').hide();
                // }
                return '<div  class="icheck-success d-inline ml-2"><input type="checkbox" value="" '+checked+'><label for="sudahDiTL'+row.uuid+'"></label></div>';
            }
        },
        {
            "mRender": function (data, type, row) {
              if (row.validated_by == null) {
                    done = '';
                    checked = '';
                } else {
                    done = 'done';
                    checked = 'checked';
                }
                if ('Sekretariat' == '{{ Auth::user()->jabatan }}') {
                    return '<div  class="icheck-danger d-inline ml-2"><input class="checkboxSelesai" type="checkbox" value="" id="checkboxSuccess'+row.uuid+'" '+checked+' onclick="validasi(`'+row.uuid+'`, `'+row.created_by+'`)"><label for="checkboxSuccess'+row.uuid+'"></label></div>';
                } else {
                    return '';
                    // return '<div  class="icheck-danger d-inline ml-2" onclick="alert(`Anda tidak memiliki hak akses. Hanya sekretariat yang dapat memvalidasi agenda`)"><input type="checkbox"  id="checkboxSuccess'+row.uuid+'" '+checked+' disabled><label for="checkboxSuccess'+row.uuid+'"></label></div>';
                }
            }
        },
      ],
      "columnDefs": [
        { className: "bg-light", "targets": [ 0 ] },
        { className: "cursor-disabled", "targets": [ 5 ] }
        // { className: "cursor-disabled", "targets": [ 3, 4 ] }
      ],
      "pageLength": 25,
      "lengthMenu": [
          [10, 25, 50, 100, -1],
          ['10 rows', '25 rows', '50 rows', '100 rows','All'],
      ],
      "dom": 'Blfrtip', // Blfrtip or Bfrtip
      "buttons": ["pageLength", "copy", {
                className: "btn-seconday",
                text: 'PDF',
                action: function (x) {
                    alert('Perhatian! Hanya agenda yang sudah divalidasi saja yang akan muncul di PDF');
                    redirectUrl = "{{ route('pdf_kinerja') }}?tahun={{ request()->tahun }}&bulan={{ request()->bulan }}&user_id={{ request()->user_id }}";
                    window.location.href = redirectUrl;
                  }
              }, {
                className: "btn-info",
                text: 'Lihat Agenda Belum DiTL',
                action: function (x) {
                  belumtl = $('#belumtl').val();
                  if (belumtl == 1) {
                    $('#belumtl').val(0);
                    x.currentTarget.innerText = 'Tampilkan Agenda Belum DiTL';
                  } else {
                    $('#belumtl').val(1);
                    x.currentTarget.innerText = 'Tampilkan Seluruh Agenda';
                  }
                  $('#tabelAgenda').DataTable().ajax.url("{{ env('APP_URL') }}/agenda/api_index?tahun={{ request()->get('tahun') }}&bulan={{ request()->get('bulan') }}&user_id={{ request()->get('user_id') }}&belumtl=" + $('#belumtl').val()).load();
                  }
              },
        {
          className: "btn-success",
          text: 'Tambah',
            action: function ( ) {
              $('#style-select2').html('.select2-selection__choice[title="{{ Auth::user()->name }}"] .select2-selection__choice__remove {display: none;}.select2-results__option[aria-selected=true] {display: none;}');
              showModalAgenda("{{ date('Y-m-d') }}",0);
            }
        }]
      }).buttons().container().appendTo('#tabelAgenda_wrapper .col-md-6:eq(0)');


       $('#tabelAgenda tbody').on( 'click', 'tr', function (evt) {
        if ($(evt.target).closest('td').index() !== 5) {
          $("#success-message").hide();
          $("#error-message").hide();
          var table = $('#tabelAgenda').DataTable();
          var rowData = table.row(this).data();

          // if (($(evt.target).closest('td').index() !== 2)) {
              showModalAgenda('',rowData.uuid_agenda, rowData.created_by);
          // }
          if (rowData.created_by == {{ Auth::user()->id }}) {
              $('#tombol_edit_agenda').show();
          } else {
              $('#tombol_edit_agenda').hide();
          }
        }
        });

      function showModalDokumen(uuid) { 
        $.ajax({
          url:"{{ env('APP_URL') }}/dokumen/show/"+uuid,
          type:'GET',
          dataType: 'json',
          success: function( data ) {
            $("#overlay").hide();
            dokumen_tl = data.dokumen_tl;
            data = data.data;
            tinymce.activeEditor.setContent(JSON.parse(data.konten));
            $('#dokumenModal').modal('show');
            //munculkan agenda terkait
            $('#dokumen_tl').html('');
            no_agenda = 1;
            dokumen_tl.forEach(e => {
              $('#dokumen_tl').append(no_agenda+'. '+e.judul_kegiatan+' (Tanggal '+e.tanggal_mulai+', Pukul '+e.jam_mulai+')</br>');
              no_agenda++;
            });
            //munculkan tombol
            $('#buttonsDokumen').html('');
            $('#buttonsDokumen').append('<button type="button" class="btn btn-primary btn-block" id="detail" onclick="saveAndPrint()"><i class="fas fa-print"></i> Print Dokumen</button>');
            $('#buttonsDokumen').append('<button type="button" onclick="window.location.assign(`'+"{{route('dokumen.edit', '')}}"+"/"+data.uuid+'`)" class="btn btn-warning btn-block" id="Edit"><i class="fas fa-edit"></i> Edit Dokumen</button>');
            $('#buttonsDokumen').append('<button type="button" onclick="hapus(`'+data.uuid+'`)" class="btn btn-danger btn-block" id="hapus"><i class="fa fa-trash"></i> Hapus Dokumen</button>');
            }
        });
    };

    tinymce.init({
        selector: ".textarea-tinymce",
        toolbar: '#mytoolbar',
        lineheight_formats: "8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 20pt 22pt 24pt 26pt 36pt",
        // ukuran A4 Potrait
        height: "500",
        readonly: 1,
        menubar: false,
        toolbar: false,
        plugins: 'textcolor table paste',
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],
        visual: false,
        toolbar: "saveandprint",
        convert_fonts_to_spans: true,
        paste_word_valid_elements: "b,strong,i,em,h1,h2,u,p,ol,ul,li,a[href],span,color,font-size,font-color,font-family,mark,table,tr,td",
        paste_retain_style_properties: "all",
        automatic_uploads: true,
        image_advtab: true,
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
        }
    });

    function saveAndPrint() {
        tinymce.activeEditor.execCommand('mcePrint');
    }

    $('#tabelAgenda_filter').css({'float':'right','display':'inline-block'});
</script>
{{-- include modal agenda --}}
@include('agenda.modal')
@endsection