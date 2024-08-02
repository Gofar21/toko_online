<!DOCTYPE html>
<html lang="en">
  <head>
    <title>HM Konveksi &mdash; Toko konveksi </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700"> 
    <link rel="stylesheet" href="{{ asset('shopper') }}/fonts/icomoon/style.css">

    <link rel="stylesheet" href="{{ asset('shopper') }}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('shopper') }}/css/magnific-popup.css">
    <link rel="stylesheet" href="{{ asset('shopper') }}/css/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('shopper') }}/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ asset('shopper') }}/css/owl.theme.default.min.css">


    <link rel="stylesheet" href="{{ asset('shopper') }}/css/aos.css">

    <link rel="stylesheet" href="{{ asset('shopper') }}/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />

    <style>
      .logo {
        width: 30%;
      }
      @media (max-width: 767px) {
        .logo {
          width: 10%;
        }
      }
  
      #chat-widget {
          display: none;
          flex-direction: column;
          width: 400px;
          height: 450px;
          border: 1px solid #ccc;
          border-radius: 10px;
          overflow: hidden;
          position: fixed;
          bottom: 10px;
          right: 10px;
          background: #fff;
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }
      @media (max-width: 600px) {
          #chat-widget {
              width: 90%; 
              height: 70%;
              right: 5%;
              bottom: 5%;
          }
      }
      #chat-header {
          background: #704401;
          color: #fff;
          padding: 10px;
          display: flex;
          justify-content: space-between;
          align-items: center;
      }
      #chat-body {
          flex: 1;
          padding: 10px;
          overflow-y: auto;
          display: flex;
          flex-direction: column;
      }
      #chat-footer {
          display: flex;
          border-top: 1px solid #ccc;
          padding: 10px;
      }
      #chat-input {
          flex: 1;
          padding: 10px;
          border: 1px solid #ccc;
          border-radius: 5px;
      }
      #send-button {
          background: #704401;
          color: #fff;
          border: none;
          padding: 10px;
          border-radius: 5px;
          margin-left: 10px;
          cursor: pointer;
      }
      .message {
          margin: 5px 0;
          padding: 10px;
          border-radius: 5px;
          max-width: 80%;
      }
      .message.user {
          align-self: flex-end;
          background: #007bff;
          color: #fff;
      }
      .message.bot {
          align-self: flex-start;
          background: #f1f1f1;
          color: #333;
      }

      #jawabanButton{
        background-color: #ff7605; /* Warna latar belakang */
        color: #fff; /* Warna teks */
        border: none; /* Hilangkan border default */
        border-radius: 5px; /* Sudut melengkung */
        padding: 10px 20px; /* Padding di dalam tombol */
        font-size: 16px; /* Ukuran font */
        cursor: pointer; /* Tangan saat hover */
        transition: background-color 0.3s ease, box-shadow 0.3s ease; /* Transisi efek hover */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Bayangan tombol */
        outline: none; /* Hilangkan outline default saat tombol aktif */
        margin-bottom: 3px;
      }

      #jawabanButton:hover {
          background-color: #ff7605; /* Warna latar belakang saat hover */
          box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3); /* Bayangan tombol saat hover */
      }

      #jawabanButton:active {
          background-color: #ff7605; /* Warna latar belakang saat ditekan */
          box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2); /* Bayangan tombol saat ditekan */
      }

      #jawabanButton:focus {
          outline: none; /* Hilangkan outline default saat fokus */
      }

      .dots-loader {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 20px;
      }

      .dots-loader div {
        width: 6px;
        height: 6px;
        margin: 0 2px;
        background-color: #3498db;
        border-radius: 50%;
        display: inline-block;
        animation: dotsLoader 1.4s infinite both;
      }

      .dots-loader div:nth-child(1) {
        animation-delay: -0.32s;
      }

      .dots-loader div:nth-child(2) {
        animation-delay: -0.16s;
      }

      @keyframes dotsLoader {
        0%, 80%, 100% {
          transform: scale(0);
        }
        40% {
          transform: scale(1);
        }
      }

    </style>
      
  </head>
  <body>
  
    <div class="site-wrap">
      <header class="site-navbar" role="banner">
        <div class="site-navbar-top">
          <div class="container">
            <div class="row align-items-center">

              <div class="col-6 col-md-4 order-2 order-md-1 site-search-icon text-left">
                <form action="{{ route('user.produk.cari') }}" method="get" class="site-block-top-search" >
                  @csrf
                  <span class="icon icon-search2"></span>
                  <input type="text" class="form-control border-0" name="cari" placeholder="Search">
                </form>
              </div>

              <div class="col-12 mb-3 mb-md-0 col-md-4 order-1 order-md-2 text-center">
                <div class="">
                  <a href="{{ route('home') }}" class="js-logo-clone">
                    <img class="logo" src="{{ asset('shopper') }}/images/logo.png">
                  </a>
                </div>
              </div>

              <div class="col-6 col-md-4 order-3 order-md-3 text-right">
              <div class="top-right links"> 
              <div class="site-top-icons">
                <ul>
                @if (Route::has('login'))
                      @auth
                          <li>
                            <div class="dropdown">
                              <a class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <span class="icon icon-person"></span>
                              </a>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  <a class="dropdown-item" href="{{ route('user.alamat') }}">Pengaturan Alamat</a>
                                  {{-- <a class="dropdown-item" href="#">Pengaturan Akun</a> --}}
                                  <a class="dropdown-item" href="#">
                                  
                                  <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                  document.getElementById('logout-form').submit();">
                                    <i class="mdi mdi-logout mr-2 text-primary"></i> Logout 
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                              </div>
                              </div>
                          </li>
                          <li>
                            <?php
                              $user_id = \Auth::user()->id;
                              $total_keranjang = \DB::table('keranjang')
                              ->select(DB::raw('count(id) as jumlah'))
                              ->where('user_id',$user_id)
                              ->first();
                            ?>
                              <a href="{{ route('user.keranjang') }}" class="site-cart">
                              <span class="icon icon-add_shopping_cart"></span>
                              <span class="count">{{ $total_keranjang->jumlah }}</span>
                              </a>
                          </li> 
                          <li>
                          <?php
                              $user_id = \Auth::user()->id;
                              $total_order = \DB::table('order')
                              ->select(DB::raw('count(id) as jumlah'))
                              ->where('user_id',$user_id)
                              ->where('status_order_id','!=',5)
                              ->where('status_order_id','!=',6)
                              ->first();
                            ?>
                          <a href="{{ route('user.order') }}" class="site-cart">
                              <span class="icon icon-shopping_cart"></span>
                              <span class="count">{{ $total_order->jumlah }}</span>
                              </a>
                          </li>
                      @else
                      <div class="dropdown">
                              <a class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <span class="icon icon-person"></span>
                              </a>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  <a class="dropdown-item" href="{{ route('login') }}">Masuk</a>
                                  @if (Route::has('register'))
                                    <a class="dropdown-item" href="{{ route('register') }}">Daftar</a>
                                  @endif
                              </div>
                              </div>
                      @endauth
                  </div>
              @endif
              <li class="d-inline-block d-md-none ml-md-0"><a href="#" class="site-menu-toggle js-menu-toggle"><span class="icon-menu"></span></a></li>
              </div>
              </ul>
              </div> 
            </div>
          </div>
        </div> 
        <nav class="site-navigation text-right text-md-center" role="navigation">
          <div class="container">
            <ul class="site-menu js-clone-nav d-none d-md-block">
              <li class="{{ Request::path() === '/' ? '' : '' }}"><a href="{{ route('home') }}">Beranda</a></li>
              <li class="{{ Request::path() === 'produk' ? '' : '' }}"><a href="{{ route('user.produk') }}">Produk</a></li>
              <li class="{{ Request::path() === 'kontak' ? '' : '' }}"><a href="{{ route('kontak') }}">Kontak</a></li>
            </ul>
          </div>
        </nav>
      </header>

      @yield('content')
      
      {{-- <div id="botmanWidget"></div> --}}
      <button id="chat-button" onclick="toggleChat()" style="position: fixed; bottom: 20px; right: 20px; padding: 10px 20px; background: #ff7605; color: #fff; border: none; border-radius: 20%; font-size: 20px; cursor: pointer;">
        <lord-icon
            src="https://cdn.lordicon.com/wzrwaorf.json"
            trigger="hover"
            style="width:50px;height:50px">
        </lord-icon>
        Chat
      </button>
      <div id="chat-widget">
          <div id="chat-header">
            <span>HM-Bot</span>
            <button onclick="toggleChat()" style="background: transparent; border: none; color: #fff; font-size: 18px;">X</button>
          </div>

          {{-- view char --}}
          <div id="chat-body">
            <div class="message bot">
              Selamat datang di HM Konveksi😊<br>Ada yang bisa kami bantu?
              <br><br>Silahkan pilih opsi dibawah ini :
              <br>
              <button id="jawabanButton" class="jawabanButton" onclick="tanya('produk')">Produk</button>
              <button id="jawabanButton" class="jawabanButton" onclick="tanya('promo')">Promo</button>
            </div>
          </div>
          <div id="chat-loader" class="dots-loader" style="display:none;">
            <div></div>
            <div></div>
            <div></div>
          </div>  
          <div id="chat-footer">
            <input type="text" id="chat-input" placeholder="Type your message...">
            <button id="send-button" onclick="sendMessage()">Send</button>
          </div>
      </div>
  
      <footer class="site-footer border-top">
        <div class="container">
          <div class="row">
            {{-- <div class="col-lg-6 mb-5 mb-lg-0">
              <div class="row">
                <div class="col-md-12">
                  <h3 class="footer-heading mb-4">Navigations</h3>
                </div>
                <div class="col-md-6 col-lg-4">
                  <ul class="list-unstyled">
                    <li><a href="#">Sell online</a></li>
                    <li><a href="#">Features</a></li>
                    <li><a href="#">Shopping cart</a></li>
                    <li><a href="#">Store builder</a></li>
                  </ul>
                </div>
                <div class="col-md-6 col-lg-4">
                  <ul class="list-unstyled">
                    <li><a href="#">Mobile commerce</a></li>
                    <li><a href="#">Dropshipping</a></li>
                    <li><a href="#">Website development</a></li>
                  </ul>
                </div>
                <div class="col-md-6 col-lg-4">
                  <ul class="list-unstyled">
                    <li><a href="#">Point of sale</a></li>
                    <li><a href="#">Hardware</a></li>
                    <li><a href="#">Software</a></li>
                  </ul>
                </div>
              </div>
            </div> --}}
            <div class="col-md-12 col-lg-12">
              <div class="block-5 mb-5">
                <h1 class="mb-4">Contact Info</h1>
                <ul class="list-unstyled">
                  <li class="address">Jalan Welahan</li>
                  <li class="phone"><a href="tel://089677591700">+62 3392 3929 210</a></li>
                  <li class="email">abdulgofarm@gmail.com</li>
                </ul>
              </div>

              
            </div>
          </div>
        </div>
      </footer>
    


    </div>
    <script src="{{ asset('shopper') }}/js/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
    <script src="{{ asset('shopper') }}/js/jquery-ui.js"></script>
    <script src="{{ asset('shopper') }}/js/popper.min.js"></script>
    <script src="{{ asset('shopper') }}/js/bootstrap.min.js"></script>
    <script src="{{ asset('shopper') }}/js/owl.carousel.min.js"></script>
    <script src="{{ asset('shopper') }}/js/jquery.magnific-popup.min.js"></script>
    <script src="{{ asset('shopper') }}/js/aos.js"></script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>

    <script src="{{ asset('shopper') }}/js/main.js"></script>
    {{-- <script>
      var botmanWidget = {
        introMessage: "Selamat datang di HM Konveksi😊<br>Ada yang bisa kami bantu?",
        chatServer: '/botman',
        title: 'HM-Bot',
      };

      // Load BotMan Web Widget script
      (function() {
        var script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js';
        script.async = true;
        script.onload = function() {
          console.log("BotMan Web Widget loaded");

          // Define the tanya() function
          window.tanya = function() {
            console.log('iso');
            alert('hi');
          };
        };
        document.head.appendChild(script);
      })();
    </script> --}}
    <script>
      function toggleChat() {
        const widget = document.getElementById('chat-widget');
        const chatButton = document.getElementById('chat-button');
        if (widget.style.display === 'none' || widget.style.display === '') {
            widget.style.display = 'flex';
            chatButton.style.display = 'none'; // Hide the chat button
        } else {
            widget.style.display = 'none';
            chatButton.style.display = 'inline-block'; // Show the chat button
        }
    }

    function sendMessage() {
        const messageInput = document.getElementById('chat-input');
        const chatBody = document.getElementById('chat-body');
        const loader = document.getElementById('chat-loader');
        const message = messageInput.value.trim();
        if (message) {
            const messageDiv = document.createElement('div');
            messageDiv.className = 'message user';
            messageDiv.textContent = message;
            chatBody.appendChild(messageDiv);
            messageInput.value = '';

            // Tampilkan loader
            loader.style.display = 'block';

            // Kirim pesan ke server
            fetch('/dialogflow', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ message: message })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                const responseDiv = document.createElement('div');
                responseDiv.className = 'message bot';
                responseDiv.innerHTML = data.message; // Menampilkan teks HTML dari server
                chatBody.appendChild(responseDiv);
                chatBody.scrollTop = chatBody.scrollHeight;

                // Sembunyikan loader
                loader.style.display = 'none';
            })
            .catch(error => {
                console.error('Error:', error);

                // Sembunyikan loader
                loader.style.display = 'none';
            });
        }
    }

    function tanya(pesan) {
        const message = pesan;
        const chatBody = document.getElementById('chat-body');
        const loader = document.getElementById('chat-loader');
        const messageDiv = document.createElement('div');
        messageDiv.className = 'message user';
        messageDiv.textContent = message;
        chatBody.appendChild(messageDiv);

        // Tampilkan loader
        loader.style.display = 'block';

        fetch('/dialogflow', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ message: message })
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            const responseDiv = document.createElement('div');
            responseDiv.className = 'message bot';
            responseDiv.innerHTML = data.message; // Menampilkan teks HTML dari server
            chatBody.appendChild(responseDiv);
            chatBody.scrollTop = chatBody.scrollHeight;

            // Sembunyikan loader
            loader.style.display = 'none';
        })
        .catch(error => {
            console.error('Error:', error);

            // Sembunyikan loader
            loader.style.display = 'none';
        });
    }

    document.getElementById('chat-input').addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            sendMessage();
        }
    });

    </script>
  


    @yield('js')
  </body>
    
</html>