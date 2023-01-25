@extends('layouts.template')

@section('content')
    {{-- DataTable --}}
     <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Laporan Kinerja</h1>
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
                <table class="datatable-multi-row table table-sm table-bordered  table-hover" id="example1" >
                    <thead>
                      <tr>
                        <th style="width: 23%">Hari / Tanggal</th>
                        <th style="width: 15%">Waktu</th>
                        <th style="width: 61%">Aktivitas</th>
                        <th style="width: 1%">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr id="1">
                        <td data-datatable-multi-row-rowspan="2">
                          Senin, 02 Januari 2023
                          <td>
                              08:00 - 09:00
                          </td>
                          <td>
                              <b>Pelatihan penanganan korban TPPO</b><br>
                              Lorem ipsum, dolor sit amet consectetur adipisicing elit. Maxime, illo voluptatibus et, aperiam in omnis ullam vel, fugiat laboriosam corrupti ratione ipsam. Nobis commodi, ad repudiandae nisi praesentium sed rerum?
                          </td>
                          <td>
                              <span class="badge bg-success">Virified</span>
                          </td>
                          <script type="x/template" class="extra-row-content">
                            <tr id="2">
                              <td>
                                09:00 - 12:00
                              </td>
                              <td>
                              <b>Pelatihan penanganan korban TPPO</b><br>
                              Lorem ipsum, dolor sit amet consectetur adipisicing elit. Maxime, illo voluptatibus et, aperiam in omnis ullam vel, fugiat laboriosam corrupti ratione ipsam. Nobis commodi, ad repudiandae nisi praesentium sed rerum?
                              <br>
                              Tindak Lanjut : <br>
                              Lorem ipsum, dolor sit amet consectetur adipisicing elit. Maxime, illo voluptatibus et, aperiam in omnis ullam vel.
                              </td>
                              <td><span class="badge bg-success">Virified</span></td>
                            </tr>
                          </script>
                        </td>
                      </tr>
                      <tr id="3">
                        <td data-datatable-multi-row-rowspan="3">
                          Rabu, 03 Januari 2023
                          <td>
                              08:00 - 09:00
                          </td>
                          <td>
                              <b>Pelatihan penanganan korban TPPO judul panjang lagi blablabla blabla blabla</b><br>
                          </td>
                          <td>
                              <span class="badge bg-success">Virified</span>
                          </td>
                          <script type="x/template" class="extra-row-content">
                            <tr id="4">
                              <td>
                                09:00 - 12:00
                              </td>
                              <td>
                              <b>Pelatihan penanganan korban KBGO</b><br>
                              </td>
                              <td><span class="badge bg-success">Virified</span></td>
                            </tr>
                            <tr id="5">
                              <td>
                                09:00 - 12:00
                              </td>
                              <td>
                              <b>Pelatihan penanganan korban TPPO</b><br>
                              Lorem ipsum, dolor sit amet consectetur adipisicing elit. Maxime, illo voluptatibus et, aperiam in omnis ullam vel, fugiat laboriosam corrupti ratione ipsam. Nobis commodi, ad repudiandae nisi praesentium sed rerum?
                              </td>
                              <td><span class="badge bg-success">Virified</span></td>
                            </tr>
                          </script>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <div class="row">
                    <br>
                    <br>
                    <br>
                    <div class="col-md-12 text-center">
                        Jakarta, 31 Januari 2023</br>
                        Yang Membuat,</br>
                        <br>
                        <br>
                        <br>
                        <br>
                        Addzifi Mochamad Gumelar
                    </div>
                </div>
            </div>
            
            </div>
      </div><!-- /.container-fluid -->
    </section>

