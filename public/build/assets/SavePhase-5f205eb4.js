import{b as k,o as d,e as v,f as l,T as $,g as a,u as s,Z as B,a as e,t as u,h as F,k as n,p as S,c as x,i as U,F as j,n as f,j as P}from"./app-009e6676.js";import{i as p,_ as q}from"./AuthenticatedLayout-a6827bda.js";import{_ as m}from"./InputLabel-00850faa.js";import{_ as D}from"./TextInput-4ed6148e.js";import{_ as M}from"./SubmitButton-d98e5e89.js";import{_ as h}from"./InputError-db0f38c0.js";import{_ as A}from"./Breadcrumbs-6f218844.js";import{_ as C}from"./FormIndications-fac9b7ef.js";import{_ as b}from"./NumberInput-26c6ebca.js";import{r as E}from"./ChevronUpDownIcon-99c795d4.js";import{r as T}from"./CheckIcon-44d763b6.js";import{N as z,H,B as Y,U as I}from"./listbox-7b42d9a9.js";import"./logo1637145113-11387d37.js";import"./use-controllable-a4a0a7b6.js";const L={class:"px-4 sm:px-6 lg:px-8"},O={class:"sm:flex sm:items-center"},Z={class:"sm:flex-auto"},G={class:"text-2xl font-semibold leading-6 text-gray-900"},J=e("p",{class:"mt-2 text-sm text-gray-700"},"Ajouter ou modifier une phase d'évaluation.",-1),K={class:"mt-8 flow-root"},Q=["onSubmit"],R={class:"px-4 py-6 sm:p-8"},W={class:"grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6"},X={class:"sm:col-span-4"},ee={class:"mt-2"},se={class:"col-span-full"},ae={class:"mt-2"},te={class:"flex flex-col space-y-2"},oe={class:"sm:col-span-4"},ie={class:"mt-2"},le={class:"relative mt-2"},re={class:"block truncate"},ne={class:"pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2"},de={class:"col-span-full"},pe={class:"mt-2"},me={class:"flex flex-col space-y-2"},_e={class:"flex items-center justify-between gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8"},Fe={__name:"SavePhase",props:{phase:{type:Object,default:{}},types:{type:Array}},setup(_){const i=_;let t;const w=k(()=>p(i.phase)?"Nouvelle Phase D'évaluation":"Modifier Phase d'évaluation"),V=[{name:"Phase d'évaluation",href:route("phases.index"),current:!1},{name:p(i.phase)?"Nouveau":"Modifier",href:"#",current:!0}],c=()=>{t=$(p(i.phase)?{phase_name:"",phase_year:new Date().getFullYear(),period_type_id:i.types[0].period_type_id,phase_min_goals:4}:{phase_name:i.phase.phase_name||"",phase_year:parseInt(i.phase.phase_year)||new Date().getFullYear(),period_type_id:i.phase.period_type_id||i.types[0].period_type_id,phase_min_goals:i.phase.phase_min_goals||4})},N=()=>{p(i.phase)?t.post(route("phases.store"),{onSuccess:()=>c()}):t.put(route("phases.update",{phase:i.phase.phase_id}),{onSuccess:()=>c()})};return c(),(ce,r)=>(d(),v(q,null,{default:l(()=>[a(s(B),{title:"Nouvelle Phase d'évaluation"}),e("div",L,[a(A,{pages:V}),e("div",O,[e("div",Z,[e("h1",G,u(w.value),1),J])]),e("div",K,[e("form",{class:"bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2",onSubmit:F(N,["prevent"])},[e("div",R,[e("div",W,[e("div",X,[a(m,{for:"name",required:""},{default:l(()=>[n("Nom")]),_:1}),e("div",ee,[a(D,{id:"name",modelValue:s(t).phase_name,"onUpdate:modelValue":r[0]||(r[0]=o=>s(t).phase_name=o),invalid:s(t).errors.phase_name!==void 0,autofocus:"",placeholder:"Nom"},null,8,["modelValue","invalid"])]),a(h,{message:s(t).errors.phase_name},null,8,["message"])]),e("div",se,[a(m,{for:"start_date",required:""},{default:l(()=>[n("Année")]),_:1}),e("div",ae,[a(b,{modelValue:s(t).phase_year,"onUpdate:modelValue":r[1]||(r[1]=o=>s(t).phase_year=o)},null,8,["modelValue"])]),e("div",te,[a(h,{message:s(t).errors.phase_year},null,8,["message"])])]),e("div",oe,[a(m,null,{default:l(()=>[n("Fréquence des évaluations")]),_:1}),e("div",ie,[a(s(Y),{modelValue:s(t).period_type_id,"onUpdate:modelValue":r[2]||(r[2]=o=>s(t).period_type_id=o),as:"div"},{default:l(()=>[e("div",le,[a(s(z),{class:"relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2 focus:ring-cyan-600 sm:text-sm sm:leading-6"},{default:l(()=>[e("span",re,u(_.types.filter(o=>o.period_type_id===s(t).period_type_id)[0].period_type_name),1),e("span",ne,[a(s(E),{"aria-hidden":"true",class:"h-5 w-5 text-gray-400"})])]),_:1}),a(S,{"leave-active-class":"transition ease-in duration-100","leave-from-class":"opacity-100","leave-to-class":"opacity-0"},{default:l(()=>[a(s(H),{class:"absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"},{default:l(()=>[(d(!0),x(j,null,U(_.types,o=>(d(),v(s(I),{key:o.period_type_id,value:o.period_type_id,as:"template"},{default:l(({active:g,selected:y})=>[e("li",{class:f([g?"bg-cyan-600 text-white":"text-gray-900","relative cursor-default select-none py-2 pl-3 pr-9"])},[e("span",{class:f([y?"font-semibold":"font-normal","block truncate"])},u(o.period_type_name),3),y?(d(),x("span",{key:0,class:f([g?"text-white":"text-cyan-600","absolute inset-y-0 right-0 flex items-center pr-4"])},[a(s(T),{"aria-hidden":"true",class:"h-5 w-5"})],2)):P("",!0)],2)]),_:2},1032,["value"]))),128))]),_:1})]),_:1})])]),_:1},8,["modelValue"])])]),e("div",de,[a(m,{for:"start_date",required:""},{default:l(()=>[n("Minimum d'objectif par évaluation")]),_:1}),e("div",pe,[a(b,{modelValue:s(t).phase_min_goals,"onUpdate:modelValue":r[3]||(r[3]=o=>s(t).phase_min_goals=o)},null,8,["modelValue"])]),e("div",me,[a(h,{message:s(t).errors.phase_min_goals},null,8,["message"])])])])]),e("div",_e,[a(C),a(M,{disabled:s(t).processing},{default:l(()=>[n(" Enregistrer")]),_:1},8,["disabled"])])],40,Q)])])]),_:1}))}};export{Fe as default};
