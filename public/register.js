let message = document.querySelector(".message");
let name = document.querySelector(".name");
let email = document.querySelector(".email");
let password = document.querySelector(".password");
let password_confirmation = document.querySelector(".password_confirmation");
let submit = document.querySelector(".submit");

let url = window.location.origin;
submit.addEventListener("click", function(e){
    e.preventDefault();

           let formData = new FormData();
          formData.append("name", name.value)
          formData.append("email", email.value)
          formData.append("password", password.value)
          formData.append("password_confirmation", password_confirmation.value)
          formData.append('_token', token)
            let sendlink =  `${url}/register`
            axios.post(sendlink, formData).then(res=>{
            if(res.data.success){
                message.innerText = res.data.success
                }
                }).catch(err=>{
                    let error = err.response.data.errors

                    if(error.email){
                        message.innerText =  error.email[0]
                    }else if(error.name){
                        message.innerText =  error.name[0]
                    }else if(errror.password){
                        message.innerText =  error.password[0]
                    }
                })


})