<!-- Modal -->
<div class="modal fade" id="modalCreate" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Buat Agenda</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <input type="text" name="" id="start" hidden>
            <input type="text" name="" id="end" hidden>
        <div class="form-group">
            <label>Judul kegiatan</label>
            <input type="text" class="form-control" id="title">
        </div>
        <div class="form-group">
            <label>Jam mulai</label>
            <input type="time" class="form-control" id="jam">
        </div>
        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="" class="form-control" id="" cols="30" rows="2"></textarea>
        </div>
        <div class="form-group">
            <label>Penjadwalan Layanan</label>
            <select name="" class="form-control" id="penadjawalan_layanan">
              <option value="0">Tidak</option>
              <option value="1">Ya</option>
            </select>
        </div>
        <div class="form-group" id="klien_id">
          <label>Pilih Klien</label>
          <select class="form-control select2" style="width: 100%;">
            <option>pilih data</option>
            <option>Tini</option>
            <option>Tina</option>
            <option>Toni</option>
            <option>Tono</option>
            <option>Tino</option>
            <option>Tanos</option>
          </select>
        </div>
        <div class="form-group">
          <label>Tag</label>
          <select class="select2" multiple="multiple" data-placeholder="Pilih nama" style="width: 100%;">
          <option>Addzifi Mochamad Gumelar</option>
          <option>Alexander Grahambell</option>
          <option>Thomas Alfa Edison</option>
          <option>Tony Stark</option>
          </select>
        </div>
            <div class="col-12" id="accordion" style="padding:0px !important">
                <div class="card card-primary card-outline">
                <a class="d-block w-100" data-toggle="collapse" href="#collapseOne">
                <div class="card-header">
                <h4 class="card-title w-100">
                Tindak Lanjut
                </h4>
                </div>
                </a>
                <div id="collapseOne" class="collapse show" data-parent="#accordion">
                <div class="alert alert-warning alert-dismissible">
                <i class="icon fas fa-exclamation-triangle"></i> data tindak lanjut hanya tercatat pada akun anda
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Jam selesai</label>
                        <input type="time" class="form-control" id="jam">
                    </div>
                    <div class="form-group">
                        <label>Catatan</label>
                        <textarea name="" class="form-control" id="" cols="30" rows="2"></textarea>
                    </div>
                    <div class="form-group">
                    <label>Dokumen pendukung <span style="font-size: 12px">(lihat dokumen tersedia <a href="{{ route('dokumen') }}">disini</a>)</span></label>
                    <select class="select2" multiple="multiple" data-placeholder="Pilih nama" style="width: 100%;">
                    <option>Dokumen konsultasi hukum kasus Eliza Thornberry</option>
                    <option>Dokumen Pendampingan pengadilan kasus eliza thornberry</option>
                    <option>Pendampingan pengadilan kasus tom delounge</option>
                    <option>Mediasi kasus tom delounge</option>
                    </select>
                    </div>
                </div>
                </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-block" id="submit">Simpan</button>
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

<script src="{{ asset('adminlte') }}/plugins/select2/js/select2.full.min.js"></script>

<script>

  $(function () {
    $("#klien_id").hide();
    $('#penadjawalan_layanan').change(function () {
      if ($('#penadjawalan_layanan').val() == 0) {
        $("#klien_id").hide();
      } else {
        $("#klien_id").show();
      }
    })
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
    });
    $('#example1').DataTable({
        "ordering": false,
        "responsive": false, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", 
              {
                className: "btn-success",
                text: 'Tambah',
                  action: function ( ) {
                    $('#modalCreate').modal('show'); 
                  }
              },
              {
                className: "btn-info",
                text: 'Lihat agenda',
                  action: function ( ) {
                    window.location.assign('{{ route("agenda") }}')
                  }
              }],
        "fnDrawCallback": function() {

            $table = $(this);

            // only apply this to specific tables
            if ($table.closest(".datatable-multi-row").length) {

            // for each row in the table body...
            $table.find("tbody>tr").each(function() {
                var $tr = $(this);

                // get the "extra row" content from the <script> tag.
                // note, this could be any DOM object in the row.
                var extra_row = $tr.find(".extra-row-content").html();

                // in case draw() fires multiple times, 
                // we only want to add new rows once.
                if (!$tr.next().hasClass('dt-added')) {
                $tr.after(extra_row);
                $tr.find("td").each(function() {

                    // for each cell in the top row,
                    // set the "rowspan" according to the data value.
                    var $td = $(this);
                    var rowspan = parseInt($td.data("datatable-multi-row-rowspan"), 10);
                    if (rowspan) {
                    $td.attr('rowspan', rowspan);
                    }
                });
                }

            });

            } // end if the table has the proper class
        }
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    $('#example1 tbody').on( 'click', 'tr', function () {
        alert('redirect ke : '+this.id);
        window.location.assign('{{ route("kasus.detail") }}')
    } );
</script>
@endsection