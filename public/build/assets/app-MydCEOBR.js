import"./bootstrap-6btFlK5R.js";let e=$("#create-spin"),o=$("#history-container"),s=$("#spin-history"),r=t=>{switch(console.log(t),t.response.status){case 404:case 409:alert(window.app.messages.lp_expired),window.location=window.app.url.home;break}};$(document).ready(function(){e.on("click",function(){let t=e.data("url");e.attr("disabled",!0),axios.post(t,{}).then(a=>{o.html(a.data.result)}).catch(r).then(()=>{e.attr("disabled",!1)})}),s.on("click",function(t){t.preventDefault();let a=$(this).attr("href");axios.get(a).then(n=>{o.html(n.data.result)}).catch(r)})});