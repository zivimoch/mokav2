<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>jQuery formToWizard Plugin Example</title>
    <!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap CSS CDN -->
<link
  rel="stylesheet"
  href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
/>

<!-- Bootstrap JS CDN (popper.js is required for dropdowns and tooltips) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    
    <style>
        .tab-pane {
            padding: 10px;
        }
        .wrap { max-width: 980px; margin: 10px auto 0; }
        #steps { margin: 80px 0 0 0 }
        .commands { overflow: hidden; margin-top: 30px; }
        .prev {float:left}
        .next, .submit {float:right}
        .error { color: #b33; }
        #progress { position: relative; height: 5px; background-color: #eee; margin-bottom: 20px; }
        #progress-complete { border: 0; position: absolute; height: 5px; min-width: 10px; background-color: #337ab7; transition: width .2s ease-in-out; }

        .add-tab {
            position: relative;
        }

        .add-tab a {
            position: absolute;
            right: 0;
            top: -2px;
            background-color: #eee;
            padding: 5px 10px;
            border-radius: 4px;
        }
    </style>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js"></script>
    <script src="{{ asset('source/js//formtowizard.js') }}"></script>
    <script src="{{ asset('adminlte') }}/plugins/select2/js/select2.full.min.js"></script>
    
    <script>
        $( function() {
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });

            var $signupForm = $( '#SignupForm' );
            
            $signupForm.validate({errorElement: 'em'});
            
            $signupForm.formToWizard({
                submitButton: 'SaveAccount',
                nextBtnClass: 'btn btn-primary next',
                prevBtnClass: 'btn btn-default prev',
                buttonTag:    'button',
                validateBeforeNext: function(form, step) {
                    var stepIsValid = true;
                    var validator = form.validate();
                    $(':input', step).each( function(index) {
                        var xy = validator.element(this);
                        stepIsValid = stepIsValid && (typeof xy == 'undefined' || xy);
                    });
                    return stepIsValid;
                },
                progress: function (i, count) {
                    $('#progress-complete').width(''+(i/count*100)+'%');
                }
            });
        });
    </script>
    
</head>

