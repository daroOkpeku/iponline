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
<section class="w-full flex flex-col ">

    <article class="w-full px-4">
        <div class="w-4/6 sm:w-4/6 md:w-1/6 lg:w-1/6 float-right ">
            <ul class="w-full flex flex-row item-center py-2">
                <li class="w-full text-center cursor-pointer"><a href="{{ route('admindashbord') }}"  class="alllinks">dashboard</a></li>
                <li class="w-full text-center cursor-pointer"><a href="{{ route('adminproducts') }}"  class="alllinks">product</a></li>
                </ul>
            </div>
    </article>

    <article class="w-full px-3">
        <section class="w-10/12 sm:w-10/12 md:w-1/3 lg:w-1/3 float-right">
        <div class="w-full flex flex-row items-centers">
        <section class="w-11/12">
        <input type="text" class="w-full py-2 rounded-sm border outline-none p-2 textsearch" placeholder="please search for category or price"/>
        </section>
        <button class="w-20 bg-blue-300 text-white rounded-sm search">search</button>

        </div>
        </section>
    </article>

    <section class="w-full overflow-x-scroll sm:w-full sm:overflow-x-scroll md:w-full md:overflow-x-scroll lg:w-full lg:overflow-x-hidden">

        <table class=" w-11/12 sm:w-11/12 md:w-10/12 lg:w-10/12 m-auto rounded-sm mt-20">

            <thead>
                <tr class="text-xs sm:text-xs md:text-sm lg:text-base border-b border-black uppercase">
                <th>Number</th>
           <th>image</th>
            <th>product</th>
            <th>category</th>
            <th>price</th>
             </tr>
            </thead>

            <tbody class="inside text-xs sm:text-xs md:text-sm lg:text-base ">
               {{--  <tr>
                <td class="text-center font-semibold text-base">1</td>
                <td class="grid place-items-center">
                    <span class="w-10 h-10 rounded-full">
                        <img src="" class="w-full h-full" />
                    </span>
                </td>
                <td class="text-center font-medium text-base">zbxvbx</td>
                <td class="text-center font-medium text-base">zjzhz</td>
                <td class="text-center font-medium text-base">zzbjzb</td>
                <td class="text-center font-medium text-base">zhjjhz</td>
                <td class="text-center font-medium text-base">xghhjxhj</td>
               </tr>  --}}

            </tbody>


        </table>
    </section>


    <div class="w-full px-7">

        <section class="w-1/2 sm:w-1/2 md:w-2/12 lg:w-2/12 float-right mt-5">
            <div class="w-full flex flex-row item-center justify-between">
              <button class="w-1/3 bg-blue-400 text-white py-2 prev"><</button>
              <span class="grid place-items-center current-number">1</span>
              <button class="w-1/3 bg-blue-400 text-white py-2 next">></button>
            </div>
        </section>
    </div>


