@extends('layouts.template')

@section('content')
<style type="text/css">
  @media screen {
    @font-face {
      font-family: 'Cambria::Menu';
      font-style: normal;
      font-weight: normal;
      src: local('Cambria'), url('https://themes.googleusercontent.com/font?kit=FuCXqyJXTEEvujaBqOffUw') format('woff');
    }
  }
</style>
<link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><i class="nav-icon fas fa-file-alt"></i> Dokumen</h1>
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
            <table id="tabelDokumen" class="table table-sm table-bordered  table-hover" style="cursor:pointer">
            <thead>
            <tr>
            <th>Judul Dokumen</th>
            <th>Detail Layanan / Keyword</th>
            <th>Tanggal Pembuatan</th>
            <th>Status</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
            <tr>
            <th>Judul Dokumen</th>
            <th>Detail Layanan / Keyword</th>
            <th>Tanggal Pembuatan</th>
            <th>Status</th>
            </tr>
            </tfoot>
            </table>
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

{{-- DataTable --}}

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
<script src="{{ asset('vendor/tinymce4/tinymce.min.js') }}"></script>

<script>
    $(function () {
    $('#tabelDokumen').DataTable({
      "ordering": true,
      "processing": true,
      "serverSide": true,
      "responsive": false, 
      "lengthChange": false, 
      "autoWidth": false,
      "ajax": "/dokumen",
      'createdRow': function( row, data, dataIndex ) {
          $(row).attr('id', data.uuid);
      },
      "columns": [
        {
            "mData": "judul",
            "mRender": function (data, type, row) {
              return '<i class="nav-icon fas fa-file-alt"></i> '+row.judul;
            }
        },
        {"data": "keyword"},
        {"data": "created_at"},
        {
            "mData": "status",
            "mRender": function (data, type, row) {
              if (row.status != null) {
                return '<span class="badge bg-warning">Tertaut</span>';
              }else {
                return '';
              }
            }
        }
      ],
      "pageLength": 25,
      "lengthMenu": [
          [10, 25, 50, 100, -1],
          ['10 rows', '25 rows', '50 rows', '100 rows','All'],
      ],
      "order": [[2, 'desc']],
      "dom": 'Blfrtip', // Blfrtip or Bfrtip
      "buttons": ["pageLength", "copy", "csv", "excel", "pdf", "print", 
              {
                className: "btn-success",
                text: 'Template',
                  action: function ( ) {
                    window.location.assign('{{ route("template") }}')
                  }
              },
              {
                className: "btn-info",
                text: 'Buat Dokumen',
                  action: function ( ) {
                    window.location.assign('{{ route("dokumen.add") }}')
                  }
              }]
      }).buttons().container().appendTo('#tabelDokumen_wrapper .col-md-6:eq(0)');

      $('#tabelDokumen_filter').css({'float':'right','display':'inline-block; background-color:black'});
    });

    $('#tabelDokumen tbody').on('click', 'tr', function () {
      $.get(`/dokumen/show/`+this.id, function (data) {
          $("#overlay").hide();
          console.log(data);
          tinymce.activeEditor.setContent(JSON.parse(data.konten));
          $('#dokumenModal').modal('show');
          //munculkan tombol
          $('#buttonsDokumen').html('');
          $('#buttonsDokumen').append('<button type="button" class="btn btn-primary btn-block" id="detail" onclick="saveAndPrint()"><i class="fas fa-print"></i> Print Dokumen</button>');
          // $('#buttons').append('<button type="button" onclick="window.location.assign(`'+"{{route('dokumen.edit', '')}}"+"/"+data.uuid+'`)" class="btn btn-warning btn-block" id="terima"><i class="fas fa-edit"></i> Edit Dokumen</button>');
          $('#buttonsDokumen').append('<button type="button" onclick="hapus(`'+data.uuid+'`)" class="btn btn-danger btn-block" id="hapus"><i class="fa fa-trash"></i> Hapus Dokumen</button>');
        });
    });

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

    function hapus(uuid) {
      if (confirm("Apakah anda yakin ingin menghapus dokumen ini?\nDokumen yang terhapus tidak akan muncul di daftar dokumen dan di agenda") == true) {
        let token   = $("meta[name='csrf-token']").attr("content");
        $.ajax({
        url: `/dokumen/destroy/`+uuid,
        type: "DELETE",
        cache: false,
        data: {
            _token: token
        },
        success: function (response){
            if (response.success != true) {
                console.log(response);
            }else{
                $('#tabelDokumen').DataTable().ajax.reload();
                $('#dokumenModal').modal('hide');
            }
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
    }
  </script>
{{-- 
// alert('redirect ke : '+this.id);
// window.location.assign('{{ route("kasus.detail") }}') --}}


@endsection