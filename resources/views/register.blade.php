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
    <section class="w-full flex flex-row items-center justify-center">


        <div class=" w-10/12 rounded-md shadow-md border mt-20 py-2  sm:w-3/4 sm:rounded-md sm:shadow-md sm:border sm:mt-20 sm:py-2 md:w-3/4 md:rounded-md md:shadow-md md:border md:mt-20 md:py-2 lg:w-2/5 lg:rounded-md lg:shadow-md lg:border lg:mt-20 lg:py-2">
            <section class="w-full flex flex-col items-center gap-6">
                <div class="w-full">
                    <article class="w-1/3 float-right">
                        <section class="w-full text-base">Register as a user<section>
                    </article>
                </div>
                <section class="w-full message capitalize text-sm text-center"> </section>


                <div class="w-11/12">
                <scction class="w-full flex flex-col items-center">
                    <span class="w-full text-left px-1 capitalize">
                        name
                    </span>
                    <input type="text" class="w-full rounded-sm outline-none border py-1 name" />
                </scction>
                </div>

                <div class="w-11/12">
                    <scction class="w-full flex flex-col items-center">
                        <span class="w-full text-left px-1 capitalize">
                            email
                        </span>
                        <input type="email" class="w-full rounded-sm outline-none border py-1 email" />
                    </scction>
                    </div>

                    <div class="w-11/12">
                        <scction class="w-full flex flex-col items-center">
                            <span class="w-full text-left px-1 capitalize">
                                password
                            </span>
                            <input type="password" class="w-full rounded-sm outline-none border py-1 password" />
                        </scction>
                        </div>


                        <div class="w-11/12">
                            <scction class="w-full flex flex-col items-center">
                                <span class="w-full text-left px-1 capitalize">
                                  confirm  password
                                </span>
                                <input type="password" class="w-full rounded-sm outline-none border py-1 password_confirmation" />
                            </scction>
                            </div>

                            <div class="w-11/12">
                              <button class="w-full capitalize bg-[#F09D5180] text-white py-2 rounded-sm submit">submit</button>
                            </div>

                            <div class="w-full">
                                <section class="w-3/5 flex flex-row items-center space-x-5  float-right">
                                <h2 class="text-sm font-semibold text-black">if you  have an account please click</h2>
                                <h2 class="text-sm font-semibold text-blue-500"><a href="{{ route('login') }}"> here</a></h2>
                                </section>
                             </div>

            </section>
        </div>
    </section>

</body>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    var  token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
</script>
<script defer src="{{ asset('register.js') }}"></script>

</html>