<body>
<h1 style="margin:150px auto 30px auto;" class="text-center">LAPOR KEKERASAN</h1>
<div class="row wrap"><div class="col-lg-12">

    <div id='progress'><div id='progress-complete'></div></div>

    <form id="SignupForm" action="">
        <fieldset>
            <legend>A. Identitas Pelapor</legend>
            <div class="form-group">
            <label for="Name">Name Lengkap</label>
            <input id="nama_pelapor" type="text" class="form-control" required value="dsd"/>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                    <label for="Name">Tempat Lahir</label>
                    <input id="tempat_lahir_pelapor" type="text" class="form-control" required value="dasdsa"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    <label for="Name">Tanggal Lahir</label>
                    <input id="tanggal_lahir_pelapor" type="date" class="form-control" required value="2020-01-01"/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <label for="Email">Provinsi Domisili</label>
                        <select id="provinsi_id_pelapor" class="form-control select2bs4" required>
                            <option value="-" selected>-</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="Email">Kota Domisili</label>
                            <select id="kota_id_pelapor" class="form-control select2bs4" required>
                                <option value="-" selected>-</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="Email">Kecamatan</label>
                            <select id="kecamatan_id_pelapor" class="form-control select2bs4">
                                <option value="-" selected>-</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="Email">Kelurahan</label>
                            <select id="kelurahan_id" class="form-control select2bs4">
                                <option value="-" selected>-</option>
                            </select>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="form-group">
                <label for="Email">Alamat Domisili</label>
                <textarea class="form-control" id="alamat_pelapor" required>dads</textarea>
                </div>
                <div class="form-group">
                    <label>No Telp</label>
                    <input id="no_telp_pelapor" type="number" class="form-control" required value="089" />
                </div>
        </fieldset>

        <fieldset>
            <legend>B. Identitas Klien</legend>
            
            <ul class="nav nav-tabs" id="myTab">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#home">Nama Klien</a>
                </li>
              
                <li class="nav-item add-tab-item add-tab">
                  <button id="add-tab" class="btn btn-primary" style="margin-bottom: -16px">
                    Tambah Klien
                  </button>
                </li>
              </ul>
              <div class="tab-content">
                <div id="home" class="tab-pane fade show active">
                    <div class="row">
                        <div class="col-sm-6">
                          <div class="card">
                            <div class="card-body">
                              <h5 class="card-title">Special title treatment</h5>
                              <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                              <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="card">
                            <div class="card-body">
                              <h5 class="card-title">Special title treatment</h5>
                              <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                              <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
              </div>
              
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input id="nama_klien" type="text" class="form-control" required />
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                    <label for="Name">Tempat Lahir</label>
                    <input id="tempat_lahir_klien" type="text" class="form-control" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    <label for="Name">Tanggal Lahir</label>
                    <input id="tanggal_lahir_klien" type="date" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="form-group">
            <label for="Email">Alamat Domisili</label>
            <textarea class="form-control" id="alamat_klien" required></textarea>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <label>Provinsi</label>
                        <select id="provinsi_id_klien" class="form-control select2bs4" required>
                          <option value="-" selected>-</option>
                        </select>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <label>Kota</label>
                            <select id="kota_id_klien" class="form-control select2bs4" required>
                              <option value="-" selected>-</option>
                            </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Kecamatan</label>
                                <select id="kecamatan_id_klien" class="form-control select2bs4">
                                    <option value="-" selected>-</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <label>Kelurahan</label>
                            <select id="kelurahan_klien" class="form-control select2bs4">
                              <option value="-" selected>-</option>
                            </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>No Telp</label>
                    <input id="no_telp_klien" type="number" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Status Pendidikan</label>
                    <select id="status_pendidikan_klien" class="form-control select2bs4" required>
                      <option value="-" selected>-</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Pendidikan terakhir</label>
                    <select id="pendidikan_klien" class="form-control select2bs4" required>
                      <option value="-" selected>-</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Agama</label>
                    <select id="agama_klien" class="form-control select2bs4">
                      <option value="-" selected>-</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Suku</label>
                    <select id="suku_klien" class="form-control select2bs4">
                      <option value="-" selected>-</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Pekerjaan</label>
                    <select id="pekerjaan_klien" class="form-control select2bs4">
                      <option value="-" selected>-</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Penghasilan per Bulan</label>
                    <input id="penghasilan_klien" type="number" class="form-control" required />
                </div>
                <div class="form-group">
                    <label>Status Perkawinan</label>
                    <select id="perkawinan_klien" class="form-control select2bs4">
                      <option value="-" selected>-</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Jumlah Anak</label>
                    <input id="jumlah_anak_klien" type="number" class="form-control" required />
                </div>
                <div class="form-group">
                    <label>Hubungan Terlapor</label>
                    <select id="suku_klien" class="form-control select2bs4">
                      <option value="-" selected>-</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Kekhususan</label>
                    <select id="suku_klien" class="form-control select2bs4">
                      <option value="-" selected>-</option>
                    </select>
                </div>
        </fieldset>

        <fieldset class="form-horizontal" role="form">
            <legend>Billing information</legend>
            <div class="form-group">
            <label for="NameOnCard" class="col-sm-2 control-label">Name on Card</label>
            <div class="col-sm-10"><input id="NameOnCard" type="text" class="form-control" /></div>
            </div>
            <div class="form-group">
            <label for="CardNumber" class="col-sm-2 control-label">Card Number</label>
            <div class="col-sm-10"><input id="CardNumber" type="text" class="form-control" /></div>
            </div>
            <div class="form-group">
            <label for="CreditcardMonth" class="col-sm-2 control-label">Expiration</label>
            <div class="col-sm-10"><div class="row">
                <div class="col-xs-3">
                <select id="CreditcardMonth" class="form-control col-sm-2">
                  <option value="-" selected>-</option>
                </select>
                </div>
                <div class="col-xs-3">
                <select id="CreditcardYear" class="form-control">
                  <option value="2009">2009</option>
                </select>        
                </div>
            </div></div>
            </div>
            <div class="form-group">
            <label for="Address1" class="col-sm-2 control-label">Address 1</label>
            <div class="col-sm-10"><input id="Address1" type="text" class="form-control" /></div>
            </div>
            <div class="form-group">
            <label for="Address2" class="col-sm-2 control-label">Address 2</label>
            <div class="col-sm-10"><input id="Address2" type="text" class="form-control" /></div>
            </div>
            <div class="form-group">
            <label for="Zip" class="col-sm-2 control-label">ZIP</label>
            <div class="col-sm-4"><input id="Zip" type="text" class="form-control" /></div>
            <label for="Country" class="col-sm-2 control-label">Country</label>
            <div class="col-sm-4">
                <select id="Country" class="form-control">
			    <option value="CA">Canada</option>
            </select>
            </div>
        </fieldset>
        <p>
            <button id="SaveAccount" class="btn btn-primary submit">Submit form</button>
        </p>
    </form>

</div></div>
<script type="text/javascript">
$(document).ready(function () {
    // Add Tab Function
    $("#add-tab").click(function () {
      // Generate Unique ID for new tab
      var newTabId =
        Math.random().toString(36).substring(2, 15) +
        Math.random().toString(36).substring(2, 15);
      console.log(newTabId);

      // Add New Tab
      $("#myTab li.add-tab").before(
        '<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#' +
          newTabId +
          '">Tab ' +
          ($("#myTab li:not(.add-tab)").length + 1) +
          ' <button type="button" class="close" aria-label="Close" style="margin-left:10px; margin-right:-5px"><span aria-hidden="true">&times;</span></button></a></li>'
      );

      // Add New Tab Content
      $(".tab-content").append(
        '<div id="' +
          newTabId +
          '" class="tab-pane fade"><h3>Tab ' +
          $("#myTab li:not(.add-tab)").length +
          " " +
          newTabId +
          "</h3></div>"
      );
    });

    // Remove Tab Function
    $(document).on("click", "#myTab .close", function () {
      var tabId = $(this).parent().attr("href");
      $(this).parent().parent().remove(); // remove the tab title
      $(tabId).remove(); // remove the tab content
    });
  });

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>