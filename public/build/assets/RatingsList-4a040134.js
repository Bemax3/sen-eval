import{_ as x,g as w,h as k}from"./AuthenticatedLayout-4017efb7.js";import{b,r as V,d as $,w as B,o as r,e as g,f as t,g as e,u as c,Z as N,a,c as _,k as i,F as j,i as D,l as L,t as m,m as P}from"./app-9f38d36c.js";import{_ as A}from"./Breadcrumbs-2affa003.js";import{_ as F}from"./Datatable-9005ab64.js";import{_ as C}from"./EmptyState-81baf0f3.js";import{_ as l,a as p}from"./TableData-ae9e5e20.js";import{r as E}from"./EyeIcon-764425d4.js";import"./logo1637145113-11387d37.js";const O={class:"px-4 sm:px-6 lg:px-8"},R=a("div",{class:"sm:flex sm:items-center"},[a("div",{class:"sm:flex-auto"},[a("h1",{class:"text-2xl font-semibold leading-6 text-gray-900"},"Évaluations à valider"),a("p",{class:"mt-2 text-sm text-gray-700"}," Liste des Évaluations faites par mes agents. ")])],-1),S={key:0,class:"min-w-full divide-y divide-gray-300"},T={class:"bg-gray-50"},U={class:"divide-y divide-gray-200 bg-white"},Z={class:"flex-shrink-0"},q={class:"flex h-10 w-10 items-center justify-center rounded-full border-2 border-cyan-600"},z={class:"text-cyan-600"},G={class:"relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"},H={class:"flex items-center justify-center"},I={key:1,class:"text-center bg-white text-lg text-gray-600 py-4"},ae={__name:"RatingsList",props:{ratings:{type:Object}},setup(h){const n=h,v=[{name:"Évaluations à valider",href:"#",current:!0}],y=b(()=>w(n.ratings)),o=V(n.ratings.data),d=$({keyword:"",fields:["goal_name","goal_expected_result"]});return B(()=>d.keyword,function(f){f===""?o.value=n.ratings.data:L.post(route("agent-goals.search",{agent:n.agent.user_id}),d).then(u=>o.value=u.data)}),(f,u)=>(r(),g(x,null,{default:t(()=>[e(c(N),{title:"Profil"}),a("div",O,[e(A,{pages:v}),R,c(k)(h.ratings.data)?(r(),g(F,{key:0,modelValue:d.keyword,"onUpdate:modelValue":u[0]||(u[0]=s=>d.keyword=s),pagination:y.value},{default:t(()=>[o.value.length>0?(r(),_("table",S,[a("thead",T,[a("tr",null,[e(l,{first:!0},{default:t(()=>[i("Évaluateur")]),_:1}),e(l,null,{default:t(()=>[i("Évalué")]),_:1}),e(l,null,{default:t(()=>[i("Année")]),_:1}),e(l,null,{default:t(()=>[i("Note")]),_:1}),e(l)])]),a("tbody",U,[(r(!0),_(j,null,D(o.value,s=>(r(),_("tr",{key:s.rating_id},[e(p,{first:!0,class:"whitespace-pre-line"},{default:t(()=>[i(m(s.evaluator.user_display_name+" "+s.evaluator.user_matricule),1)]),_:2},1024),e(p,{first:!0,class:"whitespace-pre-line"},{default:t(()=>[i(m(s.evaluated.user_display_name+" "+s.evaluated.user_matricule),1)]),_:2},1024),e(p,null,{default:t(()=>[i(m(s.phase.phase_year),1)]),_:2},1024),e(p,null,{default:t(()=>[a("span",Z,[a("span",q,[a("span",z,m(s.rating_mark),1)])])]),_:2},1024),a("td",G,[a("div",H,[e(c(P),{href:f.route("validations.show",{validation:s.rating_id}),class:"group flex items-center px-4 py-2 text-sm"},{default:t(()=>[e(c(E),{"aria-hidden":"true",class:"mr-3 h-5 w-5 text-gray-400 group-hover:text-amber-600"})]),_:2},1032,["href"])])])]))),128))])])):(r(),_("div",I,"Aucun élément trouvé."))]),_:1},8,["modelValue","pagination"])):(r(),g(C,{key:1,message:"Vos agents ne vous ont pas transmis d'évaluation à valider.",title:"Pas d'évaluations"}))])]),_:1}))}};export{ae as default};
