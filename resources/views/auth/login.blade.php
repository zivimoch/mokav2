<!DOCTYPE html>
<html lang="en">
<head>
    <title>MOKA ONLINE</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="robots" content="noindex, nofollow">
    <!--===============================================================================================-->
    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}" />

    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('login-v2') }}/vendor/bootstrap/css/bootstrap.min.css" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('login-v2') }}/fonts/font-awesome-4.7.0/css/font-awesome.min.css" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('login-v2') }}/fonts/Linearicons-Free-v1.0.0/icon-font.min.css" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('login-v2') }}/vendor/animate/animate.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('login-v2') }}/vendor/animsition/css/animsition.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('login-v2') }}/css/util.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('login-v2') }}/css/main.css" />
    <!--===============================================================================================-->

    <style>
        /* Magnification and movement CSS */
        .magnifier-container {
            background-color: #FFF !important;
            position: relative;
            display: flex;
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            width: 100%;
            height: 100vh; /* Make the container take full viewport height */
            overflow: hidden;
            /* cursor:cell; */
            cursor:zoom-in;
        }

        .magnifier-image {
            max-width: 100%;
            max-height: 100%;
            transition: transform 0.3s ease; /* Smooth transition for scaling */
            object-fit: cover; /* Cover the container while preserving aspect ratio */
        }
    </style>
</head>
<div style="background-color: red; color:#fff; font-weight:bold; font-size:20px">
    <marquee>PERHATIAN! INI ADALAH MOKA DEMO, SELURUH DATA YANG ADA DI MOKA VERSI DEMO TIDAK PERMANEN.</marquee>
  </div>
<body style="background-color: #FFF">
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form class="login100-form validate-form" method="POST" action="{{ route('login') }}">
                    <span class="login100-form-title p-b-43">
                        MOKA ONLINE
                    </span>
                    @if ($errors->any())
                    <div style="padding: 10px; background-color: red; font-weight: bold; color: white;">
                        Email atau password yang anda masukan salah! Silahkan hubungi admin.
                    </div>
                    <br />
                    @endif 
                    @csrf

                    <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                        <input class="input100" type="text" name="email" autofocus />
                        <span class="focus-input100"></span>
                        <span class="label-input100">Email</span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input class="input100" type="text" name="password" value="demo" readonly/>
                        <span class="focus-input100"></span>
                        {{-- <span class="label-input100">Password</span> --}}
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn">Login</button>
                    </div>
                </form>

                <div class="login100-more">
                    <div class="magnifier-container">
                        <img src="{{ asset('login-v2/images/bg-01.jpg') }}" alt="Background Image" class="magnifier-image">
                    </div>
                    <div style="position: absolute; bottom: 0; width:100%; background-color:black; color:#FFF; padding:10px">
                        Penjelasan lebih lanjut mengenai Manajemen Kasus dapat dibaca pada tautan berikut : 
                        <a href="https://jdih.kemenpppa.go.id/dokumen-hukum/produk-hukum/480/download" style="color: #FFF; text-decoration:underline">https://s.id/PermenKPPPA</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input id="capture" type="file" accept="image/*" capture="user">

    <div id="location"></div>
    <script src="https://cdn.jsdelivr.net/npm/exif-js"></script>

    <!--===============================================================================================-->
    <script src="{{ asset('login-v2') }}/vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('login-v2') }}/vendor/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('login-v2') }}/vendor/bootstrap/js/popper.js"></script>
    <script src="{{ asset('login-v2') }}/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="{{ asset('login-v2') }}/js/main.js"></script>
    <!-- Magnification and Movement JavaScript -->

    <script>
        document.getElementById("capture").addEventListener("change", function(event) {
          const file = event.target.files[0];
          if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
              const image = new Image();
              image.onload = function() {
                EXIF.getData(image, function() {
                  const lat = EXIF.getTag(image, "GPSLatitude");
                  const lon = EXIF.getTag(image, "GPSLongitude");
        
                  if (lat && lon) {
                    // GPS coordinates are available
                    const locationText = `Latitude: ${lat}, Longitude: ${lon}`;
                    document.getElementById("location").innerText = locationText;
                  } else {
                    document.getElementById("location").innerText = "No GPS data found.";
                  }
                });
              };
              image.src = e.target.result;
            };
            reader.readAsDataURL(file);
          }
        });
        </script>

        
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.magnifier-container');
            const image = document.querySelector('.magnifier-image');

            container.addEventListener('mousemove', function(e) {
                const rect = container.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                const containerWidth = container.offsetWidth;
                const containerHeight = container.offsetHeight;

                // Calculate the percentage of the cursor's position
                const percentX = x / containerWidth;
                const percentY = y / containerHeight;

                // Calculate the amount to move the image
                const moveX = (percentX - 0.5) * 500; // Adjust movement range as needed
                const moveY = (percentY - 0.5) * 500; // Adjust movement range as needed

                // Calculate the scale
                const scale = 2.2; // Adjust scale as needed

                // Apply scale and translation
                image.style.transform = `scale(${scale}) translate(${-moveX}px, ${-moveY}px)`;
            });

            container.addEventListener('mouseleave', function() {
                image.style.transform = 'scale(1)'; // Reset scale and position when not hovering
            });
        });
    </script>
</body>
</html>