</section>
</body>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    let lastnamber = "";
    let inside = document.querySelector(".inside");
    let current = document.querySelector(".current-number")
    let next = document.querySelector(".next")
    let prev = document.querySelector(".prev")
    let search = document.querySelector(".search")
    let textsearch = document.querySelector(".textsearch")
    let url = window.location.origin
    let sendlink =  `${url}/admin/allproduct/`+1
    axios.get(sendlink).then(res=>{
        console.log(res)
    if(res.data.success){

        res.data.success.data.map((item, index)=>{
            inside.innerHTML += `   <tr>
                <td class="text-center font-semibold text-base">${index + 1}</td>
                <td class="grid place-items-center">
                    <span class="w-10 h-10 rounded-full">
                        <img src="${item.image}" class="w-full h-full" />
                    </span>
                </td>
                <td class="text-center font-thin text-base">${item.title}</td>
                <td class="text-center font-thin text-base">${item.category}</td>
                <td class="text-center font-thin text-base">${item.price}</td>
               </tr>`;
        })

        lastnamber = res.data.success.last_page


        }
        })

        next.addEventListener("click", function(e){
            e.preventDefault();

            if(current.innerText == lastnamber){
                inside.innerHTML = ``;
                current.innerText = 1
                let sendlink =  `${url}/admin/allproduct/`+parseInt(current.innerText)
                axios.get(sendlink).then(res=>{
                if(res.data.success){
           res.data.success.data.map((item, index)=>{
            inside.innerHTML += `   <tr>
                <td class="text-center font-semibold text-base">${index + 1}</td>
                <td class="grid place-items-center">
                    <span class="w-10 h-10 rounded-full">
                        <img src="${item.image}" class="w-full h-full" />
                    </span>
                </td>
                <td class="text-center font-thin text-base">${item.title}</td>
                <td class="text-center font-thin text-base">${item.category}</td>
                <td class="text-center font-thin text-base">${item.price}</td>
               </tr>`;
        })

        lastnamber = res.data.success.last_page


        }
        })

            }else{
                inside.innerHTML = ``;
                current.innerText = parseInt(current.innerText) + 1
                let sendlink =  `${url}/admin/allproduct/`+parseInt(current.innerText)
                axios.get(sendlink).then(res=>{
                    console.log(res)
                if(res.data.success){

                    res.data.success.data.map((item, index)=>{
                        inside.innerHTML += `   <tr>
                            <td class="text-center font-semibold text-base">${index + 1}</td>
                            <td class="grid place-items-center">
                                <span class="w-10 h-10 rounded-full">
                                    <img src="${item.image}" class="w-full h-full" />
                                </span>
                            </td>
                            <td class="text-center font-thin text-base">${item.title}</td>
                            <td class="text-center font-thin text-base">${item.category}</td>
                            <td class="text-center font-thin text-base">${item.price}</td>
                           </tr>`;
                    })

                    lastnamber = res.data.success.last_page


                    }
                    })



            }
        })

        prev.addEventListener("click", function(e){
            e.preventDefault();

            if(current.innerText == lastnamber){
                inside.innerHTML = ``;
                current.innerText = parseInt(current.innerText) - 1

                let sendlink =  `${url}/admin/allproduct/`+parseInt(current.innerText)
                axios.get(sendlink).then(res=>{
                    console.log(res)
                if(res.data.success){

                    res.data.success.data.map((item, index)=>{
                        inside.innerHTML += `   <tr>
                            <td class="text-center font-semibold text-base">${index + 1}</td>
                            <td class="grid place-items-center">
                                <span class="w-10 h-10 rounded-full">
                                    <img src="${item.image}" class="w-full h-full" />
                                </span>
                            </td>
                            <td class="text-center font-thin text-base">${item.title}</td>
                            <td class="text-center font-thin text-base">${item.category}</td>
                            <td class="text-center font-thin text-base">${item.price}</td>
                           </tr>`;
                    })

                    lastnamber = res.data.success.last_page


                    }
                    })



            }else{
                current.innerText = 2
                inside.innerHTML = ``;
                let sendlink =  `${url}/admin/allproduct/`+parseInt(current.innerText)
                axios.get(sendlink).then(res=>{
                if(res.data.success){

                    res.data.success.data.map((item, index)=>{
                        inside.innerHTML += `   <tr>
                            <td class="text-center font-semibold text-base">${index + 1}</td>
                            <td class="grid place-items-center">
                                <span class="w-10 h-10 rounded-full">
                                    <img src="${item.image}" class="w-full h-full" />
                                </span>
                            </td>
                            <td class="text-center font-thin text-base">${item.title}</td>
                            <td class="text-center font-thin text-base">${item.category}</td>
                            <td class="text-center font-thin text-base">${item.price}</td>

                           </tr>`;
                    })

                    lastnamber = res.data.success.last_page


                    }
                    })
            }
        })



        search.addEventListener("click", function(e){
            e.preventDefault();
            inside.innerHTML = ``;
            if(textsearch.value.length > 0){
                let sendlink =  `${url}/admin/searchproduct/`+textsearch.value
                axios.get(sendlink).then(res=>{
                    console.log(res)
                if(res.data.success){

                    res.data.success.map((item, index)=>{
                        inside.innerHTML += `   <tr>
                            <td class="text-center font-semibold text-base">${index + 1}</td>
                            <td class="grid place-items-center">
                                <span class="w-10 h-10 rounded-full">
                                    <img src="${item.image}" class="w-full h-full" />
                                </span>
                            </td>
                            <td class="text-center font-thin text-base">${item.title}</td>
                            <td class="text-center font-thin text-base">${item.category}</td>
                            <td class="text-center font-thin text-base">${item.price}</td>

                           </tr>`;
                    })

                }else{

                    axios.get(sendlink).then(res=>{
                        console.log(res)
                    if(res.data.success){

                        res.data.success.data.map((item, index)=>{
                            inside.innerHTML += `   <tr>
                                <td class="text-center font-semibold text-base">${index + 1}</td>
                                <td class="grid place-items-center">
                                    <span class="w-10 h-10 rounded-full">
                                        <img src="${item.image}" class="w-full h-full" />
                                    </span>
                                </td>
                                <td class="text-center font-thin text-base">${item.title}</td>
                                <td class="text-center font-thin text-base">${item.category}</td>
                                <td class="text-center font-thin text-base">${item.price}</td>
                               </tr>`;
                        })

                        lastnamber = res.data.success.last_page


                        }
                        })




                }
            })
            }else if(textsearch.value.length == 0){
                axios.get(sendlink).then(res=>{
                    console.log(res)
                if(res.data.success){

                    res.data.success.data.map((item, index)=>{
                        inside.innerHTML += `   <tr>
                            <td class="text-center font-semibold text-base">${index + 1}</td>
                            <td class="grid place-items-center">
                                <span class="w-10 h-10 rounded-full">
                                    <img src="${item.image}" class="w-full h-full" />
                                </span>
                            </td>
                            <td class="text-center font-thin text-base">${item.title}</td>
                            <td class="text-center font-thin text-base">${item.category}</td>
                            <td class="text-center font-thin text-base">${item.price}</td>
                           </tr>`;
                    })

                    lastnamber = res.data.success.last_page


                    }
                    })
            }

        })


        textsearch.addEventListener("input", function(e){
            e.preventDefault()
           if(e.target.value.length == 0){

            axios.get(sendlink).then(res=>{
                console.log(res)
            if(res.data.success){

                res.data.success.data.map((item, index)=>{
                    inside.innerHTML += `   <tr>
                        <td class="text-center font-semibold text-base">${index + 1}</td>
                        <td class="grid place-items-center">
                            <span class="w-10 h-10 rounded-full">
                                <img src="${item.image}" class="w-full h-full" />
                            </span>
                        </td>
                        <td class="text-center font-thin text-base">${item.title}</td>
                        <td class="text-center font-thin text-base">${item.category}</td>
                        <td class="text-center font-thin text-base">${item.price}</td>
                       </tr>`;
                })

                lastnamber = res.data.success.last_page


                }
                })

           }

        })




</script>
</html>
