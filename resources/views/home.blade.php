<!DOCTYPE html>
<html>
    <head>
        <title>home</title>
        {{--  <link
        rel="stylesheet"
        href="{{ asset('fontawesome-free-5.12.0-web/css/all.css') }}"
      />  --}}

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="{{ asset('main.css') }}">

        <script src="https://js.paystack.co/v1/inline.js"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
          <script src="https://cdn.tailwindcss.com"></script>
        </head>
        <body>
       <nav class="navbar">
         <div class="navbar-center">
           <span class="nav-icon">
             <i class="fas fa-bars"></i>
           </span>

           {{--  @if(session('userdetail'))
           {{ session('userdetail')->email }}
           @endif  --}}

           <h4 class="text-base capitalize text-white username">Daro Stephen</h4>


           <article class="w-1/12 float-right flex  flex-row items-center justify-between">
            <div class="cart-btn">
                <span class="nav-icon">
                  <i class="fas fa-cart-plus"></i>
                </span>
                <div class="cart-items">0</div>
              </div>
               @if(session('userdetail'))
               <span class="nav-icon">
                   <a href="{{ route('logout') }}">
                    <i class="fas fa-sign-out" aria-hidden="true"></i>
                   </a>

               </span>
               @else
               <span class="nav-icon">
                <a href="{{ route('login') }}">
                    <i class="fas fa-sign-in" aria-hidden="true"></i>
                </a>
               </span>
    @endif
        </article>

         </div>
       </nav>

       <header class="hero">
         <div class="banner">
           <h1 class="banner-title">view our products</h1>
           <button class="banner-btn">shop now</button>
         </div>
       </header>

      <section class="products">
        <div class="section-title">
          <h2>product</h2>
        </div>
        <div class="products-center">


        </div>
      </section>
       <div class="cart-overlay">
         <div class="cart">
           <span class="close-cart">
             <i class="fas fa-window-close"></i>
           </span>
           <h2>your cart</h2>
           <h3 class="cartmessage"></h3>
           <div class="cart-content">

           </div>
           <div class="cart-footer">
             <h3>your total &#x20A6; <span class="cart-total">0</span></h3>
             <button class="clear-cart banner-btn">Purchase Now</button>
           </div>
          </div>
       </div>


        </body>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script>
            let email = @json(session('userdetail')->email??"");
            let userid = @json(session('userdetail')->id??"");
            let name = @json(session('userdetail')->name??"");
            var  token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
           //let all =   @json(session('userdetail'));
           let username = document.querySelector(".username");
           if(name){
            username.innerText = name
           }else{
            username.innerText = ""
           }

        </script>
        <script defer src="{{ asset('jumia.js') }}"></script>
</html>
