import{_ as x,g as w,h as k}from"./AuthenticatedLayout-4017efb7.js";import{b,r as V,d as $,w as j,o as r,e as g,f as a,g as e,u as c,Z as B,a as t,c as _,k as i,F as N,i as D,l as L,t as m,m as P}from"./app-9f38d36c.js";import{_ as A}from"./Breadcrumbs-2affa003.js";import{_ as F}from"./Datatable-9005ab64.js";import{_ as M}from"./EmptyState-81baf0f3.js";import{_ as l,a as p}from"./TableData-ae9e5e20.js";import{r as O}from"./EyeIcon-764425d4.js";import"./logo1637145113-11387d37.js";const q={class:"px-4 sm:px-6 lg:px-8"},C=t("div",{class:"sm:flex sm:items-center"},[t("div",{class:"sm:flex-auto"},[t("h1",{class:"text-2xl font-semibold leading-6 text-gray-900"},"Mes Évaluations"),t("p",{class:"mt-2 text-sm text-gray-700"}," Liste de mes Évaluations. ")])],-1),E={key:0,class:"min-w-full divide-y divide-gray-300"},R={class:"bg-gray-50"},S={class:"divide-y divide-gray-200 bg-white"},T={class:"flex-shrink-0"},U={class:"flex h-10 w-10 items-center justify-center rounded-full border-2 border-cyan-600"},Z={class:"text-cyan-600"},z={class:"relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"},G={class:"flex items-center justify-center"},H={key:1,class:"text-center bg-white text-lg text-gray-600 py-4"},te={__name:"RatingsList",props:{agent:{type:Object},ratings:{type:Object}},setup(h){const n=h,y=[{name:"Mes Évaluations",href:"#",current:!0}],v=b(()=>w(n.ratings)),o=V(n.ratings.data),d=$({keyword:"",fields:["goal_name","goal_expected_result"]});return j(()=>d.keyword,function(f){f===""?o.value=n.ratings.data:L.post(route("agent-goals.search",{agent:n.agent.user_id}),d).then(u=>o.value=u.data)}),(f,u)=>(r(),g(x,null,{default:a(()=>[e(c(B),{title:"Profil"}),t("div",q,[e(A,{pages:y}),C,c(k)(h.ratings.data)?(r(),g(F,{key:0,modelValue:d.keyword,"onUpdate:modelValue":u[0]||(u[0]=s=>d.keyword=s),pagination:v.value},{default:a(()=>[o.value.length>0?(r(),_("table",E,[t("thead",R,[t("tr",null,[e(l,{first:!0},{default:a(()=>[i("Évaluateur")]),_:1}),e(l,null,{default:a(()=>[i("Évalué")]),_:1}),e(l,null,{default:a(()=>[i("Année")]),_:1}),e(l,null,{default:a(()=>[i("Note")]),_:1}),e(l)])]),t("tbody",S,[(r(!0),_(N,null,D(o.value,s=>(r(),_("tr",{key:s.rating_id},[e(p,{first:!0,class:"whitespace-pre-line"},{default:a(()=>[i(m(s.evaluator.user_display_name+" "+s.evaluator.user_matricule),1)]),_:2},1024),e(p,{class:"whitespace-pre-line"},{default:a(()=>[i(m(s.evaluated.user_display_name+" "+s.evaluated.user_matricule),1)]),_:2},1024),e(p,null,{default:a(()=>[i(m(s.phase.phase_year),1)]),_:2},1024),e(p,null,{default:a(()=>[t("span",T,[t("span",U,[t("span",Z,m(s.rating_mark),1)])])]),_:2},1024),t("td",z,[t("div",G,[e(c(P),{href:f.route("ratings.show",{rating:s.rating_id}),class:"group flex items-center px-4 py-2 text-sm"},{default:a(()=>[e(c(O),{"aria-hidden":"true",class:"mr-3 h-5 w-5 text-gray-400 group-hover:text-amber-600"})]),_:2},1032,["href"])])])]))),128))])])):(r(),_("div",H,"Aucun élément trouvé."))]),_:1},8,["modelValue","pagination"])):(r(),g(M,{key:1,message:"Votre supérieur hiérarchique ne vous a pas encore évaluer",title:"Pas d'évaluations"}))])]),_:1}))}};export{te as default};
