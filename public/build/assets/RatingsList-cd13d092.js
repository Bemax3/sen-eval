import{_ as y,g as w,h as k}from"./AuthenticatedLayout-fb60e402.js";import{b,r as V,d as $,w as B,o as i,e as p,f as a,g as e,u as m,Z as N,a as t,c as g,k as r,F as j,i as D,l as L,t as l,n as P,m as A}from"./app-695e8d8e.js";import{_ as C}from"./Breadcrumbs-137c04c7.js";import{_ as E}from"./Datatable-7aa556c9.js";import{_ as F}from"./EmptyState-68d793fd.js";import{_ as n,a as o}from"./TableData-d677473b.js";import{r as z}from"./EyeIcon-274fe459.js";import"./logo1637145113-11387d37.js";const O={class:"px-4 sm:px-6 lg:px-8"},R=t("div",{class:"sm:flex sm:items-center"},[t("div",{class:"sm:flex-auto"},[t("h1",{class:"text-2xl font-semibold leading-6 text-gray-900"},"Évaluations à valider"),t("p",{class:"mt-2 text-sm text-gray-700"}," Liste des Évaluations faites par mes agents. ")])],-1),S={key:0,class:"min-w-full divide-y divide-gray-300"},T={class:"bg-gray-50"},U={class:"divide-y divide-gray-200 bg-white"},Z={class:"flex-shrink-0"},q={class:"flex h-10 w-10 items-center justify-center rounded-full border-2 border-cyan-600"},G={class:"text-cyan-600"},H={class:"relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"},I={class:"flex items-center justify-center"},J={key:1,class:"text-center bg-white text-lg text-gray-600 py-4"},ae={__name:"RatingsList",props:{ratings:{type:Object}},setup(h){const d=h,v=[{name:"Évaluations à valider",href:"#",current:!0}],x=b(()=>w(d.ratings)),u=V(d.ratings.data),c=$({keyword:"",fields:["goal_name","goal_expected_result"]});return B(()=>c.keyword,function(f){f===""?u.value=d.ratings.data:L.post(route("agent-goals.search",{agent:d.agent.user_id}),c).then(_=>u.value=_.data)}),(f,_)=>(i(),p(y,null,{default:a(()=>[e(m(N),{title:"Profil"}),t("div",O,[e(C,{pages:v}),R,m(k)(h.ratings.data)?(i(),p(E,{key:0,modelValue:c.keyword,"onUpdate:modelValue":_[0]||(_[0]=s=>c.keyword=s),pagination:x.value},{default:a(()=>[u.value.length>0?(i(),g("table",S,[t("thead",T,[t("tr",null,[e(n,{first:!0},{default:a(()=>[r("Évaluateur")]),_:1}),e(n,null,{default:a(()=>[r("Évalué")]),_:1}),e(n,null,{default:a(()=>[r("Année")]),_:1}),e(n,null,{default:a(()=>[r("Note")]),_:1}),e(n,null,{default:a(()=>[r("Validation")]),_:1}),e(n)])]),t("tbody",U,[(i(!0),g(j,null,D(u.value,s=>(i(),g("tr",{key:s.rating_id},[e(o,{first:!0,class:"whitespace-pre-line"},{default:a(()=>[r(l(s.evaluator.user_display_name+" "+s.evaluator.user_matricule),1)]),_:2},1024),e(o,{first:!0,class:"whitespace-pre-line"},{default:a(()=>[r(l(s.evaluated.user_display_name+" "+s.evaluated.user_matricule),1)]),_:2},1024),e(o,null,{default:a(()=>[r(l(s.phase.phase_year),1)]),_:2},1024),e(o,null,{default:a(()=>[t("span",Z,[t("span",q,[t("span",G,l(s.rating_mark),1)])])]),_:2},1024),e(o,null,{default:a(()=>[t("span",{class:P([s.rating_is_validated?"bg-green-50 text-green-700 ring-green-600/20":"bg-red-50 text-red-700 ring-red-600/20","inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset"])},l(s.rating_is_validated?"Validé":"En attende"),3)]),_:2},1024),t("td",H,[t("div",I,[e(m(A),{href:f.route("validations.show",{validation:s.rating_id}),class:"group flex items-center px-4 py-2 text-sm"},{default:a(()=>[e(m(z),{"aria-hidden":"true",class:"mr-3 h-5 w-5 text-gray-400 group-hover:text-amber-600"})]),_:2},1032,["href"])])])]))),128))])])):(i(),g("div",J,"Aucun élément trouvé."))]),_:1},8,["modelValue","pagination"])):(i(),p(F,{key:1,message:"Vos agents ne vous ont pas transmis d'évaluation à valider.",title:"Pas d'évaluations"}))])]),_:1}))}};export{ae as default};
