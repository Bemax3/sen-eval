import{b as Y,r as k,h as z,T as P,w as M,o as d,d as y,e as a,f as e,u as i,Z as H,a as t,t as r,g as n,l as $,i as I,p as L,n as p,c as h,k as C,j as D,F as N,O as j,m as E}from"./app-97f24108.js";import{_ as G}from"./AuthenticatedLayout-60aabe79.js";import{_ as Z}from"./Breadcrumbs-128d3fe8.js";import{g as q,a as J,c as K,m as Q}from"./helper-00cc7808.js";import{_ as R}from"./Datatable-bd1675da.js";import{r as W,_ as c,a as f,b as X}from"./EmptyState-e29df9ce.js";import{_ as ee}from"./SectionTitle-4e3f2362.js";import{_ as te}from"./Separator-ebb927f5.js";import{_ as ae}from"./InputLabel-29a6a3dc.js";import{_ as se}from"./SubmitButton-ac7c7d0a.js";import{_ as ie}from"./DeleteModal-7bf8f39f.js";import{r as ne}from"./ChevronDoubleRightIcon-74dbaf9e.js";import{N as le,H as re,U as B,B as oe}from"./listbox-20c62403.js";import{r as de}from"./ChevronUpDownIcon-7bd5fcff.js";import{r as T}from"./CheckIcon-1e89fb52.js";import{r as ce}from"./EyeIcon-17ce3fa6.js";import{r as ue}from"./TrashIcon-9fcee4f2.js";import"./logo1637145113-c7398df9.js";import"./ExclamationTriangleIcon-46c414a4.js";import"./use-controllable-5e55b309.js";const me={class:"px-4 sm:px-6 lg:px-8"},fe={class:"sm:flex sm:items-center"},ge={class:"sm:flex-auto"},_e={class:"text-2xl font-semibold leading-6 text-gray-900 dark:text-white"},pe={class:"mt-2 text-sm text-gray-700 dark:text-white"},he={class:"space-x-2 mt-4 sm:ml-16 sm:mt-0 sm:flex-none"},xe={class:"sm:flex sm:items-center border-b border-gray-600 pb-5"},be={class:"space-x-2 mt-4 sm:ml-16 sm:mt-0 sm:flex-none"},ye={class:"mt-8 bg-white dark:bg-grayish shadow sm:rounded-lg"},ve={class:"px-4 py-5 sm:p-6"},we=t("h3",{class:"text-base font-semibold leading-6 text-gray-900 dark:text-white"},"Filtres",-1),ke=t("div",{class:"mt-2 max-w-xl text-sm text-gray-500 dark:text-gray-100"},[t("p",null,"Filtrer les données en fonction de l'année et de la direction")],-1),$e=["onSubmit"],je={class:"w-full sm:max-w-xl"},Ve={class:"mt-2"},Oe={class:"relative mt-2"},Me={class:"block truncate"},Ce={class:"pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2"},De={class:"mt-8"},Ne={key:0,class:"min-w-full divide-y divide-gray-300 dark:divide-black"},Be={class:"bg-gray-50 dark:bg-grayish"},Te={class:"divide-y divide-gray-200 dark:divide-black bg-white dark:bg-grayish"},Ae={class:"flex-shrink-0"},Fe={class:"flex h-10 w-10 items-center justify-center rounded-full border-2 border-cyan-600"},Se={class:"text-cyan-700"},Ue={class:"relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"},Ye={class:"flex items-center justify-center"},ze=["onClick"],Pe={key:1,class:"text-center bg-white dark:bg-grayish text-lg text-gray-600 py-4"},rt={__name:"AgentGoals",props:{agent:{type:Object},goals:{type:Object},phases:{},phase_id:{}},setup(o){var V;const g=o,A=[{name:"Mes Agents",href:route("agents.index"),current:!1},{name:"Objectifs",href:"#",current:!0}],F=Y(()=>q(g.goals)),_=k(g.goals.data),x=z({keyword:"",fields:["goal_name","goal_expected_result"]}),b=P({phase_id:parseInt(g.phase_id)||-1}),v=k(!1),w=k((V=_[0])==null?void 0:V.rating_claim_id),S=l=>{w.value=l,v.value=!0},U=()=>{j.get(route("agent-goals.index",{agent:g.agent.user_id,phase_id:b.phase_id}),{},{preserveScroll:!0})};return M(()=>x.keyword,function(l){l===""?_.value=g.goals.data:E.post(route("agent-goals.search",{agent:g.agent.user_id}),x).then(u=>_.value=u.data)}),M(()=>g.goals,function(l){_.value=l.data,!_.value.length>0&&(l.prev_page_url?j.get(l.prev_page_url):j.get(l.first_page_url))}),(l,u)=>(d(),y(G,null,{default:a(()=>[e(i(H),{title:"Objectifs - Agents"}),t("div",me,[e(Z,{pages:A}),t("div",fe,[t("div",ge,[t("h1",_e,"Objectifs de "+r(o.agent.user_display_name),1),t("p",pe," Objectifs de "+r(o.agent.user_display_name)+". Matricule : "+r(o.agent.user_matricule),1)]),t("div",he,[e(i($),{href:l.route("agent-ratings.index",{agent:o.agent.user_id}),as:"button",class:"inline-flex gap-x-1.5 rounded-md bg-cyan-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"},{default:a(()=>[n(" Évaluations "),e(i(ne),{class:"-mr-0.5 h-5 w-5"})]),_:1},8,["href"])])]),e(te,{title:"Objectifs"}),t("div",xe,[e(ee,{desc:"Tableau déscriptif des objectifs fixés à cet agent.",title:"Objectifs de l'agent"}),t("div",be,[e(i($),{href:l.route("agent-goals.create",{agent:o.agent.user_id}),as:"button",class:"inline-flex gap-x-1.5 rounded-md bg-cyan-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"},{default:a(()=>[n(" Nouveau "),e(i(W),{class:"-mr-0.5 h-5 w-5"})]),_:1},8,["href"])])]),t("div",ye,[t("div",ve,[we,ke,t("form",{class:"mt-5 sm:flex sm:items-center gap-2",onSubmit:I(U,["prevent"])},[t("div",je,[e(ae,null,{default:a(()=>[n("Année d'évaluation")]),_:1}),t("div",Ve,[e(i(oe),{modelValue:i(b).phase_id,"onUpdate:modelValue":u[0]||(u[0]=s=>i(b).phase_id=s),as:"div"},{default:a(()=>[t("div",Oe,[e(i(le),{class:"relative w-full cursor-default rounded-md bg-white dark:bg-grayish py-1.5 pl-3 pr-10 text-left text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 focus:outline-none focus:ring-2 focus:ring-cyan-700 sm:text-sm sm:leading-6"},{default:a(()=>{var s;return[t("span",Me,r(((s=o.phases.filter(m=>m.phase_id===i(b).phase_id)[0])==null?void 0:s.phase_year)||"Toute confondues"),1),t("span",Ce,[e(i(de),{"aria-hidden":"true",class:"h-5 w-5 text-gray-400"})])]}),_:1}),e(L,{"leave-active-class":"transition ease-in duration-100","leave-from-class":"opacity-100","leave-to-class":"opacity-0"},{default:a(()=>[e(i(re),{class:"absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white dark:bg-grayish py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"},{default:a(()=>[e(i(B),{value:-1,as:"template"},{default:a(({active:s,selected:m})=>[t("li",{class:p([s?"bg-cyan-600  text-white":"text-gray-900 dark:text-white","relative cursor-default select-none py-2 pl-3 pr-9"])},[t("span",{class:p([m?"font-semibold":"font-normal","block truncate"])},"Toute confondues",2),m?(d(),h("span",{key:0,class:p([s?"text-white":"text-cyan-600","absolute inset-y-0 right-0 flex items-center pr-4"])},[e(i(T),{"aria-hidden":"true",class:"h-5 w-5"})],2)):C("",!0)],2)]),_:1}),(d(!0),h(N,null,D(o.phases,s=>(d(),y(i(B),{key:s.phase_id,value:s.phase_id,as:"template"},{default:a(({active:m,selected:O})=>[t("li",{class:p([m?"bg-cyan-600  text-white":"text-gray-900 dark:text-white","relative cursor-default select-none py-2 pl-3 pr-9"])},[t("span",{class:p([O?"font-semibold":"font-normal","block truncate"])},r(s.phase_year),3),O?(d(),h("span",{key:0,class:p([m?"text-white":"text-cyan-600","absolute inset-y-0 right-0 flex items-center pr-4"])},[e(i(T),{"aria-hidden":"true",class:"h-5 w-5"})],2)):C("",!0)],2)]),_:2},1032,["value"]))),128))]),_:1})]),_:1})])]),_:1},8,["modelValue"])])]),t("div",De,[e(se,{class:"sm:ml-3 sm:mt-0 sm:w-auto",type:"submit"},{default:a(()=>[n("Filtrer")]),_:1})])],40,$e)])]),i(J)(o.goals.data)?(d(),y(R,{key:0,modelValue:x.keyword,"onUpdate:modelValue":u[1]||(u[1]=s=>x.keyword=s),pagination:F.value},{default:a(()=>[_.value.length>0?(d(),h("table",Ne,[t("thead",Be,[t("tr",null,[e(c,{first:!0},{default:a(()=>[n("Libelle")]),_:1}),e(c,null,{default:a(()=>[n("Valeur Cible")]),_:1}),e(c,null,{default:a(()=>[n("Disponibilité des Moyens")]),_:1}),e(c,null,{default:a(()=>[n("Échéance")]),_:1}),e(c,null,{default:a(()=>[n("Taux de réalisation")]),_:1}),e(c,null,{default:a(()=>[n("Année d'évaluation")]),_:1}),e(c,null,{default:a(()=>[n("Période")]),_:1}),e(c,null,{default:a(()=>[n("Barème")]),_:1}),e(c)])]),t("tbody",Te,[(d(!0),h(N,null,D(_.value,s=>(d(),h("tr",{key:s.goal_id},[e(f,{first:!0,class:"whitespace-pre-line"},{default:a(()=>[n(r(s.goal_name),1)]),_:2},1024),e(f,{class:"whitespace-pre-line"},{default:a(()=>[n(r(s.goal_expected_result)+" %",1)]),_:2},1024),e(f,null,{default:a(()=>[t("span",{class:p([s.goal_means_available?"bg-green-50 text-green-700 ring-green-600/20 dark:bg-green-600 dark:text-white":"bg-red-50 text-red-700 ring-red-600/20 dark:bg-red-600 dark:text-white","inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset"])},r(s.goal_means_available?"Disponible":"Indisponible"),3)]),_:2},1024),e(f,null,{default:a(()=>[n(r(i(K)(i(Q)(s.goal_expected_date).format("DD MMMM YYYY"))),1)]),_:2},1024),e(f,{class:"whitespace-break-spaces"},{default:a(()=>[n(r(s.goal_rate)+" % ",1)]),_:2},1024),e(f,{class:"whitespace-break-spaces"},{default:a(()=>[n(r(s.phase.phase_year),1)]),_:2},1024),e(f,{class:"whitespace-break-spaces"},{default:a(()=>[n(r(s.period.evaluation_period_name),1)]),_:2},1024),e(f,null,{default:a(()=>[t("span",Ae,[t("span",Fe,[t("span",Se,r(s.goal_marking),1)])])]),_:2},1024),t("td",Ue,[t("div",Ye,[e(i($),{href:l.route("agent-goals.edit",{agent:o.agent.user_id,agent_goal:s.goal_id}),class:"group flex items-center px-4 py-2 text-sm"},{default:a(()=>[e(i(ce),{"aria-hidden":"true",class:"mr-3 h-5 w-5 text-gray-400 group-hover:text-cyan-600"})]),_:2},1032,["href"]),t("button",{class:"group flex items-center px-4 py-2 text-sm",onClick:m=>S(s.goal_id)},[e(i(ue),{"aria-hidden":"true",class:"mr-3 h-5 w-5 text-gray-400 group-hover:text-red-600"})],8,ze)])])]))),128))])])):(d(),h("div",Pe," Aucun élément trouvé."))]),_:1},8,["modelValue","pagination"])):(d(),y(X,{key:1,link:l.route("agent-goals.create",{agent:o.agent.user_id}),action:"Nouveau",message:"Créer un objectif en appuyant sur ce bouton",title:"Pas d'objectifs"},null,8,["link"]))]),e(ie,{link:l.route("agent-goals.destroy",{agent:o.agent.user_id,agent_goal:w.value?w.value:-1}),opened:v.value,onCloseModal:u[2]||(u[2]=s=>v.value=!1)},null,8,["link","opened"])]),_:1}))}};export{rt as default};
