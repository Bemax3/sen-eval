<<<<<<<< HEAD:public/build/assets/UsersList-7137e531.js
import{_ as k,g as b,h as N}from"./AuthenticatedLayout-a6827bda.js";import{_ as V}from"./Datatable-f7bebf15.js";import{_ as i,a as n}from"./TableData-551b2a58.js";import{b as $,r as O,d as A,w as y,o,e as g,f as t,g as e,u as p,Z as B,a as l,c as f,k as a,F as C,i as D,l as F,O as v,t as u,m as L}from"./app-009e6676.js";import{_ as P}from"./EmptyState-148efe32.js";import{_ as j}from"./Breadcrumbs-6f218844.js";import{r as R}from"./EyeIcon-07e9864a.js";import"./logo1637145113-11387d37.js";import"./PlusIcon-1fd1de74.js";const U={class:"px-4 sm:px-6 lg:px-8"},E=l("div",{class:"sm:flex sm:items-center"},[l("div",{class:"sm:flex-auto"},[l("h1",{class:"text-2xl font-semibold leading-6 text-gray-900"},"Agents"),l("p",{class:"mt-2 text-sm text-gray-700"}," La liste des agents de l'application. ")])],-1),G={key:0,class:"min-w-full divide-y divide-gray-300"},M={class:"bg-gray-50"},S={class:"divide-y divide-gray-200 bg-white"},T={class:"relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"},Z={class:"flex items-center justify-center"},q={key:1,class:"text-center bg-white text-lg text-gray-600 py-4"},ee={__name:"UsersList",props:{users:{type:Object}},setup(h){const c=h,x=[{name:"Agents",href:"#",current:!0}],w=$(()=>b(c.users)),d=O(c.users.data),_=A({keyword:"",fields:["user_matricule","user_display_name"]});return y(()=>_.keyword,function(r){r===""?d.value=c.users.data:F.post(route("users.search"),_).then(m=>d.value=m.data)}),y(()=>c.users,function(r){d.value=r.data,!d.value.length>0&&(r.prev_page_url?v.get(r.prev_page_url):v.get(r.first_page_url))}),(r,m)=>(o(),g(k,null,{default:t(()=>[e(p(B),{title:"Agents"}),l("div",U,[e(j,{pages:x}),E,p(N)(h.users.data)?(o(),g(V,{key:0,modelValue:_.keyword,"onUpdate:modelValue":m[0]||(m[0]=s=>_.keyword=s),pagination:w.value},{default:t(()=>[d.value.length>0?(o(),f("table",G,[l("thead",M,[l("tr",null,[e(i,{first:!0},{default:t(()=>[a("Matricule")]),_:1}),e(i,null,{default:t(()=>[a("Nom")]),_:1}),e(i,null,{default:t(()=>[a("Poste")]),_:1}),e(i,null,{default:t(()=>[a("GF")]),_:1}),e(i,null,{default:t(()=>[a("NR")]),_:1}),e(i,null,{default:t(()=>[a("CR")]),_:1}),e(i,null,{default:t(()=>[a("Organisation")]),_:1}),e(i)])]),l("tbody",S,[(o(!0),f(C,null,D(d.value,s=>(o(),f("tr",{key:s.user_id},[e(n,{first:!0,class:"whitespace-pre-line"},{default:t(()=>[a(u(s.user_matricule),1)]),_:2},1024),e(n,null,{default:t(()=>[a(u(s.user_display_name),1)]),_:2},1024),e(n,{class:"whitespace-pre-line"},{default:t(()=>[a(u(s.user_title),1)]),_:2},1024),e(n,null,{default:t(()=>[a(u(s.user_gf),1)]),_:2},1024),e(n,null,{default:t(()=>[a(u(s.user_nr),1)]),_:2},1024),e(n,null,{default:t(()=>[a(u(s.user_responsibility_center),1)]),_:2},1024),e(n,{class:"whitespace-pre-line"},{default:t(()=>[a(u(s.org?s.org.org_name:"No Org"),1)]),_:2},1024),l("td",T,[l("div",Z,[e(p(L),{href:r.route("users.show",{user:s.user_id}),class:"group flex items-center px-4 py-2 text-sm"},{default:t(()=>[e(p(R),{"aria-hidden":"true",class:"mr-3 h-5 w-5 text-gray-400 group-hover:text-amber-600"})]),_:2},1032,["href"])])])]))),128))])])):(o(),f("div",q," Aucun élément trouvé."))]),_:1},8,["modelValue","pagination"])):(o(),g(P,{key:1,link:r.route("users.create"),action:"Nouveau",message:"Créer une nouvelle compétence en appuyant sur ce bouton",title:"Pas de Compétence"},null,8,["link"]))])]),_:1}))}};export{ee as default};
========
import{_ as k,g as b,h as N}from"./AuthenticatedLayout-3ac73bac.js";import{_ as V}from"./Datatable-4bce3106.js";import{_ as i,a as n}from"./TableData-81b0e721.js";import{b as $,r as O,d as A,w as y,o,e as g,f as t,g as e,u as p,Z as B,a as l,c as f,k as a,F as C,i as D,l as F,O as v,t as u,m as L}from"./app-3e4b2772.js";import{_ as P}from"./EmptyState-74c2db4d.js";import{_ as j}from"./Breadcrumbs-51f948bf.js";import{r as R}from"./EyeIcon-e2e73813.js";import"./logo1637145113-11387d37.js";import"./PlusIcon-a937723d.js";const U={class:"px-4 sm:px-6 lg:px-8"},E=l("div",{class:"sm:flex sm:items-center"},[l("div",{class:"sm:flex-auto"},[l("h1",{class:"text-2xl font-semibold leading-6 text-gray-900"},"Agents"),l("p",{class:"mt-2 text-sm text-gray-700"}," La liste des agents de l'application. ")])],-1),G={key:0,class:"min-w-full divide-y divide-gray-300"},M={class:"bg-gray-50"},S={class:"divide-y divide-gray-200 bg-white"},T={class:"relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"},Z={class:"flex items-center justify-center"},q={key:1,class:"text-center bg-white text-lg text-gray-600 py-4"},ee={__name:"UsersList",props:{users:{type:Object}},setup(h){const c=h,x=[{name:"Agents",href:"#",current:!0}],w=$(()=>b(c.users)),d=O(c.users.data),_=A({keyword:"",fields:["user_matricule","user_display_name"]});return y(()=>_.keyword,function(r){r===""?d.value=c.users.data:F.post(route("users.search"),_).then(m=>d.value=m.data)}),y(()=>c.users,function(r){d.value=r.data,!d.value.length>0&&(r.prev_page_url?v.get(r.prev_page_url):v.get(r.first_page_url))}),(r,m)=>(o(),g(k,null,{default:t(()=>[e(p(B),{title:"Agents"}),l("div",U,[e(j,{pages:x}),E,p(N)(h.users.data)?(o(),g(V,{key:0,modelValue:_.keyword,"onUpdate:modelValue":m[0]||(m[0]=s=>_.keyword=s),pagination:w.value},{default:t(()=>[d.value.length>0?(o(),f("table",G,[l("thead",M,[l("tr",null,[e(i,{first:!0},{default:t(()=>[a("Matricule")]),_:1}),e(i,null,{default:t(()=>[a("Nom")]),_:1}),e(i,null,{default:t(()=>[a("Poste")]),_:1}),e(i,null,{default:t(()=>[a("GF")]),_:1}),e(i,null,{default:t(()=>[a("NR")]),_:1}),e(i,null,{default:t(()=>[a("CR")]),_:1}),e(i,null,{default:t(()=>[a("Organisation")]),_:1}),e(i)])]),l("tbody",S,[(o(!0),f(C,null,D(d.value,s=>(o(),f("tr",{key:s.user_id},[e(n,{first:!0,class:"whitespace-pre-line"},{default:t(()=>[a(u(s.user_matricule),1)]),_:2},1024),e(n,null,{default:t(()=>[a(u(s.user_display_name),1)]),_:2},1024),e(n,{class:"whitespace-pre-line"},{default:t(()=>[a(u(s.user_title),1)]),_:2},1024),e(n,null,{default:t(()=>[a(u(s.user_gf),1)]),_:2},1024),e(n,null,{default:t(()=>[a(u(s.user_nr),1)]),_:2},1024),e(n,null,{default:t(()=>[a(u(s.user_responsibility_center),1)]),_:2},1024),e(n,{class:"whitespace-pre-line"},{default:t(()=>[a(u(s.org?s.org.org_name:"No Org"),1)]),_:2},1024),l("td",T,[l("div",Z,[e(p(L),{href:r.route("users.show",{user:s.user_id}),class:"group flex items-center px-4 py-2 text-sm"},{default:t(()=>[e(p(R),{"aria-hidden":"true",class:"mr-3 h-5 w-5 text-gray-400 group-hover:text-amber-600"})]),_:2},1032,["href"])])])]))),128))])])):(o(),f("div",q," Aucun élément trouvé."))]),_:1},8,["modelValue","pagination"])):(o(),g(P,{key:1,link:r.route("users.create"),action:"Nouveau",message:"Créer une nouvelle compétence en appuyant sur ce bouton",title:"Pas de Compétence"},null,8,["link"]))])]),_:1}))}};export{ee as default};
>>>>>>>> 6ba55a1 (bug fixes):public/build/assets/UsersList-29814bcb.js
