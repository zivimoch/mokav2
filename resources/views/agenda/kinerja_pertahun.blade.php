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
            <h1 class="m-0"><i class="fas fa-layer-group"></i> Rekap Laporan Kinerja</h1>
          </div><!-- /.col -->
          <div class="col-sm-6 text-right">
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
              <div class="card-body" style="overflow-x: scroll">
                <form action="{{ route('kinerja') }}" method="GET">
                    <div class="input-group">
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
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Tampilkan</button>
                        </div>
                    </div>
                </form>

            <input type="hidden" id="uuid_agenda_hightlight">
            <table id="tabelAgenda" class="table table-sm table-bordered  table-hover" style="cursor:pointer">
        
                <thead>
                  <tr>
                      <th>No</th>
                      <th>Bulan</th>
                      <th>Nama Petugas</th>
                      <th>Jumlah Hari</th>
                      <th>Sudah diTL</th>
                      <th>Belum diTL</th>
                      <th>Total Agenda</th>
                      <th>Sudah diTL (%)</th>
                  </tr>
                  </thead>
                  <tbody></tbody>
              </table>
              <b>Keterangan : </b><br>
              <table>
                <tr>
                  <td>
                    <div style="background-color:rgb(255, 205, 205); width: 100px; height: 20px; display: inline-block; vertical-align: middle;"></div>
                  </td>
                  <td>
                    Warna merah artinya ada agenda yang belum terisi laporan tindak lanjutnya.
                  </td>
                </tr>
              </table> 
            </div>
      </div><!-- /.container-fluid -->
    </section>
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
    
    $('#tabelAgenda').DataTable({
      "ordering": false,
      "processing": true,
      "serverSide": true,
      "responsive": false, 
      "lengthChange": false, 
      "autoWidth": false,
      "ajax": "{{ env('APP_URL') }}/kinerja/ajax2?tahun={{ request()->get('tahun') }}&bulan={{ request()->get('bulan') }}&user_id={{ request()->get('user_id') }}",
      'createdRow': function( row, data, dataIndex ) {
          $(row).attr('id', data.id);
          rowHightlight = $('#uuid_agenda_hightlight').val();
          if (data.id == rowHightlight) {
            $(row).attr('class', 'hightlighting');
          }
          if (data.persen < 100) {
            $(row).attr('class', 'warning_table');
          }
      },
      "columns": [
        {
          "data": "id",
          "mRender": function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        { 
            "data": "bulan",
            "render": function (data, type, row) {
                const months = [
                    "Januari", "Februari", "Maret", "April", 
                    "Mei", "Juni", "Juli", "Agustus", 
                    "September", "Oktober", "November", "Desember"
                ];
                const monthIndex = parseInt(data, 10) - 1; // Convert to zero-based index
                return months[monthIndex] || "Invalid Month";
            }
        },
        {"data": "name"},
        {"data": "jumlah_hari"},
        {"data": "sudah_ditl"},
        {"data": "belum_ditl"},
        {"data": "total"},
        {
          "data": "persen",
          "mRender": function (data, type, row) {
            progress = '<div class="progress progress-xs"><div class="progress-bar bg-success progress-bar-striped" style="width:'+row.persen+'%" id="persen_data'+row.id+'" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div></div>'
            if (row.persen == null) {
              persen = 0;
            } else {
              persen = row.persen;
            }
            return persen+'<br>'+progress;
          }
        },
      ],
      "columnDefs": [
        { className: "cursor-disabled", "targets": [ 6 ] }
      ],
      "pageLength": 200,
      "lengthMenu": [
          [10, 25, 50, 100, -1],
          ['10 rows', '25 rows', '50 rows', '100 rows','All'],
      ],
      "dom": 'Blfrtip', // Blfrtip or Bfrtip
      "buttons": ["pageLength", "copy", {
                    extend: 'excel',
                    title:
                        "Data Monitoring Laporan Kinerja Bulan {{ request()->get('bulan') }} Tahun {{ request()->get('tahun') }}"
                }, {
                    extend: 'pdf',
                    title:
                        "Data Monitoring Laporan Kinerja Bulan {{ request()->get('bulan') }} Tahun {{ request()->get('tahun') }}"
                }]
      }).buttons().container().appendTo('#tabelAgenda_wrapper .col-md-6:eq(0)');


       $('#tabelAgenda tbody').on( 'click', 'tr', function (evt) {
            if (($(evt.target).closest('td').index() !== 6)) {
                var table = $('#tabelAgenda').DataTable();
                var rowData = table.row(this).data();

                redirectUrl = "{{ route('kinerja.detail') }}?tahun={{ request()->tahun }}&bulan="+rowData.bulan+"&user_id="+rowData.uuid;
                window.location.href = redirectUrl;
          }
        });
    $('#tabelAgenda_filter').css({'float':'right','display':'inline-block'});
</script>
{{-- include modal agenda --}}
@include('agenda.modal')
@endsection