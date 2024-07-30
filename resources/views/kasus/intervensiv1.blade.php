<div style="overflow-x: scroll">
    <input type="hidden" id="uuid_layanan_hightlight" value="{{ Request::get('row-layanan') }}">
    <table id="tabelLayanan{{ $intervensi_ke }}" class="tabelLayanan table table-sm table-bordered  table-hover" style="cursor:pointer; color:black">
        <thead>
        <tr>
        <th>Layanan</th>
        <th></th>
        </tr>
        </thead>
        <tbody></tbody>
        <tfoot>
        <tr>
            <th>Layanan</th>
            <th></th>
        </tr>
        </tfoot>
    </table>
</div>

<script>
$(function () {
$("#tabelLayanan{{ $intervensi_ke }}").DataTable({
      "ordering": false,
      "processing": true,
      "serverSide": true,
      "responsive": false, 
      "lengthChange": false, 
      "autoWidth": false,
      "ajax": "{{ env('APP_URL') }}/agenda/api_index?uuid={{ $klien->uuid }}&jabatan="+encodeURIComponent($('#filterJabatan').val())+"&intervensi_ke={{ $intervensi_ke }}",
      'createdRow': function( row, data, dataIndex ) {
          $(row).attr('id', data.uuid);

          rowHightlight = $('#uuid_layanan_hightlight').val();
          if (data.uuid == rowHightlight) {
            $(row).attr('class', 'hightlighting');
          }
      },
      "columns": [
        {
            "mData": "judul_kegiatan",
            "mRender": function (data, type, row) {
              judul_kegiatan = deskripsi_proses = '';
              if (row.judul_kegiatan != null) {
                judul_kegiatan = '<b>'+row.judul_kegiatan+'</b>';
              }

              if (row.klien_id != null && row.klien_id != '' ) {
                  // jika agenda layanan
                  deskripsi_proses = "<b>Deskripsi Proses :</b></br>"+$("<div/>").html(row.keterangan).text();
              }else{
                // jika agenda non-layanan
                  deskripsi_proses = "<br>"+$("<div/>").html(row.keterangan).text();
              }

              if (row.jam_selesai != null) {
                  jam_mulai = row.jam_mulai+' - '+row.jam_selesai;
              }else{
                  jam_mulai =  row.jam_mulai;
              }


              deskripsi_hasil = rtl = lokasi = '';

              if (row.klien_id != null && row.klien_id != '' ) {
                // jika agenda layanan
                deskripsi_hasil = "<br><b>Deskripsi Hasil :</b><br>"+$("<div/>").html(row.catatan).text();
                rtl = "<b>Rencana Tindak Lanjut :</b><br>"+$("<div/>").html(row.rtl).text();
              }else{
                // jika agenda non-layanan
                deskripsi_hasil = "<br>"+$("<div/>").html(row.catatan).text();
              }

              if (row.lokasi) {
                lokasi = '<br><b>Lokasi :</b> <br>'+row.lokasi;
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
                dokumens += '<a href="#" onclick="showModalDokumen(`'+uuid_dokumen+'`)"><span class="badge bg-primary" style="font-size:15px"><i class="nav-icon fas fa-file-alt"></i> '+array[i].replace(/,/g, '')+'</span></a> ';
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
                return judul_kegiatan+'<br><b>Petugas : </b><br><span style="color:blue; font-weight:bold">'+row.petugas+'</span> ('+row.jabatan+')<br><b>Waktu :</b> <br>'+'<b>'+row.hari+'</b>, '+row.tanggal_mulai_formatted+", "+jam_mulai+lokasi+'<br>'+deskripsi_proses+deskripsi_hasil+'<br>'+rtl+'<br>'+dokumens+detail_layanans+'<hr style="margin:5px; border-width: 5px">';
              } else {
                return judul_kegiatan+'<br><b>Petugas : </b><br><span style="color:blue; font-weight:bold">'+row.petugas+'</span> ('+row.jabatan+')<br><b>Waktu :</b> <br>'+'<b>'+row.hari+'</b>, '+row.tanggal_mulai_formatted+", "+jam_mulai+lokasi+'<br>'+deskripsi_proses+'<br><span class="badge bg-danger">Dibatalkan</span><hr style="margin:5px; border-width: 5px">';
              }
            }
        },
        {
            "mData": "ceklis",
            "mRender": function (data, type, row) {
                if (row.jam_selesai == null) {
                    done = '';
                    checked = '';
                    disabled = '';
                    selesaiLayanan = '';
                } else {
                    done = 'done';
                    checked = 'checked';
                    disabled = '';
                    selesaiLayanan = 'layananSelesai';
                }
                if (row.created_by == {{ Auth::user()->id }}) {
                    return '<div  class="icheck-success d-inline ml-2"><input type="checkbox" value="" '+checked+'><label for="todoCheck'+row.uuid+'"></label></div>';
                    // return '<div  class="icheck-success d-inline ml-2"><input class="checkboxSelesai '+selesaiLayanan+'" type="checkbox" value="" id="todoCheck'+row.uuid+'" '+checked+' '+disabled+' onclick="showModalAgenda(`'+row.tanggal_mulai+'`,`'+row.uuid+'`,`'+row.created_by+'`)"><label for="todoCheck'+row.uuid+'"></label></div>';
                    $('#tombol_edit_agenda').show();
                } else {
                    return '<div  class="icheck-success d-inline ml-2" onclick="alert(`Anda tidak memiliki hak akses untuk menginputkan laproan tindak lanjut untuk agenda ini. Minta seseorang yang ada di agenda untuk mentag/menambahkan anda.`)"><input type="checkbox" value="" '+checked+'><label for="todoCheck'+row.uuid+'"></label></div>';
                    $('#tombol_edit_agenda').hide();
                }
            }
        }
      ],
      "pageLength": 25,
    //   "columnDefs": [
    //     { className: "cursor-disabled", "targets": [ 2 ] }
    //   ],
      "lengthMenu": [
          [10, 25, 50, 100, -1],
          ['10 rows', '25 rows', '50 rows', '100 rows','All'],
      ],
      "order": [[0, 'ASC']],
      "dom": 'Blfrtip', // Blfrtip or Bfrtip
      "buttons": ["pageLength", "copy", "excel", "pdf", 
              {
                className: "btn-info",
                text: 'Filter',
                  action: function ( ) {
                    $('#filter_intervensi').val('{{ $intervensi_ke }}');
                    $('#modalFilterLayanan').modal('show');
                  }
              }, 
              {
                className: "btn-success",
                text: 'Tambah',
                  action: function ( ) {
                    showModalAgenda("{{ date('Y-m-d') }}",0);
                  }
              }]
      }).buttons().container().appendTo('#tabelLayanan{{ $intervensi_ke }}_wrapper .col-md-6:eq(0)');

      $('#tabelLayanan{{ $intervensi_ke }}_filter').css({'float':'right','display':'inline-block; background-color:black'});

      $('#tabelLayanan{{ $intervensi_ke }} tbody').on('click', 'tr', function (evt) {
          $("#success-message").hide();
          $("#error-message").hide();
          $("#editAgenda").hide();
          $("#viewAgenda").show();
          var table = $('#tabelLayanan{{ $intervensi_ke }}').DataTable();
          var rowData = table.row(this).data();

          // if (($(evt.target).closest('td').index() !== 2)) {
              showModalAgenda('',rowData.uuid_agenda, rowData.created_by);
          // }

          if (rowData.created_by == {{ Auth::user()->id }}) {
              $('#tombol_edit_agenda').show();
          } else {
              $('#tombol_edit_agenda').hide();
          }
      });

      // sembunyikan tombol2 di tabel2 intervensi2 sebelumnya
      $('.dt-buttons').attr('id', 'akses_petugas{{ $intervensi_ke }}');
      $('#akses_petugas{{ $intervensi_ke }}').removeClass('dt-buttons');
      if ('{{ $intervensi_ke }}' != '{{ $klien->intervensi_ke }}') {
        $('#akses_petugas{{ $intervensi_ke }}').css('display', 'none');
      }
    });

    loadPemantauan();
    function loadPemantauan() {
        $('#deletePemantauan{{ $intervensi_ke }}').hide();
        $.ajax({
            url: `{{ env('APP_URL') }}/pemantauan/index?uuid={{ $klien->uuid }}&intervensi_ke={{ $intervensi_ke }}`,
            type: "GET",
            cache: false,
            success: function (response){
                data = response.data;
                i=1;

                $('#kolomPemantauan{{ $intervensi_ke }}').html('');
                data.forEach(e => {
                  var isCardOpen = (i === data.length);

                  var cardClass = isCardOpen ? 'card target' : 'card collapsed-card target';
                  var iconClass = isCardOpen ? 'fa fa-chevron-up' : 'fa fa-chevron-down';

                  $('#kolomPemantauan{{ $intervensi_ke }}').prepend(
                      '<div class=\"' + cardClass + '\"> \
                          <div class=\"card-header\" data-card-widget=\"collapse\" style=\"cursor: pointer;\"> \
                              <h3 class=\"card-title\"><b>Pemantauan & Evaluasi tanggal '+e.created_at_formatted+' oleh '+e.petugas+' ('+e.jabatan+')</b></h3> \
                              <div class=\"card-tools\"> \
                                  <button type=\"button\" class=\"btn btn-tool\"><i class=\"' + iconClass + '\"></i> </button> \
                              </div> \
                          </div> \
                          <div class=\"card-body\"> \
                              <div class=\"col-md-12\"> \
                                  <div class=\"form-group\"> \
                                      <label>Kemajuan yang Dicapai / Kondisi Klien Saat Pemantauan & Evaluasi : </label> \
                                      <textarea readonly class=\"form-control\" style=\"resize: none;\" >'+e.kemajuan+'</textarea> \
                                  </div> \
                              </div> \
                              <div class=\"col-md-12\"> \
                                  <div class=\"form-group\"> \
                                      <label>Tujuan yang Belum Tercapai : </label> \
                                      <textarea readonly class=\"form-control\" style=\"resize: none;\">'+e.tujuan+'</textarea> \
                                  </div> \
                              </div> \
                              <div class=\"col-md-12\"> \
                                  <div class=\"form-group\"> \
                                      <label>Rencana Tindak Lanjut : </label> \
                                      <textarea readonly class=\"form-control\" style=\"resize: none;\">'+e.rencana+'</textarea> \
                                  </div> \
                              </div> \
                          </div> \
                      </div>'
                  );
                    i++;
                });
            },
            error: function (response){
                console.log(response);
            }
            });
    }
</script>