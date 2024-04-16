@extends('layouts.template')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><i class="far fa-copy"></i> Template</h1>
          </div><!-- /.col -->
          <div class="col-sm-6 text-right">
            <input type="checkbox" class="btn-xs" id="kontainerwidth"
                  checked
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
            
            <div class="card-body" style="overflow-x: scroll">
            <table id="tableTemplate" class="table table-sm table-bordered  table-hover" style="cursor:pointer">
            <thead>
            <tr>
            <th>Nama Template</th>
            <th>Blank</th>
            <th>Pemilik</th>
            <th>Terakhir Dirubah</th>
            <th>Created At</th>
            <th>Modified At</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
            <tr>
            <th>Nama Template</th>
            <th>Blank</th>
            <th>Pemilik</th>
            <th>Terakhir Dirubah</th>
            <th>Created At</th>
            <th>Modified At</th>
            </tr>
            </tfoot>
            </table>
            </div>
            
            </div>
      </div><!-- /.container-fluid -->
    </section>

<!-- Modal Template -->
<div class="modal fade" id="TemplateModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    $('#tableTemplate').DataTable({
      "ordering": true,
      "processing": true,
      "serverSide": true,
      "responsive": false, 
      "lengthChange": false, 
      "autoWidth": false,
      "ajax": "{{ env('APP_URL') }}/template",
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

  </script>
{{-- 
// alert('redirect ke : '+this.id);
// window.location.assign('{{ route("kasus.detail") }}') --}}
@endsection