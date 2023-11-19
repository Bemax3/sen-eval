import{T as u,o as _,c as f,a as e,h as p,g as t,f as a,u as o,k as i}from"./app-009e6676.js";import{_ as g}from"./logo1637145113-11387d37.js";import{_ as r}from"./TextInput-4ed6148e.js";import{_ as d}from"./InputLabel-00850faa.js";import{_ as c}from"./InputError-db0f38c0.js";const h={class:"flex items-center min-h-screen p-6 bg-gray-50"},x={class:"flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl"},w={class:"flex flex-col overflow-y-auto md:flex-row"},v=e("div",{class:"h-20 md:h-auto md:w-1/3 flex items-center justify-center"},[e("img",{alt:"","aria-hidden":"true",class:"object-cover w-30 h-30 alt=Office",src:g})],-1),b={class:"flex items-center justify-center flex-col p-12 sm:p-12 md:w-2/3"},y=e("h1",{class:"mb-4 font-bold text-3xl text-cyan-900"}," Système d'Évaluation ",-1),V={class:"w-full mt-4"},k=["onSubmit"],j={class:"mt-2"},B={class:"mt-2"},L=e("hr",{class:"my-8"},null,-1),N=["disabled"],F={__name:"Login",setup(S){const s=u({user_login:"",password:""}),m=()=>{s.post(route("login"),{onFinish:()=>s.reset("password")})};return($,l)=>(_(),f("div",h,[e("div",x,[e("div",w,[v,e("div",b,[y,e("div",V,[e("form",{class:"mb-0 space-y-6",onSubmit:p(m,["prevent"])},[e("div",null,[t(d,{for:"login"},{default:a(()=>[i("Login")]),_:1}),e("div",j,[t(r,{id:"user_login",modelValue:o(s).user_login,"onUpdate:modelValue":l[0]||(l[0]=n=>o(s).user_login=n),invalid:o(s).errors.user_login!==void 0,autofocus:"",placeholder:"Login"},null,8,["modelValue","invalid"])]),t(c,{message:o(s).errors.user_login},null,8,["message"])]),e("div",null,[t(d,{for:"login"},{default:a(()=>[i("Mot de Passe")]),_:1}),e("div",B,[t(r,{id:"password",modelValue:o(s).password,"onUpdate:modelValue":l[1]||(l[1]=n=>o(s).password=n),invalid:o(s).errors.password!==void 0,placeholder:"********",type:"password"},null,8,["modelValue","invalid"])]),t(c,{message:o(s).errors.password},null,8,["message"])]),L,e("button",{disabled:o(s).processing,class:"block w-full px-4 py-2 mt-4 text-lg font-medium leading-5 text-center text-white transition-colors duration-150 bg-cyan-600 border border-transparent rounded-lg active:bg-cyan-600 hover:bg-cyan-700 focus:outline-none focus:shadow-outline-cyan"}," Connexion ",8,N)],40,k)])])])])]))}};export{F as default};
