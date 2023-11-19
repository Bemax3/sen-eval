import{b,r as B,o as d,e as f,f as n,T as E,g as t,u as s,Z as q,a as e,t as x,h as F,k as u,c as w,i as L,F as T,j as V,n as c}from"./app-009e6676.js";import{_ as U,i as y}from"./AuthenticatedLayout-a6827bda.js";import{_ as k}from"./InputLabel-00850faa.js";import{_ as N}from"./TextInput-4ed6148e.js";import{_ as z}from"./SubmitButton-d98e5e89.js";import{_ as O}from"./InputError-db0f38c0.js";import{_ as A}from"./Breadcrumbs-6f218844.js";import{_ as G}from"./FormIndications-fac9b7ef.js";import{W as J,Q as M,G as Q,X as W,J as X,Y}from"./combobox-5ed63abc.js";import{r as D}from"./ChevronUpDownIcon-99c795d4.js";import{r as P}from"./CheckIcon-44d763b6.js";import"./logo1637145113-11387d37.js";import"./use-controllable-a4a0a7b6.js";const Z={class:"px-4 sm:px-6 lg:px-8"},H={class:"sm:flex sm:items-center"},I={class:"sm:flex-auto"},K={class:"text-2xl font-semibold leading-6 text-gray-900"},R=e("p",{class:"mt-2 text-sm text-gray-700"},"Ajouter ou modifier une organisation.",-1),ee={class:"mt-8 flow-root"},se=["onSubmit"],te={class:"px-4 py-6 sm:p-8"},ae={class:"grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6"},re={class:"sm:col-span-4"},oe={class:"mt-2"},ne={class:"col-span-full"},ie={class:"mt-2"},le={class:"flex flex-col space-y-2"},de={class:"sm:col-span-4"},me={class:"relative mt-2"},ue={class:"flex"},ce={class:"flex items-center justify-between gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8"},Oe={__name:"SaveOrg",props:{org:{type:Object,default:{}},parents:{type:Array}},setup($){const o=$,C=b(()=>y(o.org)?"Nouvelle Organisation":"Modifier Organisation"),S=[{name:"Organisation",href:route("orgs.index"),current:!1},{name:"Nouveau",href:"#",current:!0}],g=o.parents,_=B(""),h=b(()=>_.value===""?g:g.filter(v=>v.org_name.toLowerCase().includes(_.value.toLowerCase())));let r;const p=()=>{r=E(y(o.org)?{org_name:"",org_type:"",parent_id:o.parents[0].org_id}:{org_name:o.org.org_name,org_type:o.org.org_type,parent_id:o.org.parent_id})},j=()=>{y(o.org)?r.post(route("orgs.store"),{onSuccess:()=>p()}):r.put(route("orgs.update",{org:o.org.org_id}),{onSuccess:()=>p()})};return p(),(v,i)=>(d(),f(U,null,{default:n(()=>[t(s(q),{title:"Enregistrer Organisation"}),e("div",Z,[t(A,{pages:S}),e("div",H,[e("div",I,[e("h1",K,x(C.value),1),R])]),e("div",ee,[e("form",{class:"bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2",onSubmit:F(j,["prevent"])},[e("div",te,[e("div",ae,[e("div",re,[t(k,{for:"name",required:""},{default:n(()=>[u("Nom")]),_:1}),e("div",oe,[t(N,{id:"name",modelValue:s(r).org_name,"onUpdate:modelValue":i[0]||(i[0]=a=>s(r).org_name=a),invalid:s(r).errors.org_name!==void 0,autofocus:"",placeholder:"Nom"},null,8,["modelValue","invalid"])]),t(O,{message:s(r).errors.org_name},null,8,["message"])]),e("div",ne,[t(k,{for:"start_date",required:""},{default:n(()=>[u("Type")]),_:1}),e("div",ie,[t(N,{modelValue:s(r).org_type,"onUpdate:modelValue":i[1]||(i[1]=a=>s(r).org_type=a),disabled:!0},null,8,["modelValue"])]),e("div",le,[t(O,{message:s(r).errors.org_type},null,8,["message"])])]),e("div",de,[t(s(X),{modelValue:s(r).parent_id,"onUpdate:modelValue":i[3]||(i[3]=a=>s(r).parent_id=a),as:"div"},{default:n(()=>[t(s(J),{class:"block text-sm font-medium leading-6 text-gray-900"},{default:n(()=>[u("Organisation Parent")]),_:1}),e("div",me,[t(s(M),{"display-value":a=>{var l;return(l=s(g).filter(m=>m.org_id===a)[0])==null?void 0:l.org_name},class:"w-full rounded-md border-0 bg-white py-1.5 pl-3 pr-12 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-cyan-600 sm:text-sm sm:leading-6",onChange:i[2]||(i[2]=a=>_.value=a.target.value)},null,8,["display-value"]),t(s(Q),{class:"absolute inset-y-0 right-0 flex items-center rounded-r-md px-2 focus:outline-none"},{default:n(()=>[t(s(D),{"aria-hidden":"true",class:"h-5 w-5 text-gray-400"})]),_:1}),h.value.length>0?(d(),f(s(W),{key:0,class:"absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"},{default:n(()=>[(d(!0),w(T,null,L(h.value,a=>(d(),f(s(Y),{key:a.org_id,value:a.org_id,as:"template"},{default:n(({active:l,selected:m})=>[e("li",{class:c(["relative cursor-default select-none py-2 pl-3 pr-9",l?"bg-cyan-600 text-white":"text-gray-900"])},[e("div",ue,[e("span",{class:c(["truncate",m&&"font-semibold"])},x(a.org_name),3),e("span",{class:c(["ml-2 truncate text-gray-500",l?"text-cyan-200":"text-gray-500"])},x(a.org_responsibility_center),3)]),m?(d(),w("span",{key:0,class:c(["absolute inset-y-0 right-0 flex items-center pr-4",l?"text-white":"text-cyan-600"])},[t(s(P),{"aria-hidden":"true",class:"h-5 w-5"})],2)):V("",!0)],2)]),_:2},1032,["value"]))),128))]),_:1})):V("",!0)])]),_:1},8,["modelValue"])])])]),e("div",ce,[t(G),t(z,{disabled:s(r).processing},{default:n(()=>[u(" Enregistrer")]),_:1},8,["disabled"])])],40,se)])])]),_:1}))}};export{Oe as default};
