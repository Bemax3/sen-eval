<<<<<<<< HEAD:public/build/assets/SetupUser-55aad259.js
import{T as a,o as n,c,a as e,h as d,g as o,f as u,u as s,k as m}from"./app-009e6676.js";import{_}from"./logo1637145113-11387d37.js";import{_ as f}from"./TextInput-4ed6148e.js";import{_ as h}from"./InputLabel-00850faa.js";import{_ as p}from"./InputError-db0f38c0.js";const x={class:"flex items-center min-h-screen p-6 bg-gray-50"},g={class:"flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl"},b={class:"flex flex-col overflow-y-auto md:flex-row"},v=e("div",{class:"h-20 md:h-auto md:w-1/3 flex items-center justify-center"},[e("img",{"aria-hidden":"true",class:"object-cover w-30 h-30 alt=Office",src:_})],-1),w={class:"flex items-center justify-center flex-col p-12 sm:p-12 md:w-2/3"},y=e("h1",{class:"mb-4 font-bold text-3xl text-cyan-900"}," Système d'Évaluation du Personnel ",-1),V=e("h1",{class:"mb-2 font-semibold text-xl text-gray-700"}," Nous ne trouvons pas votre matricule ! Veuillez le renseigner ici avant de continuer. ",-1),k={class:"w-full mt-4"},N=["onSubmit"],S={class:"mt-2"},j=e("hr",{class:"my-8"},null,-1),B=["disabled"],L={__name:"SetupUser",setup($){const t=a({user_matricule:""}),i=()=>{t.post(route("profile.setup"))};return(E,r)=>(n(),c("div",x,[e("div",g,[e("div",b,[v,e("div",w,[y,V,e("div",k,[e("form",{class:"mb-0 space-y-6",onSubmit:d(i,["prevent"])},[e("div",null,[o(h,{for:"login"},{default:u(()=>[m("Matricule")]),_:1}),e("div",S,[o(f,{id:"user_login",modelValue:s(t).user_matricule,"onUpdate:modelValue":r[0]||(r[0]=l=>s(t).user_matricule=l),invalid:s(t).errors.user_matricule!==void 0,autofocus:"",placeholder:"Login"},null,8,["modelValue","invalid"])]),o(p,{message:s(t).errors.user_matricule},null,8,["message"])]),j,e("button",{disabled:s(t).processing,class:"block w-full px-4 py-2 mt-4 text-lg font-medium leading-5 text-center text-white transition-colors duration-150 bg-cyan-600 border border-transparent rounded-lg active:bg-cyan-600 hover:bg-cyan-700 focus:outline-none focus:shadow-outline-cyan"}," Enregistrer ",8,B)],40,N)])])])])]))}};export{L as default};
========
import{T as a,o as n,c,a as e,h as d,g as o,f as u,u as s,k as m}from"./app-3e4b2772.js";import{_}from"./logo1637145113-11387d37.js";import{_ as f}from"./TextInput-6ea32040.js";import{_ as h}from"./InputLabel-57921aff.js";import{_ as p}from"./InputError-35896e53.js";const x={class:"flex items-center min-h-screen p-6 bg-gray-50"},g={class:"flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl"},b={class:"flex flex-col overflow-y-auto md:flex-row"},v=e("div",{class:"h-20 md:h-auto md:w-1/3 flex items-center justify-center"},[e("img",{"aria-hidden":"true",class:"object-cover w-30 h-30 alt=Office",src:_})],-1),w={class:"flex items-center justify-center flex-col p-12 sm:p-12 md:w-2/3"},y=e("h1",{class:"mb-4 font-bold text-3xl text-cyan-900"}," Système d'Évaluation du Personnel ",-1),V=e("h1",{class:"mb-2 font-semibold text-xl text-gray-700"}," Nous ne trouvons pas votre matricule ! Veuillez le renseigner ici avant de continuer. ",-1),k={class:"w-full mt-4"},N=["onSubmit"],S={class:"mt-2"},j=e("hr",{class:"my-8"},null,-1),B=["disabled"],L={__name:"SetupUser",setup($){const t=a({user_matricule:""}),i=()=>{t.post(route("profile.setup"))};return(E,r)=>(n(),c("div",x,[e("div",g,[e("div",b,[v,e("div",w,[y,V,e("div",k,[e("form",{class:"mb-0 space-y-6",onSubmit:d(i,["prevent"])},[e("div",null,[o(h,{for:"login"},{default:u(()=>[m("Matricule")]),_:1}),e("div",S,[o(f,{id:"user_login",modelValue:s(t).user_matricule,"onUpdate:modelValue":r[0]||(r[0]=l=>s(t).user_matricule=l),invalid:s(t).errors.user_matricule!==void 0,autofocus:"",placeholder:"Login"},null,8,["modelValue","invalid"])]),o(p,{message:s(t).errors.user_matricule},null,8,["message"])]),j,e("button",{disabled:s(t).processing,class:"block w-full px-4 py-2 mt-4 text-lg font-medium leading-5 text-center text-white transition-colors duration-150 bg-cyan-600 border border-transparent rounded-lg active:bg-cyan-600 hover:bg-cyan-700 focus:outline-none focus:shadow-outline-cyan"}," Enregistrer ",8,B)],40,N)])])])])]))}};export{L as default};
>>>>>>>> 6ba55a1 (bug fixes):public/build/assets/SetupUser-9cbdf7d3.js
