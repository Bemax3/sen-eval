import{_ as b,g as w,h as k}from"./AuthenticatedLayout-a6827bda.js";import{b as $,r as V,d as j,w as A,o as l,e as p,f as a,g as e,u as r,Z as B,a as t,t as o,k as i,m as v,c as g,F as N,i as D,l as O}from"./app-009e6676.js";import{_ as P}from"./Breadcrumbs-6f218844.js";import{_ as C}from"./Datatable-f7bebf15.js";import{_ as F}from"./EmptyState-148efe32.js";import{_ as d,a as h}from"./TableData-551b2a58.js";import{_ as L}from"./SectionTitle-d7629aad.js";import{_ as M}from"./Separator-75b2b080.js";import{r as T}from"./ChevronDoubleRightIcon-245a1eff.js";import{r as E}from"./PlusIcon-1fd1de74.js";import{r as R}from"./EyeIcon-07e9864a.js";import"./logo1637145113-11387d37.js";const S={class:"px-4 sm:px-6 lg:px-8"},U={class:"sm:flex sm:items-center"},Z={class:"sm:flex-auto"},q={class:"text-2xl font-semibold leading-6 text-gray-900"},z={class:"mt-2 text-sm text-gray-700"},G={class:"space-x-2 mt-4 sm:ml-16 sm:mt-0 sm:flex-none"},H={class:"sm:flex sm:items-center border-b border-gray-400 pb-5"},I={class:"space-x-2 mt-4 sm:ml-16 sm:mt-0 sm:flex-none"},J={key:0,class:"min-w-full divide-y divide-gray-300"},K={class:"bg-gray-50"},Q={class:"divide-y divide-gray-200 bg-white"},W={class:"flex-shrink-0"},X={class:"flex h-10 w-10 items-center justify-center rounded-full border-2 border-cyan-600"},Y={class:"text-cyan-600"},ee={class:"relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"},te={class:"flex items-center justify-center"},ae={key:1,class:"text-center bg-white text-lg text-gray-600 py-4"},ge={__name:"AgentRatings",props:{agent:{type:Object},ratings:{type:Object}},setup(n){const c=n,x=[{name:"Mes Agents",href:route("agents.index"),current:!1},{name:"Évaluations",href:"#",current:!0}],y=$(()=>w(c.ratings)),m=V(c.ratings.data),f=j({keyword:"",fields:["goal_name","goal_expected_result"]});return A(()=>f.keyword,function(u){u===""?m.value=c.ratings.data:O.post(route("agent-goals.search",{agent:c.agent.user_id}),f).then(_=>m.value=_.data)}),(u,_)=>(l(),p(b,null,{default:a(()=>[e(r(B),{title:"Profil"}),t("div",S,[e(P,{pages:x}),t("div",U,[t("div",Z,[t("h1",q,"Évaluations de "+o(n.agent.user_display_name),1),t("p",z," Liste des Évaluations de "+o(n.agent.user_display_name)+". Matricule : "+o(n.agent.user_matricule),1)]),t("div",G,[e(r(v),{href:u.route("agent-goals.index",{agent:n.agent.user_id}),class:"inline-flex gap-x-1.5 rounded-md bg-cyan-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"},{default:a(()=>[i(" Objectif "),e(r(T),{class:"-mr-0.5 h-5 w-5"})]),_:1},8,["href"])])]),e(M,{title:"Évaluations"}),t("div",H,[e(L,{desc:"Tableau descriptif des évaluations.",title:"Évaluations"}),t("div",I,[e(r(v),{href:u.route("agent-ratings.create",{agent:n.agent.user_id}),class:"inline-flex gap-x-1.5 rounded-md bg-cyan-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"},{default:a(()=>[i(" Évaluer cet agent "),e(r(E),{class:"-mr-0.5 h-5 w-5"})]),_:1},8,["href"])])]),r(k)(n.ratings.data)?(l(),p(C,{key:0,modelValue:f.keyword,"onUpdate:modelValue":_[0]||(_[0]=s=>f.keyword=s),pagination:y.value},{default:a(()=>[m.value.length>0?(l(),g("table",J,[t("thead",K,[t("tr",null,[e(d,{first:!0},{default:a(()=>[i("Évaluateur")]),_:1}),e(d,null,{default:a(()=>[i("Évalué")]),_:1}),e(d,null,{default:a(()=>[i("Année")]),_:1}),e(d,null,{default:a(()=>[i("Note")]),_:1}),e(d)])]),t("tbody",Q,[(l(!0),g(N,null,D(m.value,s=>(l(),g("tr",{key:s.evaluation_id},[e(h,{first:!0,class:"whitespace-pre-line"},{default:a(()=>[i(o(s.evaluator.user_display_name+" "+s.evaluator.user_matricule),1)]),_:2},1024),e(h,{class:"whitespace-pre-line"},{default:a(()=>[i(o(s.evaluated.user_display_name+" "+s.evaluated.user_matricule),1)]),_:2},1024),e(h,null,{default:a(()=>[i(o(s.phase.phase_year),1)]),_:2},1024),e(h,null,{default:a(()=>[t("span",W,[t("span",X,[t("span",Y,o(s.rating_mark),1)])])]),_:2},1024),t("td",ee,[t("div",te,[e(r(v),{href:u.route("agent-ratings.show",{agent:n.agent.user_id,agent_rating:s.rating_id}),class:"group flex items-center px-4 py-2 text-sm"},{default:a(()=>[e(r(R),{"aria-hidden":"true",class:"mr-3 h-5 w-5 text-gray-400 group-hover:text-amber-600"})]),_:2},1032,["href"])])])]))),128))])])):(l(),g("div",ae,"Aucun élément trouvé."))]),_:1},8,["modelValue","pagination"])):(l(),p(F,{key:1,link:u.route("agent-ratings.create",{agent:n.agent.user_id}),action:"Évaluer cet agent",message:"Créer une nouvelle évaluation",title:"Pas d'évaluation"},null,8,["link"]))])]),_:1}))}};export{ge as default};
