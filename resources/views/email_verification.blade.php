<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="w-full flex flex-row items-center justify-center">

<section class="w-3/4 flex flex-col items-center justify-center mt-20">
   

<h2 class="text-lg capitalize text-center text-black email">Please Wait ...</h2>

    {{--  <h2 class="text-lg capitalize text-center text-black">This email has been verifield</h2>  --}}


    <button class="w-1/2 bg-blue-300 text-white rounded-sm py-2 text-center page mt-8">Please Wait...</button>
 {{--  <a href="{{ route('login') }}"> </a>  --}}

 {{--  <a href="{{ route('home') }}"> <button class="w-1/3 rounded-sm py-2 text-center">Back Home</button></a>  --}}
   


</section>

</div>
</body>
<script>
    let status = @json($status??"");
    let email = document.querySelector(".email");
    let page = document.querySelector(".page");
    let url = window.location.origin;
    if(status == 1){
        page.innerText = "Login Page"
        email.innerText = "your email has been verifield"
        page.addEventListener("click", function(e){
            e.preventDefault();
          window.location.href="{{ route('login') }}"
        })
    }else{

        page.innerText = "Back Home"
        email.innerText = "This email has been verifield"
        page.addEventListener("click", function(e){
            e.preventDefault();
          window.location.href="{{ route('home') }}"
        })

    }

</script>
</html>
