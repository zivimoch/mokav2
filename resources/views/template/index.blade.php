@extends('layouts.template')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><i class="far fa-copy"></i> Template</h1>
          </div><!-- /.col -->
<<<<<<< HEAD
          <div class="col-sm-6 text-right">
            <input type="checkbox" class="btn-xs" id="kontainerwidth"
                  checked
                  data-bootstrap-switch 
                  data-on-text="Normal"
                  data-off-text="Fullwidth"
                  data-off-color="default" 
                  data-on-color="default">
          </div>
=======
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
>>>>>>> a5b8b868dc63aecbff731d58b225d84c5f17745f
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
<<<<<<< HEAD
            <table id="tableTemplate" class="table table-sm table-bordered  table-hover" style="cursor:pointer">
            <thead>
            <tr>
            <th>Nama Template</th>
            <th>Blank</th>
            <th>Pemilik</th>
            <th>Terakhir Dirubah</th>
=======
            <table id="example1" class="table table-sm table-bordered  table-hover" style="cursor:pointer">
            <thead>
            <tr>
            <th>Nama Template</th>
            <th>Pemilik</th>
            <th>Created By</th>
>>>>>>> a5b8b868dc63aecbff731d58b225d84c5f17745f
            <th>Created At</th>
            <th>Modified At</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
            <tr>
            <th>Nama Template</th>
<<<<<<< HEAD
            <th>Blank</th>
            <th>Pemilik</th>
            <th>Terakhir Dirubah</th>
=======
            <th>Pemilik</th>
            <th>Created By</th>
>>>>>>> a5b8b868dc63aecbff731d58b225d84c5f17745f
            <th>Created At</th>
            <th>Modified At</th>
            </tr>
            </tfoot>
            </table>
            </div>
            
            </div>
      </div><!-- /.container-fluid -->
    </section>

<<<<<<< HEAD
<!-- Modal Template -->
<div class="modal fade" id="TemplateModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
=======
<!-- Modal -->
<div class="modal fade" id="ajaxModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
>>>>>>> a5b8b868dc63aecbff731d58b225d84c5f17745f
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
<<<<<<< HEAD
      <div class="modal-body">
        <div class="form-card">
          <div class="form-group">

            <body data-editor="DecoupledDocumentEditor" data-collaboration="false">
              <div id="mytoolbar" style="width: 1000px"></div>
              <main>
                <label>Detail Template</label>
                  <div class="col-md-12" style="background-color:aliceblue; padding:10px">
                      <table>
                          <tr>
                              <td>
                                  Nama Template
                              </td>
                              <td>
                                  : <span id="nama_template"></span>
                              </td>
                          </tr>
                          <tr>
                              <td>
                                  Detail Layanan / Keyword
                              </td>
                              <td>
                                  : <span id="keyword"></span>
                              </td>
                          </tr>
                          <tr>
                              <td>
                                  Kepemilikan Template
                              </td>
                              <td>
                                  : <span id="kepemilikan"></span>
                              </td>
                          </tr>
                          <tr>
                              <td>
                                  Terakhir Dirubah Oleh
                              </td>
                              <td>
                                  : <span id="created_by"></span>
                              </td>
                          </tr>
                          <tr>
                              <td>
                                  Created at
                              </td>
                              <td>
                                  : <span id="created_at"></span>
                              </td>
                          </tr>
                          <tr>
                              <td>
                                  Modified at
                              </td>
                              <td>
                                  : <span id="modified_at"></span>
                              </td>
                          </tr>
                      </table> 
                  </div>
              </main>
            </body>
          </div>
        </div>
        <div id="konten"></div> 
      </div>
      <div class="modal-footer" id="buttonsTemplate">
=======
      <div class="alert alert-danger alert-dismissible invalid-feedback" id="error-message">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
        <span id="message"></span>
      </div>
      <div class="alert alert-success alert-dismissible invalid-feedback" id="success-message">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Success!</h4>
        Data berhasil disimpan.
      </div>
      <div class="modal-body">
        <div class="box-profile">
          <div class="text-center">
          <img class="profile-user-img img-fluid img-circle" src="http://127.0.0.1:8000/adminlte/dist/img/default-150x150.png" alt="User profile picture">
          </div>
          <h3 class="profile-username text-center" id="nama"></h3>
          <p class="text-muted text-center">(<span id="usia"></span>) <span id="jenis_kelamin"></span></p>
          <p class="text-center" id="no_klien"></p>
          <ul class="list-group list-group-unbordered mb-3">
          <h5><span class="float-right badge bg-danger btn-block" id="status"></span></h5>
          <li class="list-group-item">
          <b>Layanan</b> <a class="float-right">5</a>
          </li>
          <li class="list-group-item">
          <b>Intervensi</b> <a class="float-right">10</a>
          </li>
          <li class="list-group-item">
          <b>Petugas</b> <a class="float-right">6</a>
          </li>
          </ul>
        </div>
      </div>
      <div class="modal-footer" id="buttons">
>>>>>>> a5b8b868dc63aecbff731d58b225d84c5f17745f
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

