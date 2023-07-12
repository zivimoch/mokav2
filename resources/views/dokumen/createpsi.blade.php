@extends('layouts.template')

@section('content')
<style type="text/css">
    .scroll-area {
        height: 800px;
        overflow-y: scroll;
    }

    .scroll-area::-webkit-scrollbar {
        width: 8px;
        background-color: #F5F5F5;
    }

    .scroll-area::-webkit-scrollbar-thumb {
        background-color: #555;
    }

    .editor {
        color: black;
    }

    #wzform fieldset:not(:first-of-type) {
        display: none
    }

    *[contenteditable="true"] {
        background-color: rgba(123, 211, 242, 0.5);
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
<link rel="stylesheet" type="text/css" href="{{ asset('source') }}/css/ckeditor.css">
<!-- daterange picker -->
<link rel="stylesheet" href="assets/adminlte/plugins/daterangepicker/daterangepicker.css">

<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
    <div class="col-sm-6">
    <h1><i class="nav-icon fas fa-file-alt"></i> Buat Dokumen</h1>
    </div>
    <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active">Detail Kasus</li>
    </ol>
    </div>
    </div>
    </div>
</section>

<div class="col-md-12">
    <!-- general form elements -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Buat Dokumen > <span class='titleFormOutput' id='titleFormOutput'></span></h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form onsubmit="return checknomordokumen();" method="POST" action="surat/save/add" role="form" id="wzform">
            <?php
            if (isset($alert) and $alert <> '') {
                echo $alert;
                unset($alert);
            }
            ?>
            <input type="text" name="id_template" class="form-control" value="" hidden>
            <input type="text" name="kategori" class="form-control" value="" hidden>
            <input type="text" name="kodeSurat" class="form-control" value="" hidden>
            <div class="card-body">
                <fieldset>
                    <script>
                        var span = document.getElementById("coba");
                        var tampil = document.getElementById("tampil");

                        function gfg_Run() {
                            tampil.innerHTML = span.textContent;
                        }
                    </script>
                    <div class="form-card">
                        <div class="form-group">
                            <label>Nama Dokumen</label>
                            <input type="text" name="judul_surat" class="form-control" id="titleForm" value="">
                        </div>
                    </div>

                    {{-- <div class="form-group">
                        <label>Setting Expired Dokumen</label>
                        <div class="card collapsed-card target">
                            <div class="card-header" data-card-widget="collapse" style="cursor: pointer;">
                                <span>*kosongkan bila tidak perlu</span>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool"><i class="fa fa-chevron-down"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Pilih Tanggal Expired:</label>
                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <input type="date" class="form-control" name="expired" />
                                    </div>
                                    <label>Ingatkan Berapa Hari Sebelum Expired</label>
                                    <select name="remind" class="form-control select2" style="width: 100%;">
                                        <option value="0">Pilih Berapa Hari</option>
                                        <option value="3">3 Hari</option>
                                        <option value="7">7 Hari</option>
                                        <option value="30">30 Hari</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div> --}}
                    <?php
                    // if (isset($template['levels'])) {
                    //     echo "Dokumen yang dibuat dengan template ini harus diapprove oleh : " . $template['levels'] . "</br>";
                    // }
                    ?>
                    <input type="text" class="input-replace form-control" id="nomordokumen" name="nomordokumen" hidden>

                    <input type="button" name="next" class="next action-button btn btn-primary" value="Selanjutnya" id="next1" disabled />
                </fieldset>
                <fieldset>
                    <div class="form-card">
                        <div class="form-group">

                            <body data-editor="DecoupledDocumentEditor" data-collaboration="false">
                                <main>
                                    <div class="centered">
                                        <div class="scroll-area">
                                            <div class="row-editor">
                                                <div class="form-control editor" id="preview">
                                                    <?php
                                                    $konten = '<p style="text-align: center;"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAioAAABiCAIAAADxxm/MAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAgAElEQVR4nO2dZ1QUSdeAa4YZcs4CkpMKKoIiBgRMIOoSRTEACgoGxJwzKwbMrmlVELMiigoiqCCKCRBRQXJGcmYIk/r7UWt/s5MYENd133oOhzNdU+HWrZ6+3VXV9xIwDAMIBAKBQPyzEH+2AAgEAoH4XwSZHwQCgUD8BJD5QSAQCMRPAJkfBAKBQPwEkPlBIBAIxE8AmR8EAoFA/ASQ+UEgEAjETwCZHwQCgUD8BJD5QSAQCMRPgMSZ1L9+ENraKDV19RiGtba2SktLE4kEPR2tfqwfQiAQ+r1OBAKBQPw42M0PhmHfaX6qa+pycnMzMj6kpmXUNzQQCJi4mDiBAISEhBgMBgZAV2fnYJNh5sMHy8rImJubqygrfU9zANkeBAKB+AUhsBmbPpuf9nbKx0+fb9y6U1RUKCkpaWBgaGczXkVVRUJcQkJCHAACmUyi0egAYG3tlA5Ke1V1dWJSSltbc1Nj41zPOWbDh6uo9NEOEQgEZIEQCATi16IfzE97OyUx+eX16zfq6xtmzpxuYz3e2MiARCJhGNba2sZgMgGGUalUERHhtrZ2cXFxYWFhAoEgKSlBIBBoNNrHz9lPnybm5uXr62nP9Zw9UEOjt7YEmR8EAoH45fgu88NkMj99/rLvwMHGpqaAJUumTLYTFxPFMKymti4942NlRVn80+eamtrlZcVfv1aZmw17l/ZeWUVVUUGhm9rt6DCVTCLb2VrLyUoTicSm5tZHcfE3b92aNNFusa+PiIhIL/rQH+aHTqfn5ORgGEalUiUkJPT19UkkUkdHR1FRkZKSkoqKCsz2+fNnaWlpTU1NeFhYWFhYWAgAMDAw0NHRwfMAANTV1eXk5GCezs5O1rbk5OTU1dX5tAsTWTs4ZMgQmCgjIzNw4EA24dlazM3NpdFogwcPJhKJAIDi4uKOjo4hQ4ZwzQyrFRcX19XVhRlycnIkJSU1NDR41d9jEa5dVlFR4dUpJpNJpVIlJSV1dXWFhYV5qYW/PLASBQUFfCB6HD7BlQ8AqK+vr66uJhKJgwcPhl+Vl5e3tLRISEjo6OjgMnR3d0tISOjq6oqKiuJN9KrXnB3pl4Hu82j2SlFcu/Y9Ku3tT7IPHexR7X1TWp8Lci2C//Dhjwsf9F8b7O8wmUyGYHR2du3cE2I+auyFsMuUjk6YGP/0eWFx6aSpjhMmThs+cpzdlJmLl68zGDRUVV3TdtK035xdR421NR89wWdJ4FzvxePt7Kc4uqzdsC0q+iGdTmcwGM0trcdPnpnu5P7yZYqAYjAYDCaTiX039fX1UCFwUNXV1ZOTk1NSUgAAGzZswLMBAFxcXDAMo9PpHh4euBqnTZsGM3z48AGmrF27FqYMGjSITeeLFy/m3y6eCBEVFcUwrKGhAQAwd+5cNsk5W/Ty8gIAPHr0CP50FRUVp0yZwiszrFZMTKyiogKmKCsrL1q0iE/9PRbh2mWunWLrvqKi4rNnz3iphZc8bDVramrevXsXwzA+w9db5WMYtnXrVpjS2NgIU8aMGQMAGDduHGdVsrKyUP996zVbR/ploPs8mr1SFNeu9YtKe/xJ9rmD/NXeZ6X1rSCv09vDwwPDsKysLDKZPGvWLOw/QR/tZ3FJmcec+aVlZZG3rnvNn8NkMvMLikOPnLh+/WZDfb2SsrLJEOPZsz2oNGp9fe3UKVMXL15iZ2ejOXDgNPvJsrIyYqJilRUVZBJJWkqitbUlNPRIc0vrs8RkMokU4O8bun/vyTN/Hj72B5VK7Zt4fUBMTAwAsHLlSjqd/v79+7a2tg0bNsA7bjKZjGcjkUhCQkIAgOfPn9+8efPAgQN0Or2lpeXEiRMww40bN8zMzEaMGHH37l2Y8uDBg/Ly8uDgYABAbGxsUVHRrl27+LcLE5cuXVpWVlZQUJCamgoAgHfTnM+FnC3u3btXUlLy6NGjAIBbt261trYeO3aMV2YJCQn4ISgoCH4QFhaGAvS5CNcuc+0UTFy1ahWDwcjIyKBQKIcPH+alFl7ywMxr1qypqqqKiopiMBju7u5paWl8hq+3ygcA1NTUGBgYAABevHgBAGhubn737p2+vn5bWxte1dq1axkMxtu3b5ubm8+dO4en96rXnB3pl4Hu82j2SlFcu/Y9KhX8J9nnDvJXe5+V1reCvE5vMplMpVLnzZtnamp68eJF8J+gL+Yn/f2HRYv9ra3HHw3drzlQ/c27dN/FS1euXnP12nVjY6NHj594uLstmDdnqZ/3pQunTx8PPRCye8fWjZs3rDl86ODWTeuvhP+5fvWy40cOLvZbRKPSKB2dwiKiW7bt2r5rz5GT5yorq3R1tE+fONrU1LR9V3B7e3u/95kr8AxmMBgEAsHMzExHR6erq4vzXBcWFoY5MQwDAKSkpFRXV0tLS8NHaSaTeeXKFScnp+nTpxcWFsIzWE9PT0NDQ0ZGBgCgpKSko6OjqqrKv12YSCKRBg4cqKenZ2JigudknYPi1aKamtqmTZseP36cnZ0dGhq6adMmY2NjXplhtS4uLpGRkVFRUbCPeCt9KMKry3w6RaPRAADDhg2TlZWFkypc1cJfHhKJpKqq6uzsHBERQafTjx49ymf4eqt8AEB5efmkSZOIRGJMTAwAICoqSk9Pz8DAoLGxEa+KyWQCAJSVlYlEooWFBatsgveasyP9MtB9Hs0+nKVsXfselQr+k+xzB/mo/XuU1r8/NxKJtGzZss7OztjYWNyG/er02vykpWds3LzNe8H8wOX+oqIid+/HlJaV02h0ExPToUOHFRWXTHOYMsPR3mz4sIbGppbm5sio+7uC9y9ZFuQXEBiwfPXmbXtu3o6qr6+XkJBwmjHtjxOH/f28rcdZFRUXqQ9QTU19t2X7rjfv0khk0paN6zTUNXbuDm5r+ycsEBzjioqKuLi4oKCgzMxMPz8/eJaznusiIiJwKsDW1tbBwSE6OlpbW9vHxwc+IMfHx1dUVLi5ubm4uAAArl+/zla/gO3CxIiICD09PU1NzWvXruE52SZ8ebUYFBSkqKi4du3axsbGTZs28ckMq50+fbq5ufmyZcuam5tFRERwaftQhFeX+XTq06dPJ0+enDlzprGx8e+//85LLfzlwZ+VbWxsxMTE8vPz+Qxfb5UPACgrK1NXV7eysnrw4AGGYdeuXZsxY4aEhAQceljq5s2blpaWgwYNGjdu3LJly/rWa86O9MtAf89o9vYsZeva96hU8J9knzvIR+3fo7T+/bldvXr1/Pnz06dPxxe9/gNwee2UD5kfP2/asn3u3DkL5s1pb2//+Dln374DYuLiRKIQncE4EBJsoK/T0tL66PHTmNiYLzm5ZLKwkaGhlaW5lJS0EInMYNAp7W0fPmbv3LOvrbXF2Nhw4sRJE23Gj7EaXV5ZdfbcxY8fM43NRxw7cdLd1dnd1TlgyaKTp8/t2hO8Z9cOzgfb/gXetyYkJOTl5RkZGT169Mje3j4vLw8AQKfT8Wx0Oh1OghGJxIcPH169ejUkJCQ8PDwjIyM9Pf3ChQtiYmLw0VhYWPjmzZsHDx6Evw34tARb6bFd+EsYOXLkvHnzaDTaiBEj8Jxs5odXi+Li4l5eXocOHQoNDcXn67hmxvt1/vz5UaNGbdu2TVxcHPu2/aQPRXDYugw/cO1UQUHB1atX09LSbGxsZGVleamFlzwwM7zjhmXpdLqCggLsONfh663yAQClpaXS0tLu7u5BQUEJCQlJSUkhISGnT5/u7Oxsb2+HeweMjY3nzp2bn59/7NgxS0vLjx8/wrK96jVnR/ploIlEYp9Hs7dnKVvXuA69gCoV/CfZ59OVj9r7XGffCvI5vR0cHGg0WmhoqImJCVzz+y/AthbEZ+tBaVnFhIlTz1+8BPcIzPL0Hms9cco0JyfX2afOXGhobKLT6Vev37YabzvJfsbFS1fKKr7y2S9QVV1783aUk+tsyzETLoRdptFoNbV1x/7402K0tb6x6dPEF7W19VQqlUqlhh4+vmrthh+99QDu1PLz82NNbG1tBQB4e3vDQ7hsuGvXLtY8dDp9zpw5AIDExERhYWETExMPDw8PDw+4tycxMRFmg4tDKSkpgrQLE1l3KOCJgYGBeEpdXR2fFs+fPw8AePLkCf/M8CISFhaGYdju3bvJZPKQIUNWrlzZtyKssHWZT6d8fX0xDIM3xcHBwbzUwksetpojIyMBACdPnuxx+ARXfm1tLQAgPDz869evRCJxwoQJRkZGGIatWLECsOz08/f3h/lXrlwJAMjKyupDrzk70i8D/T2j2duzlK1r36NSwX+Sfe4gL7V/T539+HOD4vn4+DQ3N2toaEhJSZWWlmL/CQQ1P11dXbPmzN+z9wCVSq2tqz96/KT5aOvR4+yePE18l/qewWB8yPxs7+g009n9bWo6LEKj0fLLvpRWFcFdbbzIyPw0b8Eia7spr968g0bObsr0ZYGrNbT0b92JZjAYFErH+k3bb0Xe/aHmB6524qc1jpWVlaSk5IMHDwoKCnx8fIhE4sePHzEMKysri4uLKywszMrKcnV1JRKJcBtPTEwMLHjv3j3W6xFcW37+/Lkg7cLf2JQpU+7fvx8ZGXn16tWKigqY093dPTo6+vbt21euXNm3bx+fFk+dOgW+bYvCMAwuSnNmhqtrZ8+exTCMTqePHDkSABAQENC3IqywdZlrp2Cil5cXhmFMJlNXV1dFRYVKpXJVCy958JoTExMPHz4sJSVlZmbW1dXFZ/h6q3y4Wh4ZGYlhmJ2dHQBgz549GIbB+a5Xr17BUs7OztnZ2TExMXp6egoKChQKpVe95tURXh3v1UB/z2gKriiuXYNGorcq7e1Pss8d5HP+9LnOfvy5QfHmzZuHYRhcLpo+fTr2n0Ag80On048cOzVnnk9DQ2NXV9eqtZusJ04zGzVuqqNzbV19R2fntRu3LcdO+PPipbb2dliku7vrVPTvI4NkRq2Su5F4jkaj8rFAHR2d12/eGWNtd+KPs+3tlKeJyfO9/UaMHHvw8IkTp/5kMBhfq6pnOLnn5Ob9OPNTV1cHAJg9ezZbenZ29rBhwwAAAAAxMbETJ07A9NOnT4NvyMvLnzt3btSoUUQisb29HWaAy6cDBgyAhyEhIQCAp0+fCtIuTGQlISGBM3Ho0KF8Wjxy5AgAAN9Cyks8WO3Ro0dh+sePH4lEIvzN96EIK2xd5tMpT09PmGfLli3wksRVLfzlgUhKSnp7ezc0NPAfvt4qH94Rw0sDXJT+/PkzhmFwE2N0dDRrKTk5uZkzZ3748KFvvebsCP9TS8CB/p7R7O1Zyta1sLCwPqtU8J9knzvI5/zpc539/nPDN1tbW1sDAGJjY7FfH4FeOy0uKZs1Z15E2HkjQ/2Ll659zvqSlPR05YrAYcNMhwwyOn/xUuyjR+vXrZ0wfgxepKAye8VpF4yAAQDESVJ/LL83QIH9hSw2Pn3+snP3HmNj403r1xQUlSxZuqK7q9PKaozXfE/LkeYvX725FHH5zB/H2LaXgH/E60FFRUVdXZ2hoSHrnpPS0tL6+noZGRlNTU04T434WVCp1M7OTgzDZGRkOE8GrsPX78CbISEhIV7bTASBf0cQOP07pkjtPwWhnTt38s9BpdJ27dk7duyYGY72GZmfDh0+SmcwdHR07WwnjDQffv5iRNzjx/tD9o60MGMtFZ92T4QkttPzzMxR87NK0hVlVHVUDfk3pKKsNNrS8l70/Q8fP89ydTI3G/72bVp3V+e4cWPl5GT1dLRepLzq6qYaG7HX8w+YH2lp6QEDBrDZGFlZWTU1NXl5+e+53CD6BSEhIVFRUVFRUa5nAtfh63eIRKKQkNB3vovOvyMInP4dU6T2n0LPP5X8gsLXr98sXeLb3U29dPmaoYFhZUW5grzs+LGjYx4lREVFhewNHjLYiK1USVW2vLTiQBXtgSraImSRwoovgkijpamxN3jXhw8ZtyKjRlqMmOvpsW3LpkdxcXt+308gENauDrpx83Zra1tfOopAIBCIfxM9bLym0ehnzp1f6OMtLi525+791LT0cWNGr1oVZDN+bHll1c5de44fPTRkELvtodKoX2oz2ymtnrbLOrsoH0peksiC3hJqqKuFHtjv4Tlv+LBh7m4uixYvKy4ulJOTL6+s0tRQMzI0SEp+OXO6Q1/6ikAgEIh/DT1YhdKysowPH+Z5zqbR6OYjzOIe3h07xkpjgIq8nOzmLdt8vBeMsRrFWaq+paa+uUZSTNon1G7lOTcJUdn8quzG1nrOnFwZMtgoePfODZs2EQjgctjZRYv86hsag0MOAgDmz5sbHx9P/bZDH4FAIBC/KD2Yn7vRD8daWUlLS+YXFG3ZvuvMuQtDTU3GWFm+eZtaWlrqvWAu15nusrr8mpaytKLnxU05eTWZeTWZVU3l9a3VgovlOG0qiSwcE/uY0tH57OkTYTKpuqqqqLhMT1ero7M763NW73qJQCAQiH8Z/MwPpaMzLS3NwcEew7Ck5Je5uXlxcY9Lyyo6O7vO/nl+aYC/lJQkZykMw5IyYzppHayJTR21GQWvBReLTCItC/APvxTBZDDGjBkzfPgIPT39xOcvAAAzpju8TX0veFUIBAKB+BfCz/wUFZdQ2inmI4YzGAwlRQV1dXUjI6MRw03zC4oKC4ucZk7nWuprfdnz7Iec6XEZtyhdvfDeZmdjTaczMj9lTZ5o87Wq6tWrlKh796lUmsmQIe9S33LuDkcgEAjELwQ/81NZUaGorCwlKZGannnw0NH6hkZ1dXVJScmHsXEzpjuKinKPCHcnJYwsRNZSNGBN1JTVL63Je5X1hDWxvbMt4V3026znXG0JiSTkMcstKuqekaG+u8vM7u5uGWlpJsY00NdVUFCqrqntfWcRCAQC8W+B3863F6/eWo8bAwAwG2YyfbrD3ahor3lzKJSO9+lpgYGBXItU1VfEpF5ZMnX7tZcnWNOH6oxSkFKNeHZ0wrBpwqS/tur/Eb0r4sURYZLISd/osaaTOWuztLS8E3W3qrq2urZeVlbuc9bnW5HRXvM8REXFPmRkDHCw72OnEb8IfIJscoYKxcnIyCgoKFBTUxs9ejR8JSsnJ4dOpw8aNAge1tXV1dTUaGhoVFRUwECZ/GNQssW0hZnZImzyipjJNVSloaFhXl4eWw2QlpaW8vJyDQ0N6IQU9D72JZ9QsLi6+Efg5RUmFYHoZ9i8ILA63Znl6ZWYlEyj0U6cOjt5mvPQEaPz8wuyv+TaTp7WTung6v9mR8TSdefmx765NXy5mLE/wP9s12s+Tbtvv8Uo7t0dPLPvkanG/mBwAPHqkxNca6PR6PbTnVLT38c/SQpas8FrYcCBQ8cYDMatyLtRd+/1r9MdxL8Q/kE22UKFYhhWU1MDXZJATExM8vPzMQwbPXo0AAB6wcG+ObV8/fo1+ObLhFcMSq4xbaEAbBEneUXM5BqqkmsNEOiK5urVq/Cwt7Ev+YSCZVUXnwi8vMKkIhD9Dr/Jt67ODhkZGSqNVvm1trSk2NHRUVlFpaWlWUpKWozbzFt+WfbzrIcLJq58mhndRf/bvVVNW0VFfYmz5cLLz47TGTRo9sx1rQEAwiRRfVVTrgIQiQQNjYFlpeVGhnpFJWUNjY3lFZXd3VTNger1DS18JEf8N+ATZJMzVCiGYS4uLmlpaZGRkc3NzWFhYXl5edOnT6fRaM7OzgCAp0+fwmqTk5PNzMyGDh0KABAXFwe8Y1ByjWkLBYAF2UTljJjJNVQl1xpY68FDJ/Q29iWv/Gzq4hOBl1eYVASi3+FpfppbWplMppi4OElIyHTIoGHDzYqLS+h0el5+kZYW+4wBAIDBZMSm3Zw5ch5JSDi1MIntWybGTM6OmTjit8a22lefngIA8iuy7r4NAwB00zqP3NtCo3OPq62vq1tQVCIqKlpfV19QkDdk8CACkSAsLFJUUtLXLiN+GfgE2eQMFZqUlJSSkhIUFOTq6iojI+Pt7R0QEJCbmxsXF+fh4UEgEGJjYwEAlZWVmZmZ3t7erNFjecWgxLjFtOUadpZXxEyuoSq51gCBgdTgV72NfcknP5u6eEXg5RUmFYH4EfA0P03NLSQSSUpSsrOrKz4hPjcnZ4TZMAlx8faODlkZac78QkSh2TZLFk5Z+/zjw4Y2Lq/4fKn80EZpnm+3Mur1xYaW2qeZ0WWNBQAADGAfKlLSclK4imFspFdeUUEikeTk5Ts7OmLjHndQOsTExDM/ZPS1y4hfBj5BNjlDhb59+xYAMGHCBLy4jY0NACAnJ0dLS2v8+PHJycltbW0PHz4UERGZN28erIf1P2cMSq4xbVmLsInKGTGTa6hKrjVA4BQZ/N/b2Jd88nOqi6sAfML1IhD9Ts++cISEhEaNGiUhIV5dXc1gML5WflVVVuaaU0VeTVhYJDb9BgNjcH7bSKl5lZPgZu2jqaC//LjLhYR9rN/eexvO9QGI/O02sLW1RV1dXVtTC/n3/N8BD7K5Zs2asrKyR48eBQQEsMbTjIuLExISgqv0DAYDANDd3Y0Xh7f88OFg7ty5NBotISEhOjra1dVVXl4e1gOfb+B/GIOyoaEBj0EJY9pGREQYGBiEh4dPmjQJrjXiRdhE5YyYiYeqdHBwCA0NvXTpEp4Z4/3yAHz6wWNfXr58Gca+ZDKZXCuE8MnPqS7ALQIv1xr6MHD/fuTk5AiInwHrfpaezQ+Dznj67PngQUa6ujoYwDQ0NKpqanhlbu9o85u4OcTjyjg9Bykx2RCPK/ZDPWRFFTfOOB7icWWwurkQkbR61t7r215eWP5URvSvcLZDNUa/zUmobqzgVa28nGzcgzvKqmrZOblUKvK4878CvPZ5enpmZWVFRUXBeNv49ff169cRERFPnjwJDQ0FAAwfPhwAcP/+fbx4TEwM+PY8NGvWLGFh4QcPHiQlJfn6+uL1QKMF/9Pp9OHDh2/btu3s2bNdXV0wkUgkzp8//9OnT3PmzMnMzPzy5QtrQTZR8aef6OhoGo3m6OgI0xUUFK5fv66hobFixYqysjKuNUC+fv0K89fX19+/f19PT6+ioqKiosLAwKCysjI5OZlrhQAA/vk51YXLjAeu5lXD947iv5Lm5uaftuD+v01zczM+CjzNj6SEBIPB6OzsJBCJomKisrLyjU0tdDpDTFSko6OTVykFGaVpY91nWs/RH2AiKiw203rOIJ3hEsLSU0Y5z7SeY202Fc9JJgmTiH/NfRtqDLUx/e3J+2jOCnPzi5SVlLq7qU+eJjLotOHDhklKSnR3d+no6vflpEP8UsArI+3vLv7gIfw/e/ZsXV3dEydO0Gg0e3t7MzOzixcvbt++/d27dzt37oyIiJg/fz4MWiwrKzt16tQbN24oKyvDSTlYAzQYrP83b948fPjwrKwsKpVaXl7++PHjoqKi3NxcKpVKJBJVVFRYC7JJVVJSkpSUdOTIER8fHzMzM19fX1xaGRmZ48ePt7W1LVu2jGsNmZmZ6enpR48elZWVHTp06LVr16hU6v79+2/cuHHjxg04Y3bz5k2uFQIAeszPpi48ETc/vGrot+FEIP4OT/OjpChPJBLbKRQRYbLZsKFv3ryq+lopTCYbGuiWlfN8TBEcMREJMvmv7T0q8mr+jltGD7LlzJaXX2hspF9XV3fi1LmRI0cONTUhEgnd3d0mQwZ/vwyIfzldXV34fxw4vQYvnQQCYc6cOTU1Nffv3xcSEoqNjbWzs9uzZ4+lpeXvv//u7+9//vx5vOCMGTO6urpcXFwIBAJeD3z9hfW/kJDQhQsXiERiZ2dnTEyMvb29np7ekCFDEhMTz5w5o6SkxFqQTar4+HhbW9vt27e7uro+efJEREQEpkNL4+zsbG1t/fDhQxhHma0GR0dHCwuL8vLyS5cuiYqKXr16lUgk4ktZcEN5dHQ01wofPXrEPz+nunCZcfPDq4Y+Dh4C0RP8XjslC4u0t7USCEQxMVEFBaWiooK6ujoZGdmmpkYajU4m9xCsoYeGhUjSYnLNHfVEAlFeSlFVQUOVIxwqk4lVfq3U1tJsaW2j0xklRflDBhmQyeS6ujplRdnvaR3xS6CoqIhxLJCwJQYHB8MNxAAAVVXVhISEysrK2tpaHR0dfJED4ufn5+fnx7UetjpNTU3xmTEHBwe2mLa8pOru7uaMmMmW+fnz5/DD/Pnz2Wp4//59Z2fnwIED4b4DuJMCR05ODq+Ha4UODg6C5GdV18aNGzdu3Ih/xadFBOJHwG/tR1lZuai4lEQSCli88G7kNY9Zs169TVNUVBATFfmUJVD4OD4MUBzoPnbx8IHjxhlMmzlqAdc85RWV3V1diopKbe3tFEqbrd3E8ePGAQBS0z/wcvmDQKirq5uZmbHZnj6jpaVlbm6ur6/fY2BNYWFhGRkZWVlZQp8iZiorK2tpaX1nsFQE4heC37k+YfyYlFdvAAAtLW1Hjp28fvP2h8yPigryg4wHpaRw3yctOCQhkrioBFmILEwWERflHq09IyNDQ0NdUVHhxYuXVV8rN2/ewqDTAQAtLS16emjtB4FAIH5h+JkfPT298vJySkenpKR4Vm7RKEurkpLS0rIKF5ffbt6O+geEC4u4Ot1xWmNjU+r7T95eXg+i7yopKVRUVnW0t+rr6f4DAiAQCES/QKFQcnJyfrYU/y74mR9dbS0REeFPn7KIRKKEKDn5eVJxcUl9ff0gY0NlJcXH8c/4lJWXUjJSGg4AkJNQUpXRJAmROfMoy6iZ6ozUG8B9E8Hb1Pft7W1jrCzT0jNaW5sTk57n5HwBAGRnfzEwHoTmKBAIRL/T2to6efJkfHbH29tbwFITJ060tbV1dXW9ffs21zxfvnzZuXNnP4nJ3rSNjY2Njc2DBw84RfLy8srKygIA0Gi0oKAgGxubOXPmUCiUhoaGJUuWsFZ15syZqVOnenh4lJeXw5Ta2lpvb2/oB+RHwG/7gIyMtKmpadLz56MtLfHJKNIAACAASURBVJx+m15aVqGrq62uri4mKrZooc/JU6esrceIiYoCANra24uKSoYNNcHLutsucrSaDQCwN3cfYzRZTkqes37LQTYjjcZzXd7EMOyP02fcXF2kpaWUlZUGqqu1tLTYT51CIBBiHj1eMNeDswgCgUB8J62trUVFRYGBgampqUQi8eXLl/hXTCaT111va2trS0tLampqeXn5kiVLysrK1qxZ02Op/hK4paXlzZs34O9uLHCRnj596uTklJ+fDzfWJyUl5eTkEAiEzs7O9PR0PP+rV6/u3r0bExOTkJCwdOnSBw8etLe3+/n5ycjIwHfRfgQ96MX5txmPHsd3d3fbThhPIpOzs7M3bt5aUFg0ZZINgUCMfhDLxLB2CuXo8VPrNm1LfvH/C0LSErKqCuoAAAlRyQGKGkQiF1cFQkQhMklYmCwCAIh9/CT9fSaV9pc30sTnL0uKS+Z4uF+5eis8PGLd2lUH9u2VkpIsLa+kUNoMDQ37UwcIBALxDS0trWHDhkVEROApTCZz4cKFDg4OFhYWrOlsEAgETU3Ny5cvHzlyhFep9vZ2W1tbtk2GvYLJZDo4OLC9DEcikUgkEueeFwKBMHHiRPiOrbi4eFZWVmtrq7GxMae729jYWE9PTxKJZG9vn5qaCgCQlJSMjo4ePPgHvuLSg/kx0NfT0tR8EBMHAHC0nywvL79ksZ+Bvi5RSGj3ru2HDh0uKSm7Gx1TWFQyZdLE9IwPiUkve+ulo7ub+uLVuzuRUT6+i7du211bV19VXbt9565tW7dQKB1Xr117/fbdqtXrtLU0AAAPHsSMGzuGa5BvBAKB+H6YTOaePXtCQkLwF7Pu3LlDJpMfP378/PnzrVu3sjp24kRRUREA0NHRwVmKRqN5enquX7/e0tKyz+IRicTZs2ez+qstLCx0cnJycnLKzMxkzdnS0nL//v2lS5fCd93c3Nzs7OxMTExCQ0M555xqa2vhZlECgUAmk7m65Oh3enh3R1xcbMli33XrN7u5/ObjNdfCfASlo2PRkuXjx49f5OXp4+MTtHrtkUMHi4qKGhvr29o7nyQ8fZ+RsdjXR0AL0dzcErAiiEggLvbzzcnNsbWzZTAYa9dvsrWxmTxxQuzjpwcP7CspKWlqagQAtFM6nj59dv7cqX7oNwKBQPBAXV3dw8MDPsQAALKzs83NzQEAEhIS6urqNTU1nHECceh0Oo1GExcX5yxVWFjIYDBYQ1L1DS8vL9ZDbW3t8PBwAICUlNSJEydiYmIGDBiwZ8+e7u7usrIyFxeXSZMmAQAIBMKOHTuWLl3q7Oysrq4+fvx4AACeX0ZGhkKhwAqFhIT+GdeaPU9KmpsN09HRunTlOoZhzS0tq9estRw16urVKwCAxYu8hwwesmnLjiV+Cxf5+NTW1tDo9Jkzpm/curO8oofpwq9VVZu27lq+an3g8mVNzc0qKkrr168bZWG2/+BhCUmJbVs2FBWX/b43pLi42NV5pu9CbwzDTp4+6/Sbo4ICl2UkBAKB6EfWr19/5coVeEXW1NT88uULAKCrq6u2tnbAgAEYhtXwcH25f/9+GF+Ks5SxsfHy5ctZ333uG1VVVayH0I2srKyskJDQihUr4uLiwsLCAADKysrLly+fPHkynJSrq6sDACgpKdnY2MDPAAA8/9ChQ+GUYG5uroGBwXdKKCA9mx9RUdE1q1edOnXma1W1laXFokW+GR8yS0pKPeb65OUXbt28Xl9PNzBoXWdX55mTRw0MDd+8eycnKztAVRkA8CLlbean7LKyisqv1bV19TW1dV9y8z98zN4fejQ3rzD5RUpBXl5jY9OmDesaGppGWYxYu34ThUIJCd71OSvHZ5Efpb391Jmz1TW1AIDsnLyXL1NmzXL/4SpBIBD/qxCJRLhTQFJScv369dA/5uzZs798+fLbb79NnDhx7969ZDI5Pz8fPlJARERECgoKbG1tJ0yYUF1dffDgQc5SwsLCRCJxyZIlJBLpzz//7LOEDAZDT08PnwDEBebVEZzr16+PHj3a3t4+JSXFy8uLLYOHh0d2dvbMmTN9fHwOHDgAAKBSqdOmTQsLCzt16hQehrF/IbBNAkKnpGyZMAzbsev3tva2kODdAIC9+0OZGMjOyiKRhbdv2aijrfnHmT+fPHmyZvUqkyFDIu/en+4weaCGWvaXvEsREa6uboePHhsxYoSwsMibt2/cXZxpdHrw73t37tiWkPBsqKkJSVh46ZKFr16/Oxh6yNTUdHXQiqLi0mdJybdv3/bx8tbV1bIeP4ZOZwQGrV0dtHzYUC5xUaEf7x+hHQQC8Z+EQGC/9OGw7lXDMAy/tlAoFHFxcfxQwC1trKUYDAYeQfF7ZrfodDrr2g8vSTjT4fqTpKQkrwwdHR1cg/D2I6yaF8hvG4FAWLNqpfuceddu3PZa4Ll7x5bYx8+Snierq6mfvXDJ+TfHlcsDTIcM2R28d9zYMSuW+auqqLS1U/buO9BOoXR2dubk5MhKS+obGBXk5RKJxK7OzkGDhyQ9fxHg76ehpipEIu35ff/j+PigwBXTHR2qq2t27N5bUlwweLBJUUmxj5ensLDwnxfOammqc7U9CAQC0Y+wXpFZ72vxqLKc2fjAWgo3Od+5ssIWJ5eXJJzpIiIieBx3rhl+tO1hQ6CnH8iXnDy/JUv37N5lO2FsUUnZiqB1RAKQEBejM5l7dmwbZGxQW9dw8o8z96LvT5k8ce5cT3W1AQwGMy8vl8EESc+T9fUNJMVF8woKp0+zl5aW0hyonl9QfPX69Xv3HkyZPHHF8qWqKsqnz118FPe4orx8w4b1mZmf9u7ZRiaTIqOiU1JSQg/sExLirmX09INAIHoFn6cfxA+FVfM8zU9jU/PigMCxVpZeC+bKy/3lvTHhadLOXbuD9+y2nTAOALBu43ZDQ4NbtyOXL1tKBMwRI8zU1VRr6xqu3bj14MHDltbW8WPHDB1qqqo6QF5eXkpaqqurq6amtramOvvLl2eJzyXExR3sp86bO1tdbUBuXkHyi5RrN24OHmzy7t3rFcuWLpg3BwBw+050WHh4+MU/lZUUcSEfxDyiUDpnz3LB+4PMDwKBEBxkfn4WApkfAMCVa7d27tptYmJyYF+woYF+VXVNeMQ1bS3Ns+fO7dy+3WbCWCqVFhZxNfpBLJ1OI2CMO7euS0pKwEraKZTa2rqXr97l5uW2NjfWNzTBaF2qyopiElKGhkYTxlupqqpKSUpAy9HZ1XU3OvbIkUP6+obHjhyUkpQQExOLjLp/6syZVStXkkkE+6lTAABNTc0HDx9PTHz659kzJkMG4f1B5geB+JeAYdiff/45b968f3gmhxUmkxkaGurv7y8tLc01AzI/Pwt+5ofJZObmFbS0tNBoVEpH1+Ejx0ZZjk5OTjpz6uSmzduam5u0tXXGjhlz+cplf/8lHm7OABCev0j54/QZ34U+9lMm8mqyqbmV0tEhKSEuK8P9bAAAtLa1Hz/5x/y5nhrqahgG/rwQHnknynfRothHsVVVVdMcpqwOWrlj914xMYnPnzOPHDpYWlqqpqauoqxEIgkh8/NTaGpqotPpioqK/wH9M5lMBoNBJnNxTvhvbut7huBHDB+DwViwYEFUVFRaWhqMMwv50eplqz8vL8/MzExDQ+PJkycDBw7kzP+zzA+FQikvLzc2Nv7nm/6XwKp59tUUBoN5+dqthX4B92Piox8+olKpTjMd9XR03Nw9TE1Nrl25pKKiHJ+Q4L/E/+y5P/eHHmlobLSdMO70iWOTJ3KJVYpTV1cXF/+Mj+0BAIiJii4L8NccqFFbV791x67o+w8C/JfcvHVTQ0MjIvxiecXXufO9W5qb7Wyt29o7rt64ExP3NHDV2vLKH+WP6FfH2dlZW1sb7qHkpKamRvsbbC5AYEFNTc0BAwZoaGiMGTPmyJEjrCFHGQzG0aNHdXV15eXllZWVVVVVN2/ejGeAxQcOHKiqqjpw4EBLS8vg4OCOjg4BBYDFbW1tWa8OI0eO1NbWLi4u5trHvXv34imRkZHa2tqsFz7+zbW3t+/YsUNXV1dERERYWFhCQmL16tVcK+evT0FU19u28MPXr19ra2vr6up++vRJkCHgL22PZSFv3ryZPXu2mpoaiUQSFhbW1tbGX0vkVDvOnj17rl27dv36dTgEvLrs7u6uzY2ZM2fy0gZXrfKq39DQ8OHDh0VFRW5ubng4V0Fwd3e3+YatrW1TU5PgZQXhRzge5e8Y9MWLF9bW1tXV1XhKQ0PDwoULLSws/Pz88B8mm79RtjrpdPrWrVunTp06Z86cxsbGfhMd+ztMJrOrq3vpitXbdwV3dXWXlJZX19TOcHJfs35LV1cXg8FobWvbd+DwmPG2N27dnTPPZ7qT2/MXr7q7uxm8uRl5123W7MGmw7fv2F1RWcUnZ2dnV2xcwiT76UsCVly9ccdqvO2JP850dHYyGIz2doqPb8B8b7+q6trKqmoKpWPjlp2JSckMBoPJZGIIDmDU5F27dnH99uzZswAABQUFAMCmTZs4CxobGzs5OVlZWcFb4+nTp8NvGQwGfKuOTCbb2tqOGjUKZhgzZkxHRwdefNCgQU5OTuPGjYPfzp07V0ABbG3/uo+5dOkSnqihoQEAqKio4NrHzZs34ylXr14F32KMCtKco6MjAEBeXt7BwcHe3t7IyGjLli2slW/dulUQfQqiut62Bb/t6uoyNTVlbbrHIeAjrSBlMQwLCQmB6WJiYpqamtLS0rKysmzdxKXFycvLI5PJbm5uPap38uTJurq6pqamSkpKcFwGDx6spaU1Y8YMXtrgqlU+KsUwDJqi06dPc44U56UPAn0WGBkZNTc30+l0PJ1KpXJqEv9Mo9FYv2I7ZC2bmprq4eHBtem+0dbWNnPmzPnz5584cYLzWxqNZmtra25unp+fjycWFhamp6dTqVRHR8dTp05hGJaSkjJlyhQajRYbGzt9+nTOOi9cuODv749h2MmTJ5cvX/49ArNqnov5YTAYrW3tk+xnvH6TWl/f4OLuuXL1elYjQaPR4xOeDTIdsXf/ofNhl0dajfdfGpidk8fLqDQ3t9pMsldQHhAZdZ+P7Xmf8dFzno+13dSrN+7s3B0yYuSYhKdJNBqN1Th5LVzsu2R5U1Pzk2dJm7ftgunI/HBl8uTJAIC9e/dy/dba2ppMJh8+fBgAYGhoyPrV1KlTAQDnz5+Hh7du3YL2oK6uDsOwkJAQeH3/9OkTzBAfHy8qKgoAWL16NV48LCwMfnvhwgUAgIyMjIACODo6kkgkcXFxJSWl+vp6mKinpwcAwA/ZRN29ezeecufOHQCAhoaGIM3h736XlJTgOfGLjr29PQAgODhYEH32qLpetcXar5UrVwIAZs+ejZ/nPQ4BH2kFKQtDBpDJ5LNnz+KXzurqarwSNmlx4MuJb968EUS9kBUrVgAA/Pz8WBO5aoNTq9CnAJ/6a2trSSTSoEGDMA54mR+IkZFRW1sb/Pzly5epU6c6OzuPHTu2tbU1IyPDwcHB0dHRxMTk+vXrtbW1kyZNcnd3V1RUPHDgANshW1msP8wPg8Gwt7dnM4chISFczc+hQ4cuXrw4ceJEVvODExgYePLkSQzDtmzZEh4ejmEYk8lUUVHhrHPNmjWXL1/GMKysrMzc3Px75GfVPPetzBLiYiuWBRw6cuzoyTPFxUXbt25i/ZZIJEy0mxD/6GFBQUF4+KXFfou1dXS9fXzne/vFxiVQKOzTLAAAD3f306fPSEtLcX7V3NJ6L/qh40zXVWvWjrK0nOfpeerU6eqamkcPo+1sxrPuTBcWJu/fG5yennbk+OmwsIjFvgu5Co+AwHcL2F4RgBQVFb148WLSpEmenp5EIjEvLy8jI4OtIP5UPnHiX0t6TCaTRqPB+Zzt27ebmPwVX2Py5MmBgYEAgDNnznR3d7MVt7CwAN8eOwQRQEhIiMFgeHp61tXVwWoBAPBlBc6+wLZY36LgTOHTHB4/mzVQCl4Wnnts72pw1acgqutDW0JCQpGRkceOHZs0aVJ4eDi86xdkCHhJK0hZDMPWr18PAAgKClq8eDG+mqKiooLXwyYtzu3bt9XU1EaNGgUP+XcZAiVkewGFqzY4tYr3jlf90MHMly9fKisrQV/R1dWNjY2NiooaNmzYixcv6HR6TU3NnTt3oqOjT548GR0dPWPGjFu3bllbW7u4uLAdspXtswyscLoc5UV1dfXjx495hSxqaGiIjY11c3MDAvgbnTBhwokTJ65fv378+PH29vbv7cM3eL45NXWynZGRYWbmR1lZuTXrNrZzGBW1ASrHj4Zu3rQh7tGj169fL1q00HL06CtXr/3mMmtZ4Jo7UfdS0z/U1TcAAMQlxBb5LHD5zdF6/BhYtqy8MjUt4+btO75LVrjPnnv/YYyzs7Obm9vj+PjEpMTt2zYfDg1RVGT37Vbf0Bi0Zp2IqFhuXp73As+BGmr9pYX/JPA3zHVVGd7puLm5qaiojB07FgBw/fp1/Fv8xWx4ePHiRQCAiYmJsrJyWloanA13d/+b96M5c+YAADo6Oj59+sRavL29/fDhwwQCYdeuXQIKICQkhGHY0qVLJSQkrl27FhMTA76ZH87rHUyJj4/f+I3Lly9z5uTVnLS09LRp0wAAK1asMDU1DQ8PZ10nYLNkfPQpiOp61Rb8cP/+/fnz5w8ZMuT+/fv424KCDAEvaQUpm5GRAdfY+Lgm42rjKysrKysrLSws8Eb5dxnCVZ9ctcGpVX19/R7rHzlyJADg/fv3vPrSI21tbb6+vosWLUpOToYm0MDAQERERE1NraWlRU9P7+bNm+fOnSsvL1dXV2c75CzbL3h5efE6D0+cOGFvb+/j4wMA2LFjx4QJEx4/ftzQ0PDy5cvjx4/jX1Gp1NmzZ4eGhsK7CnFxcf7+RmfMmAGn6aZMmaKsrNxfHeFpfshk8sb1q91dncXERJOTkwOWBZaVV7DlERMVnTrZ7tyZP+bP9YyPj49/HKelpbNg/jxdXd24hGf7Dxxc7L9s1px5ixYv8/VfvnDxssUBgd6+Ae4enkuXrww9fCQx6eXgwYO85s+Xk1O4ezfq9es3ywKWnP7j2CS7CSLf7psgGIaVlJavWbep6mvFKIsR2zavt7Pjt9MBAb79sDlPUyaTGR4eTiaT4RoAvP25ceMGhm9HIRIBABEREU5OToaGhuvWrVNSUoJODCsqKgAAJBJJVVWVtU4tLS34obW1FRb//fffDQwMlJSUbt++HR8fP2/ePAEFgMXl5eV3794NAFi6dGlHRwfrq9qcfXz+/Pn+b8DJN9Ze828uIiLCwcEBAPD582cfHx9TU1M8IjLbFZyXPlnho7petQUP379/39XVlZWVdeLECbwJQYaAl7SClC0qKmJLBAC8efPmzJkzULec0kIKCgoAAPr6+qyJfLoM4apPrtrgqtUe6x8wYAAAoL6+nrMVAQkLCxsyZMiFCxfwVUkcDMPevHkzY8YMTU3NhIQEUVFRtkM+Zb8HNpejrLC6HJ0yZYqwsPDnz58pFEpeXp6/vz/8isFgzJ0718PD47fffoOlBPE3am5u7unpmZ6eDtfb+gV+T3DiYmJz57jPnDGtsKgk8k6U/9LA4N07hg01YbONsrLSzk7Tx44dnZOb9+xZUsSVKzJSUto6OsbGxirKysLCJDghI0QUYjDoDAZTVEyUQumqr68rKSlOfPaMSqfZ2Uxwd9tiPmIYmdsTJZ3OePXm3dFjJ1avChw9ykKQp04EAID1as5KfHx8eXm5pKQkvOdtaWkBAJSXl8MdMuDbbWZpaSmDwTAyMgoMDPT29oZ+oqAZoNPptbW1rDdB+L4aFRUVWFxFRUVbW7utra2mpmbdunUpKSn4WyD8BYDFqVTqypUrb9++/ebNm3379kHPJZyhpGDQrYCAgIUL/5qJTUpKWrduHWtO/s0pKCjExsYmJibu27cvPj4+JyfHxcUlMzMTn4LAq+KlT1b4qA4AIHhb8HDXrl0dHR3BwcGbNm2ysLCws7MTcAh4SStIWfwuuKKiQldXF35++vTp1q1bLS0tXV1dcfHYhgN655SRkWFN5NNl1p6yVcVVG1y12mP9YmJiAAA8co+AsLrjtLKy8vf3f//+fWlpqY2NDYFAwK0jkUgcPHjwli1b3r17t3Pnzp07d7IdspXFS/VKGDYYDIaenl5TUxMcTSqV6uTkVFhYKCQkVFBQcPToUTwnHCwAwOPHj319ffG50Fu3bsXFxVVVVYWHhw8dOvTUqVMeHh7Xr1+fOXNmfX39H3/8wVlnYmLi8ePHOzs75eTkLl269D3y/w22dSG49YArF8OvWIwe98eZ8xRKB8fmghbP+Qv9lwZ+ycnv7qa+//DpyvWbW7btdPzNbdRYWwsrG7ORY0eOHm82aqyFlc3ocXYzXTx2B4fcuBX5KSsH1rB0eWDa+0zORltaWg8eOjZ7rk9Obj4vwdDWA67ABVvOBUk48aKoqKj1DbjyDHe2YBgGJzQOHjzIWWdJSQk8bfCdBRC4pK+oqMhgMGDxffv2YRjW2NgIQ9Nu2LBBQAFmzJgBAMjOzsYwLDc3V0xMTFJSEvalsbGRTR7odZh160FkZCQAQEtLS/D+4uATgOnp6bgeQkJC+OuTFT6q61Vb8DA4OJjJZMJ2Bw4c2NLSggk2BLykFaQsfEJiFQbDsPPnzwMArK2tWcVjzYBh2N27dwHfnYFsXYbArQeLFi1izclVGz1qlWv9MGYPXDZnhfPSxwqDZVcbhmFUKrWrq4vJZMJLDb67gUajubm5webu3r0bEBDAdshZFuPYfNEH2HbW9Vd+CoXC59vW1taurq5etcsV0OPWA654zZ9z5VLYs8QkN4+571L/NpdaWFSclpYmLCoREXGJRBIqLy/rpHSsXrXyftTN18lP3r58mvYm+U1KUtrr5Lcvn6Y8T7h7+9qSxb5NjY2VlX+d6w9jYlcGrSot+9v8XtKLVwsWLgaAGRF+zkBfV3BREeDbzSO8+8NpbGyMjo4GAMTFxZV8A87yR0ZGwqlzeLPJ9W0JLS0teA++detW+H4AAKC0tBTupwoKCiISibAgfC6Rk5PbuHEjAODUqVPwsaNHAViLGxoaHjhwoL29/cmTJ1xFgtlY09mEF6S/OLNmzYKPWW1tbXgleB6u+mSDj+rY4N8WfkggEM6dOychIVFeXr5hwwYBh4CXtIKUVVdXh3Mye/fuxaNnysvLA5alfjZpIXDtms9LIWxdZtUY21o3W/0CapVr/V+/fgUAsE029gjbAwqZTBYREcG9q+DTPyQSyc/Pb9u2bZ6enjdv3ty4cSPbIWdZwG0Js7f0dgZIwPz8vVRISUnxmgPvM73rhoG+bvj5M3ejH67bsGH4cDP/xb7GRgYEAuHO3Wgzs+EYo8vVzaujs+vDh49vUtPVNdQnT7R1dptdWlrq5ua+ddPa7bv2vn37liwscufmlbS0tJevU6MfPITvq2IYaG5p27Zz9x/HDktIiH/8nH3i5CkJcfHQ/b9ra2l+5+Pq/yZUKhUAcPr06Xv37tHp9K6urs7OzsmTJ1OpVGVl5REjRuA5p06deuLEifr6+qSkpEmTJsGZCl4Rhc+dO2dpaVlZWTl06FBXV1chIaHbt283NTXZ2dnB6yN8HxC/WHh4eAQGBra1tUVERKxYseL69ev8BYCt429BLlu2LCoqKjExEXCbQoHmhzXuPew1Xpx/c7Gxsdu3bx89erSKikpXV1dycjKFQlFRUYF7t2AleFVc9RkWFjZo0CC8Zj6qa21ttba2FrAt+AG2qKmpuW3bto0bN549e9bLy2v06NE9DgEfaQUpe/r06Q8fPpSWllpaWs6aNcvY2Pjz5894nZzSQoyMjAAA+IuxPXaZs6dsiXj9vLQqSP0fP34kEAgw6uiPYMqUKVOmTMEPNTU1WQ8RPcD2ZMRn8g2HTqdXVHwN3hc6ccq05SvXJL949TTxRUFhMfy2vKLSd8kK/2Uryyu+MhiMh48SvHwWVdfUMhiMVes2zXSZPczCqr29vbm5ZeuOPQsXL2tqamYwGJ4L/LKyc54nv4p7/GTpitXeC/3epaZ1dnb2KAyafOMF13jy8Crs5OTEmhN/tTswMBAvuHHjRl415+XlsS6lioqKBgUF4Q/msDjrq6Bz584FAJiammIYNm7cOP4CwOJJSUn4t7m5ufCGMScnh00SuK9pzZo1eArcFiUhIQEP+Tfn4uLCph9zc/P379+zdgSvnKs+4SQhm865qg5a0F61hR92dXXBJfQxY8YIMgT8pe2xLIZhNTU1vr6+UlJSrNnwd4fZxMPR1dUVFRVtbm4WpMsQeG64urpyqpFNG5xa7bF+CoUiJibG9T0VwHfyDfHjYNV8LwIucFJYVBITGxefkCAlJW0zwdrO1lpdXS0jI3Pn7j3Dhg4N+X0PmUyKjXv6JCHu8KGDAIAdu/cx6F2uLi7Dh5nW1TcuCVgmKiq2bu0qAz3d9x8+pqW9zy/Il5aRmTFtitXo0YI/YCKXoz+FsrKyvLw8MTGxYcOG4avrvxw1NTWFhYWtra2ioqL6+vrQvcKv0tb3DIEgZel0enFxcWtrq5yc3MCBA3v02BYcHLxt27ZDhw7hzoR+tHr513/27Fl/f/9z585xbiJHLkd/FoJ6vBaQ5pbWV6/fxj6Ke5/xQUdroJHxIAtzC0UFOQMDPWEyubyyqri42GHqJADA8xevyWQhc7PhNDqdQqFUVHwtr/j66fOnosICBhObOtluwoQJGuq9fpsHmR8E4t9AY2OjiYlJZ2fnhw8fWPdt/xSamppMTU3l5eXT09M5DScyPz+LfjY/OFQq7fmLV7m5OW/fpWV9yaHTaCrKSsrKSlqa6sRv5gHDsIKi0tq6egKBOMF6rKy0pKGR8SQ7m+9xhYvMDwLxLyEpKcnBwUFHRycuLk5TU/NnidHe3j5jxozM1o3cPQAABh5JREFUzMznz59Dj3ls8DI/ra2tzs7OTCZzwIAB69evHz58OP+G3r59e/78+T///LPHxB9EQ0PDunXrPn78aGZmduzYsZ8Y5EJAejA//dIGNGMlZZUVFZW1dfX/3x6BMEBVdfQoMyKR2I82A5kfBOJfwqtXrxYvXnzv3j22V1D/SZqbmydPnnzx4kWutgfwNj8VFRVOTk6pqalPnjxZunRpfn4+TGcymVw3QDGZzK6uLvyiT6fTSSQSW+IPpaioqLm52dTU1NnZ2dHRMSAg4B9o9Htg1Tz7+kp/XcdhPXo6mno6P+0OCIFA/POMGTPm06dPP/eOUFZWNjU1tc/FCQTC8OHD4X48JpO5ePHilpaWurq6w4cPjxgxwsnJaceOHWZmZpGRkY8fP6ZSqZcuXfry5UtAQICqqqqzs7ORkdGRI0f68/VMFphMpqOj4/379+GMEf5qsJ6eHud72f9y0IZmBALRz/zSsxF5eXkTJ060srKC9iM6OlpBQeH27dsnT54MDg4GADg7O1+7dg0AcO3atQkTJsAd4YmJiTY2Njdu3PDw8KDT6bzeW/h+uLocZfUf+guBzA8CgUD8P4aGhjExMVZWVrm5uQCA7OzspKSkefPmhYSEwCilLi4uDx8+bGlpKS0txeOWzp8/H3rW+fjx44+WkM3lKJv/0F8I5D8NgUAg/oaoqGhISIidnZ2fn5+Ghoa1tfXBgwfxb6WkpIYPH75x40bcqRpMDAsLe/Hixa5duzZt2sSt1n6jqqoKvgcGAGBw+A/9hUDmB4FAIP4CdzaqoaFhZGT07NkzDw+Pmzdvurm5kclkGxubJUuWAADmz58/c+bMgoKChoYGmP/48eMpKSn19fWLFi36fr+ifGD83eUop//QH9TujwBtfkcgEP9z8HnvB9/kxmAw8A26FApFSEgIOquF0Gg0uPjPYDCgV462tjYRERHoWBpP/BHA/XU/qPIfDb+N1wgEAvGfB712+rNg1TzaeoBAIBCInwAyPwgEAoH4CSDzg0AgEIifADI/CAQC0QsoFEpOTs7PlkJQMAzLysr62VJwB5kfBAKB+IuGhga4tRoAUFVVtXLlSs48X7582blz5z8qFl9qa2u9vb2joqK4fkuhUGBQJV68ffuWNSBFQ0PDwoULLSws/Pz8Ojo6+lnWv4PMDwKBQPxFZ2dneno6/EyhUPBw4+DvQXVZ4UzHY4ezOmHjzNYvLtra29v9/PyYTCYMK95jE2xiMBgMCwuLY8eO4SktLS3Lly9//fp1VVXVD3Jbh/Orbh5HIBCIf4acnJygoCBxcfHa2tpHjx7xSi8sLNy8eTORSMzPz/f394+Li6uoqAgJCTE0NOSarbS0dMuWLbNnz+6VMGwuRyUlJaOjo/ft28eWjUajubq6tre3Kykp8ZJ2w4YNMM46q6X5J32YIvODQCAQ/09OTs7o0aMBAN3d3TIyMgAAXV3d2NhYIpG4bNmyFy9eKCsrw5yc6bW1tSkpKa9fv162bFlqaiqcprtz5w5btpqamlevXlVWVi5YsKC35oery1FO7t27p6amdubMmdevX8MoDJzSlpWVpaenZ2dnh4aGshWHPkw3b97cK9l6CzI/CAQC8f8YGxu/efMGAFBQUODr6wsAaGtrW7duHYFAePfuna2tLZ6TM11fX19ERERVVVVHR0dcXFxFRaWtrY0zm4GBgYiIiJqaWktLSx8k9PLy6jFPYWEhjJWHRzziFGPYsGFcgxL9Yz5M0doPAoFA8CMsLGzIkCEXLlxgtT180gUsDvoa3rOqqqrHPCoqKjBWXkFBQa+k/Sd9mKKnHwQCgfgL3OUo62crKyt/f//379/DkAq4R1Fe6awfCARCj9l6BZvLUSqV6uTkVFhYKCQkVFBQcPToUZjN1dX1zJkzv/32m5KSkoSEhCDSQv5JH6bI8RECgfifQxCXo6yfaTQak8mE7kQJBALuUZRXOu4VFH7oMVuvELxUZ2enmJhYj9L+UAepbCCXowgE4n8a5HL0Z4FcjiIQCATiJ4PMDwKBQCB+Asj8IBAIBOIngMwPAoFAIH4CaOM1AoH4n0NWVhZG0Ub8w8jKyuKf/w+7vNTpOBZk8AAAAABJRU5ErkJggg==" width="571" height="101" /></p><table style="border-collapse: collapse; width: 100%; height: 90px;" border="1"><tbody><tr style="height: 18px;"><td style="width: 13.4298%; height: 18px;">No. Reg</td><td style="width: 30.6473%; height: 18px;"><span class="input-variable input-nomordokumen" name="nomordokumen" contentEditable="true">{{nomordokumen}}</span></td><td style="width: 30.9229%; height: 18px;">Tanggal Pemeriksaan</td><td style="width: 25%; height: 18px;"><span class="input-variable input-tangglPemerikasaan" name="tangglPemerikasaan" contentEditable="true">{{tangglPemerikasaan}}</span></td></tr><tr style="height: 18px;"><td style="width: 13.4298%; height: 18px;">Nama</td><td style="width: 30.6473%; height: 18px;"><span class="input-variable input-namaKlien" name="namaKlien" contentEditable="true">{{namaKlien}}</span></td><td style="width: 30.9229%; height: 18px;">Waktu Pemeriksaan</td><td style="width: 25%; height: 18px;"><span class="input-variable input-waktuPemerikasaan" name="waktuPemerikasaan" contentEditable="true">{{waktuPemerikasaan}}</span></td></tr><tr style="height: 18px;"><td style="width: 13.4298%; height: 18px;">Pertemuan ke</td><td style="width: 30.6473%; height: 18px;"><span class="input-variable input-pertemuanKe" name="pertemuanKe" contentEditable="true">{{pertemuanKe}}</span></td><td style="width: 30.9229%; height: 18px;">Tempat Pemeriksaan</td><td style="width: 25%; height: 18px;"><span class="input-variable input-tempatPemeriksaan" name="tempatPemeriksaan" contentEditable="true">{{tempatPemeriksaan}}</span></td></tr><tr style="height: 18px;"><td style="width: 13.4298%; height: 18px;">Kasus</td><td style="width: 30.6473%; height: 18px;"><span class="input-variable input-kasus" name="kasus" contentEditable="true">{{kasus}}</span></td><td style="width: 30.9229%; height: 36px;" rowspan="2">Koordinator Psikologi</td><td style="width: 25%; height: 36px;" rowspan="2"><span class="input-variable input-koordinatorPeikologi" name="koordinatorPeikologi" contentEditable="true">{{koordinatorPeikologi}}</span></td></tr><tr style="height: 18px;"><td style="width: 13.4298%; height: 18px;">Pemeriksa</td><td style="width: 30.6473%; height: 18px;"><span class="input-variable input-pemeriksa" name="pemeriksa" contentEditable="true">{{pemeriksa}}</span></td></tr></tbody></table><p>&nbsp;</p><table style="height: 456px; width: 100%; border-collapse: collapse; border-style: none;" border="1"><tbody><tr style="height: 18px;"><td style="width: 14.3526%; height: 18px;" colspan="2"><strong>Penampilan</strong></td></tr><tr style="height: 18px;"><td style="width: 14.3526%; height: 18px;">Keadaan Kulit</td><td style="border: 1px solid; border-collapse: collapse; height: 18px;"><p><span class="input-variable input-keadaanKulit" name="keadaanKulit" contentEditable="true">{{keadaanKulit}}</span></p><p><span style="font-size: 10pt;">(Bersih, Kotor, Penyakit Kulit, Luka / Bekas Luka)</span></p></td></tr><tr style="height: 18px;"><td style="width: 14.3526%; height: 18px;">Bentuk Tubuh</td><td style="width: 19.4491%; height: 18px;"><p><span class="input-variable input-bentukTubuh" name="bentukTubuh" contentEditable="true">{{bentukTubuh}}</span></p><p><span style="font-size: 10pt;">(Gemuk, Sedang, Kurus)</span></p></td></tr><tr style="height: 18px;"><td style="width: 14.3526%; height: 18px;">Tinggi Badan</td><td style="width: 19.4491%; height: 18px;"><p><span class="input-variable input-tinggiBadan" name="tinggiBadan" contentEditable="true">{{tinggiBadan}}</span></p><p><span style="font-size: 10pt;">(Tinggi, Sedang, Pendek, Stunting)</span></p></td></tr><tr style="height: 18px;"><td style="width: 14.3526%; height: 18px;">Pakaian</td><td style="width: 19.4491%; height: 18px;"><span class="input-variable input-pakaian" name="pakaian" contentEditable="true">{{pakaian}}</span><br /><span style="font-size: 10pt;">(Rapi, Kotor, Srampangan, Sederhana, Serasi, Mewa, Bersih, Biasa)</span></td></tr><tr style="height: 18px;"><td style="width: 14.3526%; height: 18px;" colspan="2"><strong>Sikap</strong></td></tr><tr style="height: 18px;"><td style="width: 14.3526%; height: 18px;">Tindakan</td><td style="width: 19.4491%; height: 18px;"><p><span class="input-variable input-tindakan" name="tindakan" contentEditable="true">{{tindakan}}</span></p><p>(Sopan, Tegas, Ramah, Garang, Percaya diri, Kaku, Sulit Fokus, Kurang tahu aturan, Ceroboh, Tertekan, Dibuat-buat, Ragu-ragu, Malu-malu, Kontak Mata, Tidak bisa diam)</p></td></tr><tr style="height: 18px;"><td style="width: 14.3526%; height: 18px;"><strong>Penyampaian</strong></td><td style="width: 19.4491%; height: 18px;">&nbsp;</td></tr><tr style="height: 18px;"><td style="width: 14.3526%; height: 18px;">Ekspresi</td><td style="width: 19.4491%; height: 18px;"><p><span class="input-variable input-expresi" name="expresi" contentEditable="true">{{expresi}}</span></p><p><span style="font-size: 10pt;">(Tertutup, Terbuka, Mudah, Hati-hati, Dingin / datar, Membatasi diri, Sukar mencari kata-kata, Tenang, Gugup, Takut, Lancar, Banyak gerak dan isyarat</span></p></td></tr><tr style="height: 18px;"><td style="width: 14.3526%; height: 18px;">Penggunaan Kata</td><td style="width: 19.4491%; height: 18px;"><p><span class="input-variable input-penggunaanKata" name="penggunaanKata" contentEditable="true">{{penggunaanKata}}</span></p><p><span style="font-size: 10pt;">(Dengan tekanan suara, Terpengaruh bahasa daerah, Disertai istilah bahasa asing, Biasa)</span></p></td></tr><tr style="height: 46px;"><td style="width: 14.3526%; height: 46px;" colspan="2"><strong>Mood</strong></td></tr><tr style="height: 46px;"><td style="width: 14.3526%; height: 46px;">Afek</td><td style="width: 19.4491%; height: 46px;"><p><span class="input-variable input-afek" name="afek" contentEditable="true">{{afek}}</span></p><p><span style="font-size: 10pt;">(Euthymic, Manik, Depresif)</span></p></td></tr><tr style="height: 46px;"><td style="width: 14.3526%; height: 46px;">Ekspresi Afektif</td><td style="width: 19.4491%; height: 46px;"><p><span class="input-variable input-ekspresi afektif" name="ekspresi afektif" contentEditable="true">{{ekspresi afektif}}</span></p><p><span style="font-size: 10pt;">(Normal, Terbatas, Tumpul, Datar)</span></p></td></tr><tr style="height: 46px;"><td style="width: 14.3526%; height: 46px;">Kesesuaian</td><td style="width: 19.4491%; height: 46px;"><p><span class="input-variable input-kesesuaian" name="kesesuaian" contentEditable="true">{{kesesuaian}}</span></p><p><span style="font-size: 10pt;">(Sesuai, Tidak Sesuai)</span></p></td></tr><tr style="height: 46px;"><td style="width: 14.3526%; height: 46px;">Empati</td><td style="width: 19.4491%; height: 46px;"><p><span class="input-variable input-empati" name="empati" contentEditable="true">{{empati}}</span></p><p><span style="font-size: 10pt;">(Bisa, Tidak Bisa)</span></p></td></tr><tr style="height: 46px;"><td style="width: 14.3526%; height: 46px;"><strong>Symtomps</strong></td><td style="width: 19.4491%; height: 46px;"><p><span class="input-variable input-symtomps" name="symtomps" contentEditable="true">{{symtomps}}</span></p></td></tr></tbody></table><p><strong>(T)opics</strong></p><table style="border-collapse: collapse; width: 100%;" border="1"><tbody><tr><td style="width: 100%;"><span class="input-variable input-topics" name="topics" contentEditable="true">{{topics}}</span></td></tr></tbody></table><p>&nbsp;</p><p><strong>(I)ntervention:</strong></p><table style="border-collapse: collapse; width: 100%;" border="1"><tbody><tr><td style="width: 100%;"><span class="input-variable input-intervention" name="intervention" contentEditable="true">{{intervention}}</span></td></tr></tbody></table><p>&nbsp;</p><p><strong>(P)lans &amp; Progresses :</strong></p><table style="border-collapse: collapse; width: 100%;" border="1"><tbody><tr><td style="width: 100%;"><span class="input-variable input-plans" name="plans" contentEditable="true">{{plans}}</span></td></tr></tbody></table><p>&nbsp;</p><p><strong>(S)pecial Issues :&nbsp;</strong></p><table style="border-collapse: collapse; width: 100%;" border="1"><tbody><tr><td style="width: 100%;"><span class="input-variable input-specialIssues" name="specialIssues" contentEditable="true">{{specialIssues}}</span></td></tr></tbody></table><p>&nbsp;</p>       ';
                                                    preg_match_all('/{{(.*?)}}/', $konten, $variable);

                                                    $a = array_unique($variable[0]);
                                                    foreach ($a as $item) {
                                                        $b = preg_replace('/{{(.*?)}}/is', "$1", $item);
                                                        if (strtolower(substr($b, 0, 9)) == 'loop_list') {
                                                            $konten = str_ireplace($item, '<span class="input-list input-' . $b . '" name="' . $b . '">' . $item . '</span>', $konten);
                                                        } else {
                                                            $konten = str_ireplace($item, '<span class="input-variable input-' . $b . '" name="' . $b . '" contentEditable="true">' . $item . '</span>', $konten);
                                                        }

                                                        $id_table = rand();
                                                        $konten = str_replace('<table class="editablecontent"', '<a href="#" onclick="addRow(' . $id_table . ')">[add row]</a><a href="#" onclick="deleteRow(' . $id_table . ')">[delete row]</a><table contenteditable="true" id="' . $id_table . '"', $konten);
                                                    }
                                                    echo $konten;
                                                    ?>
                                                </div>
                                                <textarea name="konten" id="konten" readonly hidden></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </main>
                            </body>
                        </div>
                    </div>
                    <input type="button" class="previous action-button-previous btn btn-primary" value="Kembali" />
                    <input type="button" class="next action-button btn btn-primary" value="Priview" id="next2" />
                </fieldset>
                <fieldset>
                    <div class="form-card">
                        <div class="form-group">

                            <body data-editor="DecoupledDocumentEditor" data-collaboration="false">
                                <main>
                                    <div class="centered">
                                        <div class="scroll-area">
                                            <div class="row-editor">
                                                <div class="form-control editor">
                                                    <?php
                                                    //replace contenteditable dan tombol tabel
                                                    $konten = str_replace('[add row]', '', $konten);
                                                    $konten = str_replace('[delete row]', '', $konten);
                                                    //hilangkan semua variable
                                                    $konten = preg_replace('/{{(.*?)}}/', '', $konten); ?>
                                                    <div id="last-priview"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </main>
                            </body>
                        </div>
                        <span id="msgbox"></span>
                    </div>
                    <input type="button" name="previous" class="previous action-button-previous btn btn-primary" value="Kembali" />
                    <input type="submit" class="btn btn-primary" id="submit" value="Save" />
                </fieldset>
            </div>
            <!-- /.card-body -->
        </form>
    </div>
    <!-- /.card -->
</div>
<script src="{{ asset('adminlte') }}/vendor/phpunit/php-code-coverage/src/Report/Html/Renderer/Template/js/jquery.min.js"></script>
<script src="{{ asset('source') }}/js/wizard.js"></script>
<script src="{{ asset('source') }}/js/main.js"></script>
<script src="{{ asset('adminlte') }}/assets/adminlte/plugins/moment/moment.min.js"></script>
<!-- date-range-picker -->
<script src="{{ asset('adminlte') }}/assets/adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="{{ asset('source') }}/js/replacetemplate.js"></script>
@endsection