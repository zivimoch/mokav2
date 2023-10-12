@extends('layouts.template')

@section('content')
<style type="text/css">
  #wzform fieldset:not(:first-of-type) {
    display: none
  }

  @media screen {
    @font-face {
      font-family: 'Cambria::Menu';
      font-style: normal;
      font-weight: normal;
      src: local('Cambria'), url('https://themes.googleusercontent.com/font?kit=FuCXqyJXTEEvujaBqOffUw') format('woff');
    }
  }
</style>
<link rel="stylesheet" type="text/css" href="{{ asset('source/css/ckeditor.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0"><i class="far fa-copy"></i> Buat Template</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Template</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>

  <div class="col-md-12">
    <!-- general form elements -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Buat Template Dokumen > <span class='titleFormOutput' id='titleFormOutput'></span></h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
          </button>
        </div>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form method="POST" action="{{ route('template.store') }}" role="form" id="wzform">
      @csrf
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('response') }}. <a href="{{ route('template') }}">Lihat data</a>
        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <b>GAGAL ! </b>
            <br>
            {{ session('response') }}
        </div>
        @endif
        <div class="card-body">
          <fieldset>
            <div class="form-card">
              <div class="form-group">
                <label>Nama Template</label>
                <input type="text" name="nama_template" class="form-control" id="titleForm" value="">
              </div>
            </div>
            <div class="form-card">
              <label>Kepemilikan Template</label>
              <select name="pemilik" class="form-control select2bs4" id="pemilik" style="width:100%" required>
                  <option value="" selected></option>
                  @foreach ($jabatan as $item)
                      <option value="{{ $item }}" >{{ $item }}</option>
                  @endforeach
              </select>
            </div>
            <br>
            <div class="form-card">
              <div class="form-group">
                <label>Keyword / Detail Layanan (contoh : Koordinasi Internal, Pemeriksaan Psikologi, Konsultasi Hukum dll)</label>
                <select name="keyword[]" class="form-control select-tag titlecase" id="keyword" style="width:100%" multiple="multiple" required>
                    @foreach ($keyword as $item)
                        <option value="{{ $item->keyword }}" >{{ $item->keyword }}</option>
                    @endforeach
                </select>
              </div>
            </div>
            <input type="button" name="next" class="next action-button btn btn-primary" value="Selanjutnya" id="next1" />
          </fieldset>
          <fieldset>
            <div class="form-card">
              <div class="form-group">
  
                <body data-editor="DecoupledDocumentEditor" data-collaboration="false">
                  <div id="mytoolbar" style="width: 1000px"></div>
                  <main>
                    <div class="centered">
                      <input type="text" name="blank_template" id="blank_template_hidden" value="0" hidden>
                      <input type="checkbox" class="btn-sm" 
                      checked 
                      data-bootstrap-switch 
                      id="blank_template"
                      data-on-text="Formatted"
                      data-off-text="Blank"
                      data-off-color="warning" 
                      data-on-color="success">
                      <div class="row-editor">
                        <textarea id="post_content" name="konten" class="form-control editor"></textarea>
                      </div>
                    </div>
                  </main>
                </body>
              </div>
            </div>
            <input type="button" name="previous" class="previous action-button-previous btn btn-primary" value="Kembali" />
            <input type="submit" class="btn btn-success" id="submit" value="Simpan" />
          </fieldset>
        </div>
        <!-- /.card-body -->
      </form>
    </div>
    <!-- /.card -->
  </div>
<script src="{{ asset('source/js/wizard.js') }}"></script>
<script src="{{ asset('source/js/main.js') }}"></script>
<script src="{{ asset('adminlte') }}/plugins/select2/js/select2.full.min.js"></script>
<script src="{{ asset('vendor/tinymce4/tinymce.min.js') }}"></script>
<script src="{{ asset('adminlte') }}/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script>
  $('#blank_template').on('switchChange.bootstrapSwitch', function(event, state) {
      if (state) {
          $('.row-editor').show();
          $('#blank_template_hidden').val(0);
      } else {
          $('.row-editor').hide();
          $('#blank_template_hidden').val(1);
      }
  });
  
  $("input[data-bootstrap-switch]").each(function(){
    $(this).bootstrapSwitch('state', $(this).prop('checked'));
  })

  //Initialize Select2 Elements
  $('.select2bs4').select2({
      theme: 'bootstrap4'
      });
  $('.select-tag').select2({
    tags: true,
    theme: 'bootstrap4'
  });  

  // $.widget.bridge('uibutton', $.ui.button);

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
  content_style: "body { font-family: Cambria; }",
  selector: "#post_content",
  toolbar: '#mytoolbar',
  lineheight_formats: "8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 20pt 22pt 24pt 26pt 36pt",
  // ukuran A4 Potrait
  width: "742",
  height: "842",
  plugins: 'textcolor table paste',
  font_formats: "Cambria=cambria;Calibri=calibri;Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Oswald=oswald; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats",
  plugins: [
    "advlist autolink lists link image charmap print preview hr anchor pagebreak",
    "searchreplace wordcount visualblocks visualchars code fullscreen",
    "insertdatetime nonbreaking save table contextmenu directionality",
    "emoticons template paste textcolor colorpicker textpattern"
  ],
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
    },
    {
      title: 'Table row 1',
      selector: 'tr',
      classes: 'tablerow1'
    }
  ],
  
  toolbar: "insertfile undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image responsivefilemanager | formatselect | strikethrough | forecolor backcolor fontselect  fontsizeselect | pastetext |",
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
  
  function loadJavascript(url) {
  var script = document.createElement("script");
  script.src = url;
  document.head.appendChild(script);
  }
  loadJavascript("https://code.jquery.com/jquery-3.5.1.min.js");
  </script>
@endsection