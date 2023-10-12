@extends('layouts.template')

@section('content')
<style>
  .cursor-disabled {
    cursor:not-allowed;
  }
</style>
    {{-- DataTable --}}
     <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><i class="fas fa-tasks"></i> Laporan Kinerja</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
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
            
            <div class="card-body" style="overflow-x: scroll">
            <input type="hidden" id="uuid_agenda_hightlight" value="{{ Request::get('row-agenda') }}">
              <table id="tabelAgenda" class="table table-sm table-bordered  table-hover" style="cursor:pointer">
        
                <thead>
                  <tr>
                      <th>Tanggal</th>
                      <th>Jam</th>
                      <th>Agenda</th>
                      <th>Tindak Lanjut</th>
                      <th>Validasi</th>
                  </tr>
                  </thead>
                  <tbody></tbody>
                    <tfoot>
                      <th colspan="4"><center>Centang Semua</center></th>
                      <th><div class="icheck-success d-inline d-flex justify-content-around"><input type="checkbox" id="checkAll"><label for="checkAll"></label></div></th>
                    </tfoot>
              </table>

                  <div class="row">
                    <div class="col-md-6 text-center">
                        Jakarta, 31 Januari 2023</br>
                        Yang Membuat,</br>
                        <br>
                        <br>
                        <br>
                        <br>
                        Addzifi Mochamad Gumelar
                    </div>
                    <div class="col-md-6 text-center">
                        Jakarta, 31 Januari 2023</br>
                        Yang Memverifikasi,</br>
                        <br>
                        <br>
                        <br>
                        <br>
                        Sekretariat
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
      </div>
      <div class="modal-footer" id="buttonsDokumen">
      </div>
    </div>
  </div>
</div>

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
 $("#checkAll").click(function () {
     $('input:checkbox').not(this).prop('checked', this.checked);
 });

 function validasi(id) {
  // alert('apakah checked : '+$('#checkboxSuccess'+id).is(':checked'));
  // toastr.success('Berhasil update data', 'Event');
  alert('Fiture is Under Construction\n'+id);
 }
    
    $('#tabelAgenda').DataTable({
      "ordering": false,
      "processing": true,
      "serverSide": true,
      "responsive": false, 
      "lengthChange": false, 
      "autoWidth": false,
      "ajax": "/agenda/api_index?tahun={{ request()->get('tahun') }}&bulan={{ request()->get('bulan') }}&user_id={{ Auth::user()->id }}",
      "rowsGroup": [0],
      'createdRow': function( row, data, dataIndex ) {
          $(row).attr('id', data.uuid);
          rowHightlight = $('#uuid_agenda_hightlight').val();
          if (data.uuid == rowHightlight) {
            $(row).attr('class', 'hightlighting');
          }
      },
      "columns": [
        {"data": "tanggal_mulai", "width":"10%"},
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
              judul_kegiatan = keterangan = '';
              if (row.judul_kegiatan != null) {
                judul_kegiatan = '<b>'+row.judul_kegiatan+'</b>';
              }

              if (row.keterangan != null) {
                keterangan = '</br>'+row.keterangan;
              }

              return judul_kegiatan+keterangan;
            }
        },
        {
            "mData": "catatan",
            "mRender": function (data, type, row) {
              catatan = lokasi = '';

              if (row.catatan) {
                catatan = row.catatan+'<br>';
              }

              if (row.lokasi) {
                lokasi = 'Lokasi : '+row.lokasi;
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
                dokumens += '<a href="#" onclick="showModalDokumen(`'+uuid_dokumen+'`)"><span class="badge bg-primary"><i class="nav-icon fas fa-file-alt"></i> '+array[i]+'</span></a> ';
                };
              }else{
                dokumens = '';
              }

              if (row.terlaksana) {
                return lokasi+'<br>'+catatan+dokumens;
              } else {
                return '<span class="badge bg-danger">Dibatalkan</span>';
              }
            }
        },
        {
            "mRender": function (data, type, row) {
                if (row.name == null) {
                  return '<div class="icheck-success d-inline d-flex justify-content-around"><input type="checkbox" id="checkboxSuccess'+row.uuid+'" onchange="validasi(`'+row.uuid+'`)"><label for="checkboxSuccess'+row.uuid+'"></label></div>'
                }else{
                  return '<div class="icheck-success d-inline d-flex justify-content-around"><input type="checkbox" checked="" id="checkboxSuccess'+row.uuid+'" onchange="validasi(`'+row.uuid+'`)"><label for="checkboxSuccess'+row.uuid+'"></label></div>';
                }
            }
        },
      ],
      "columnDefs": [
        { className: "bg-light", "targets": [ 0 ] },
        { className: "cursor-disabled", "targets": [ 3, 4 ] }
      ],
      "pageLength": 25,
      "lengthMenu": [
          [10, 25, 50, 100, -1],
          ['10 rows', '25 rows', '50 rows', '100 rows','All'],
      ],
      "dom": 'Blfrtip', // Blfrtip or Bfrtip
      "buttons": ["pageLength", "copy", "csv", "excel", "pdf", "print", 
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
        if (($(evt.target).closest('td').index() !== 3) && ($(evt.target).closest('td').index() !== 4)) {
        $("#success-message").hide();
        $("#error-message").hide();
        showModalAgenda('',this.id);
        }
        });

      function showModalDokumen(uuid) { 
        $.ajax({
          url:'/dokumen/show/'+uuid,
          type:'GET',
          dataType: 'json',
          success: function( response ) {
            $("#overlay").hide();
            tinymce.activeEditor.setContent(JSON.parse(response.konten));
            $('#dokumenModal').modal('show');
            //munculkan tombol
            $('#buttonsDokumen').html('');
            $('#buttonsDokumen').append('<button type="button" class="btn btn-primary btn-block" id="detail" onclick="saveAndPrint()"><i class="fas fa-print"></i> Print Dokumen</button>');
            // $('#buttons').append('<button type="button" onclick="window.location.assign(`'+"{{route('dokumen.edit', '')}}"+"/"+data.uuid+'`)" class="btn btn-warning btn-block" id="terima"><i class="fas fa-edit"></i> Edit Dokumen</button>');
            // $('#buttonsDokumen').append('<button type="button" onclick="hapus(`'+data.uuid+'`)" class="btn btn-danger btn-block" id="hapus"><i class="fa fa-trash"></i> Hapus Dokumen</button>');
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