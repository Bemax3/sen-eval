<<<<<<<< HEAD:public/build/assets/SkillsList-0d05feb6.js
import{_ as C,g as $,h as V}from"./AuthenticatedLayout-a6827bda.js";import{_ as D}from"./Datatable-f7bebf15.js";import{_ as r,a as u}from"./TableData-551b2a58.js";import{b as N,r as h,d as j,w as y,o as n,e as g,f as t,g as e,u as c,Z as B,a as l,k as a,m as k,c as m,F as A,i as L,l as O,O as x,t as d,n as P,j as S}from"./app-009e6676.js";import{_ as F}from"./EmptyState-148efe32.js";import{_ as T}from"./Breadcrumbs-6f218844.js";import{_ as q}from"./ToggleOnDatatable-3676339b.js";import{r as z}from"./PlusIcon-1fd1de74.js";import{r as E}from"./PencilSquareIcon-009b9a21.js";import"./logo1637145113-11387d37.js";import"./switch-7eb20ab8.js";import"./use-controllable-a4a0a7b6.js";const M={class:"px-4 sm:px-6 lg:px-8"},U={class:"sm:flex sm:items-center"},Z=l("div",{class:"sm:flex-auto"},[l("h1",{class:"text-2xl font-semibold leading-6 text-gray-900"},"Compétences"),l("p",{class:"mt-2 text-sm text-gray-700"}," La liste des compétences qu'il sera possible de noter lors de l'évaluation. ")],-1),G={class:"mt-4 sm:ml-16 sm:mt-0 sm:flex-none"},H={key:0,class:"min-w-full divide-y divide-gray-300"},I={class:"bg-gray-50"},J={class:"divide-y divide-gray-200 bg-white"},K={key:0,class:"flex space-x-4"},Q={class:"relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"},R={class:"flex items-center justify-center"},W={key:1,class:"text-center bg-white text-lg text-gray-600 py-4"},ce={__name:"SkillsList",props:{skills:{type:Object}},setup(v){const _=v,b=[{name:"Compétences",href:"#",current:!0}],w=N(()=>$(_.skills));h(!1);const o=h(_.skills.data),p=j({keyword:"",fields:["skill_name","skill_desc"]});return y(()=>p.keyword,function(i){i===""?o.value=_.skills.data:O.post(route("skills.search"),p).then(f=>o.value=f.data)}),y(()=>_.skills,function(i){o.value=i.data,!o.value.length>0&&(i.prev_page_url?x.get(i.prev_page_url):x.get(i.first_page_url))}),(i,f)=>(n(),g(C,null,{default:t(()=>[e(c(B),{title:"Compétences"}),l("div",M,[e(T,{pages:b}),l("div",U,[Z,l("div",G,[e(c(k),{href:i.route("skills.create"),as:"button",class:"inline-flex gap-x-1.5 rounded-md bg-cyan-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"},{default:t(()=>[a(" Ajouter une compétence "),e(c(z),{class:"-mr-0.5 h-5 w-5"})]),_:1},8,["href"])])]),c(V)(v.skills.data)?(n(),g(D,{key:0,modelValue:p.keyword,"onUpdate:modelValue":f[0]||(f[0]=s=>p.keyword=s),pagination:w.value},{default:t(()=>[o.value.length>0?(n(),m("table",H,[l("thead",I,[l("tr",null,[e(r,{first:!0},{default:t(()=>[a("Nom")]),_:1}),e(r,null,{default:t(()=>[a("Description")]),_:1}),e(r,null,{default:t(()=>[a("Status")]),_:1}),e(r,null,{default:t(()=>[a("Barème Par Défaut")]),_:1}),e(r,null,{default:t(()=>[a("Type")]),_:1}),e(r,null,{default:t(()=>[a("College")]),_:1}),e(r,null,{default:t(()=>[a("Modifier")]),_:1})])]),l("tbody",J,[(n(!0),m(A,null,L(o.value,s=>(n(),m("tr",{key:s.skill_id},[e(u,{first:!0,class:"whitespace-pre-line"},{default:t(()=>[a(d(s.skill_name),1)]),_:2},1024),e(u,{class:"whitespace-pre-line"},{default:t(()=>[a(d(s.skill_desc),1)]),_:2},1024),e(u,null,{default:t(()=>[s.group?S("",!0):(n(),m("div",K,[e(q,{link:i.route("skills.update",{skill:s.skill_id}),value:s.skill_is_active,obj:"skill_is_active"},null,8,["link","value"]),l("span",{class:P([s.skill_is_active?"bg-green-50 text-green-700 ring-green-600/20":"bg-red-50 text-red-700 ring-red-600/20","inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset"])},d(s.skill_is_active?"Activé":"Désactivé"),3)]))]),_:2},1024),e(u,null,{default:t(()=>[a(d(s.skill_marking)+" points",1)]),_:2},1024),e(u,null,{default:t(()=>[a(d(s.type.skill_type_name),1)]),_:2},1024),e(u,null,{default:t(()=>[a(d(s.group?s.group.group_name:"Commun"),1)]),_:2},1024),l("td",Q,[l("div",R,[e(c(k),{href:i.route("skills.edit",{skill:s.skill_id}),class:"group flex items-center px-4 py-2 text-sm"},{default:t(()=>[e(c(E),{"aria-hidden":"true",class:"mr-3 h-5 w-5 text-gray-400 group-hover:text-cyan-600"})]),_:2},1032,["href"])])])]))),128))])])):(n(),m("div",W," Aucun élément trouvé."))]),_:1},8,["modelValue","pagination"])):(n(),g(F,{key:1,link:i.route("skills.create"),action:"Nouveau",message:"Créer une nouvelle compétence en appuyant sur ce bouton",title:"Pas de Compétence"},null,8,["link"]))])]),_:1}))}};export{ce as default};
========
import{_ as C,g as $,h as V}from"./AuthenticatedLayout-3ac73bac.js";import{_ as D}from"./Datatable-4bce3106.js";import{_ as r,a as u}from"./TableData-81b0e721.js";import{b as N,r as h,d as j,w as y,o as n,e as g,f as t,g as e,u as c,Z as B,a as l,k as a,m as k,c as m,F as A,i as L,l as O,O as x,t as d,n as P,j as S}from"./app-3e4b2772.js";import{_ as F}from"./EmptyState-74c2db4d.js";import{_ as T}from"./Breadcrumbs-51f948bf.js";import{_ as q}from"./ToggleOnDatatable-b04d1ccb.js";import{r as z}from"./PlusIcon-a937723d.js";import{r as E}from"./PencilSquareIcon-0b842e83.js";import"./logo1637145113-11387d37.js";import"./switch-117f037e.js";import"./use-controllable-49f1610e.js";const M={class:"px-4 sm:px-6 lg:px-8"},U={class:"sm:flex sm:items-center"},Z=l("div",{class:"sm:flex-auto"},[l("h1",{class:"text-2xl font-semibold leading-6 text-gray-900"},"Compétences"),l("p",{class:"mt-2 text-sm text-gray-700"}," La liste des compétences qu'il sera possible de noter lors de l'évaluation. ")],-1),G={class:"mt-4 sm:ml-16 sm:mt-0 sm:flex-none"},H={key:0,class:"min-w-full divide-y divide-gray-300"},I={class:"bg-gray-50"},J={class:"divide-y divide-gray-200 bg-white"},K={key:0,class:"flex space-x-4"},Q={class:"relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"},R={class:"flex items-center justify-center"},W={key:1,class:"text-center bg-white text-lg text-gray-600 py-4"},ce={__name:"SkillsList",props:{skills:{type:Object}},setup(v){const _=v,b=[{name:"Compétences",href:"#",current:!0}],w=N(()=>$(_.skills));h(!1);const o=h(_.skills.data),p=j({keyword:"",fields:["skill_name","skill_desc"]});return y(()=>p.keyword,function(i){i===""?o.value=_.skills.data:O.post(route("skills.search"),p).then(f=>o.value=f.data)}),y(()=>_.skills,function(i){o.value=i.data,!o.value.length>0&&(i.prev_page_url?x.get(i.prev_page_url):x.get(i.first_page_url))}),(i,f)=>(n(),g(C,null,{default:t(()=>[e(c(B),{title:"Compétences"}),l("div",M,[e(T,{pages:b}),l("div",U,[Z,l("div",G,[e(c(k),{href:i.route("skills.create"),as:"button",class:"inline-flex gap-x-1.5 rounded-md bg-cyan-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"},{default:t(()=>[a(" Ajouter une compétence "),e(c(z),{class:"-mr-0.5 h-5 w-5"})]),_:1},8,["href"])])]),c(V)(v.skills.data)?(n(),g(D,{key:0,modelValue:p.keyword,"onUpdate:modelValue":f[0]||(f[0]=s=>p.keyword=s),pagination:w.value},{default:t(()=>[o.value.length>0?(n(),m("table",H,[l("thead",I,[l("tr",null,[e(r,{first:!0},{default:t(()=>[a("Nom")]),_:1}),e(r,null,{default:t(()=>[a("Description")]),_:1}),e(r,null,{default:t(()=>[a("Status")]),_:1}),e(r,null,{default:t(()=>[a("Barème Par Défaut")]),_:1}),e(r,null,{default:t(()=>[a("Type")]),_:1}),e(r,null,{default:t(()=>[a("College")]),_:1}),e(r,null,{default:t(()=>[a("Modifier")]),_:1})])]),l("tbody",J,[(n(!0),m(A,null,L(o.value,s=>(n(),m("tr",{key:s.skill_id},[e(u,{first:!0,class:"whitespace-pre-line"},{default:t(()=>[a(d(s.skill_name),1)]),_:2},1024),e(u,{class:"whitespace-pre-line"},{default:t(()=>[a(d(s.skill_desc),1)]),_:2},1024),e(u,null,{default:t(()=>[s.group?S("",!0):(n(),m("div",K,[e(q,{link:i.route("skills.update",{skill:s.skill_id}),value:s.skill_is_active,obj:"skill_is_active"},null,8,["link","value"]),l("span",{class:P([s.skill_is_active?"bg-green-50 text-green-700 ring-green-600/20":"bg-red-50 text-red-700 ring-red-600/20","inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset"])},d(s.skill_is_active?"Activé":"Désactivé"),3)]))]),_:2},1024),e(u,null,{default:t(()=>[a(d(s.skill_marking)+" points",1)]),_:2},1024),e(u,null,{default:t(()=>[a(d(s.type.skill_type_name),1)]),_:2},1024),e(u,null,{default:t(()=>[a(d(s.group?s.group.group_name:"Commun"),1)]),_:2},1024),l("td",Q,[l("div",R,[e(c(k),{href:i.route("skills.edit",{skill:s.skill_id}),class:"group flex items-center px-4 py-2 text-sm"},{default:t(()=>[e(c(E),{"aria-hidden":"true",class:"mr-3 h-5 w-5 text-gray-400 group-hover:text-cyan-600"})]),_:2},1032,["href"])])])]))),128))])])):(n(),m("div",W," Aucun élément trouvé."))]),_:1},8,["modelValue","pagination"])):(n(),g(F,{key:1,link:i.route("skills.create"),action:"Nouveau",message:"Créer une nouvelle compétence en appuyant sur ce bouton",title:"Pas de Compétence"},null,8,["link"]))])]),_:1}))}};export{ce as default};
>>>>>>>> 6ba55a1 (bug fixes):public/build/assets/SkillsList-dda55325.js
