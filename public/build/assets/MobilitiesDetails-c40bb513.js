import{_ as v}from"./AuthenticatedLayout-60aabe79.js";import{b as x,r as k,o as n,d as _,e as a,f as e,u as g,Z as w,a as i,t as l,c as r,g as s,k as D,F as V,j as $}from"./app-97f24108.js";import{g as B,a as N}from"./helper-00cc7808.js";import{_ as d,a as m,b as C}from"./EmptyState-e29df9ce.js";import{_ as T}from"./Breadcrumbs-128d3fe8.js";import{_ as j}from"./Datatable-bd1675da.js";import{r as A}from"./ArrowDownTrayIcon-473920c2.js";import"./logo1637145113-c7398df9.js";const F={class:"px-4 sm:px-6 lg:px-8"},L={class:"sm:flex sm:items-center"},M={class:"sm:flex-auto"},P={class:"text-2xl font-semibold leading-6 text-gray-900 dark:text-white"},S={class:"mt-2 text-sm text-gray-700 dark:text-white"},q={key:0,class:"space-x-2 mt-4 sm:ml-16 sm:mt-0 sm:flex-none"},E=["href"],O={key:0,class:"min-w-full divide-y divide-gray-300 dark:divide-black"},U={class:"bg-gray-50 dark:bg-grayish"},Z={class:"divide-y divide-gray-200 dark:divide-black bg-white dark:bg-grayish"},z={key:1,class:"text-center bg-white dark:bg-grayish text-lg text-gray-600 py-4"},h="",X={__name:"MobilitiesDetails",props:{mobilities:{type:Object},phase:{},org:{},type:{}},setup(t){const c=t,p=[{name:"Statistiques",href:route("admin-dashboard.index",{org_id:c.org.org_id,phase_id:c.phase.phase_id}),current:!1},{name:"Détails des formations demandées",href:"#",current:!0}],y=x(()=>B(c.mobilities)),u=k(c.mobilities.data);return(b,f)=>(n(),_(v,null,{default:a(()=>[e(g(w),{title:"Agents"}),i("div",F,[e(T,{pages:p}),i("div",L,[i("div",M,[i("h1",P,'Besoin en mobilité de type "'+l(t.type.mobility_type_name)+`" pour l'année `+l(t.phase.phase_year)+" "+l(t.org!==-1?" - "+t.org.org_name:""),1),i("p",S," La liste des mobilités demandées pour l'année "+l(t.phase.phase_year)+". ",1)]),u.value.length>0?(n(),r("div",q,[i("a",{href:b.route("admin-dashboard.download-mobilities-details",{org_id:t.org.org_id,phase_id:t.phase.phase_id,type:t.type.mobility_type_id}),class:"inline-flex gap-x-1.5 rounded-md bg-cyan-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"},[s(" Télécharger "),e(g(A),{class:"-mr-0.5 h-5 w-5"})],8,E)])):D("",!0)]),g(N)(t.mobilities.data)?(n(),_(j,{key:0,modelValue:h,"onUpdate:modelValue":f[0]||(f[0]=o=>h=o),pagination:y.value,search:!1},{default:a(()=>[u.value.length>0?(n(),r("table",O,[i("thead",U,[i("tr",null,[e(d,{first:!0},{default:a(()=>[s("Mobilité")]),_:1}),e(d,null,{default:a(()=>[s("Évalué")]),_:1}),e(d,null,{default:a(()=>[s("Évaluateur")]),_:1}),e(d,null,{default:a(()=>[s("Demandée par")]),_:1}),e(d,null,{default:a(()=>[s("Commentaire")]),_:1})])]),i("tbody",Z,[(n(!0),r(V,null,$(u.value,o=>(n(),r("tr",{key:o.rating_mobility_id},[e(m,{first:!0,class:"whitespace-pre-line"},{default:a(()=>[s(l(t.type.mobility_type_name),1)]),_:1}),e(m,null,{default:a(()=>[s(l(o.rating.evaluated.user_display_name),1)]),_:2},1024),e(m,null,{default:a(()=>[s(l(o.rating.evaluator.user_display_name),1)]),_:2},1024),e(m,{class:"whitespace-pre-line"},{default:a(()=>[s(l(o.asked_by.user_display_name),1)]),_:2},1024),e(m,{class:"whitespace-pre-line"},{default:a(()=>[s(l(o.rating_mobility_comment),1)]),_:2},1024)]))),128))])])):(n(),r("div",z," Aucun élément trouvé."))]),_:1},8,["pagination"])):(n(),_(C,{key:1,message:"Tous les agents ont été évalués",title:"Pas d'agent non évalué"}))])]),_:1}))}};export{X as default};
