let email = document.querySelector(".email");
let password = document.querySelector(".password");
let submit = document.querySelector(".submit");
let message = document.querySelector(".message");
let url = window.location.origin;

submit.addEventListener("click", function(e){
e.preventDefault();
    let formData = new FormData();
    formData.append("email", email.value)
    formData.append("password", password.value)
    formData.append('_token', token)
      let sendlink =  `${url}/signin`
      axios.post(sendlink, formData).then(res=>{
      if(res.data.success){
          message.innerText = res.data.success
          window.location.href = `${url}`
          }
          }).catch(err=>{
              let error = err.response.data.errors

              if(error.email){
                  message.innerText =  error.email[0]
              }else{
                  message.innerText =  error.password[0]
              }
          })
})