<script>
    $(function () {
<<<<<<< HEAD
    $('#tableTemplate').DataTable({
=======
    $('#example1').DataTable({
>>>>>>> a5b8b868dc63aecbff731d58b225d84c5f17745f
      "ordering": true,
      "processing": true,
      "serverSide": true,
      "responsive": false, 
      "lengthChange": false, 
      "autoWidth": false,
<<<<<<< HEAD
      "ajax": "{{ env('APP_URL') }}/template",
=======
      "ajax": "/template",
>>>>>>> a5b8b868dc63aecbff731d58b225d84c5f17745f
      'createdRow': function( row, data, dataIndex ) {
          $(row).attr('id', data.uuid);
      },
      "columns": [
        {
            "mData": "nama_template",
            "mRender": function (data, type, row) {
              return '<i class="far fa-copy"></i> '+row.nama_template;
            }
        },
<<<<<<< HEAD
        {
            "mData": "blank_template",
            "mRender": function (data, type, row) {
              if (row.blank_template) {
                blank = "Ya";
              }else{
                blank = "Tidak";
              }
              return blank;
            }
        },
=======
>>>>>>> a5b8b868dc63aecbff731d58b225d84c5f17745f
        {"data": "pemilik"},
        {"data": "petugas"},
        {"data": "created_at"},
        {"data": "updated_at"},
      ],
      "pageLength": 25,
      "lengthMenu": [
          [10, 25, 50, 100, -1],
          ['10 rows', '25 rows', '50 rows', '100 rows','All'],
      ],
      "dom": 'Blfrtip', // Blfrtip or Bfrtip
      "buttons": ["pageLength", "copy", "csv", "excel", "pdf", "print",
              {
                className: "btn-info",
                text: 'Buat Template',
                  action: function ( ) {
                    window.location.assign('{{ route("template.create") }}')
                  }
              }]
<<<<<<< HEAD
      }).buttons().container().appendTo('#tableTemplate_wrapper .col-md-6:eq(0)');

      $('#tableTemplate_filter').css({'float':'right','display':'inline-block; background-color:black'});
    });

    $('#tableTemplate tbody').on('click', 'tr', function () {
      $("#success-message").hide();
      $("#error-message").hide();
      
      $.get(`{{ env('APP_URL') }}/template/show/`+this.id, function (data) {
          item = data.data;
          if (item.blank_template) {
            $('#konten').html('Template ini blank tidak ada formatnya.');
          }else{
            $('#konten').html(JSON.parse(item.konten));
          }
          $('#nama_template').html(item.nama_template);
          $('#kepemilikan').html(item.pemilik);
          $('#created_by').html(item.name);
          $('#created_at').html(item.created_at);
          $('#modified_at').html(item.updated_at);
          $("#overlay").hide();
          $('#TemplateModal').modal('show');

          $('#keyword').html('');
          keyword = data.keyword;
          $.each(keyword, function(index, valuekeyword) {
            $('#keyword').append(valuekeyword+', ');
          });
          //munculkan tombol
          $('#buttonsTemplate').html('');
          $('#buttonsTemplate').append('<button type="button" onclick="window.location.assign(`'+"{{route('template.edit', '')}}"+"/"+item.uuid+'`)" class="btn btn-warning btn-block" id="Edit"><i class="fas fa-edit"></i> Edit Template</button>');
          $('#buttonsTemplate').append('<button type="button" class="btn btn-danger btn-block" id="hapus" onclick="hapus(`'+item.uuid+'`)"><i class="fa fa-trash"></i> Hapus Template</button>');
        });
    });

    function hapus(uuid) {
      if (confirm("Apakah anda yakin ingin menghapus Template ini?\Template yang dihapus tidak mempengaruhi dokumen yang sudah menggunakan template ini.") == true) {
        let token   = $("meta[name='csrf-token']").attr("content");
        $.ajax({
        url: `{{ env('APP_URL') }}/template/destroy/`+uuid,
        type: "POST",
        cache: false,
        data: {
            _method:'DELETE',
            _token: token
        },
        success: function (response){
            if (response.success != true) {
                console.log(response);
            }else{
                $('#tableTemplate').DataTable().ajax.reload();
                $('#TemplateModal').modal('hide');
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

=======
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

      $('#example1_filter').css({'float':'right','display':'inline-block; background-color:black'});
    });

    $('#example1 tbody').on('click', 'tr', function () {
      $("#success-message").hide();
      $("#error-message").hide();
      
      $.get(`/kasus/show/`+this.id, function (data) {
          dob = new Date(data.tanggal_lahir);
          var today = new Date();
          var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));

          $("#overlay").hide();
          $('#nama').html(data.nama);
          $('#usia').html(age);
          $('#jenis_kelamin').html(data.jenis_kelamin);
          $('#no_klien').html(data.no_klien);
          $('#status').html(data.status);
          $('#ajaxModal').modal('show');
          //munculkan tombol
          $('#buttons').html('');
          $('#buttons').append('<button type="button" class="btn btn-primary btn-block" id="detail" onclick="window.location.assign(`'+"{{route('kasus.show', '')}}"+"/"+data.uuid+'`)"><i class="fa fa-info-circle"></i> Detail Kasus</button>');
          $('#buttons').append('<button type="button" class="btn btn-success btn-block" id="terima"><i class="fa fa-check"></i> Terima Kasus</button>');
          $('#buttons').append('<button type="button" class="btn btn-danger btn-block" id="hapus"><i class="fa fa-trash"></i> Hapus Kasus</button>');
        });
    });

>>>>>>> a5b8b868dc63aecbff731d58b225d84c5f17745f
  </script>
{{-- 
// alert('redirect ke : '+this.id);
// window.location.assign('{{ route("kasus.detail") }}') --}}
@endsection