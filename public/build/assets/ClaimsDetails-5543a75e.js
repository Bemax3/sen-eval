import{_ as x}from"./AuthenticatedLayout-a2654eb8.js";import{b,r as k,o as n,d as _,e as a,f as e,u as g,Z as w,a as i,t as l,c as d,g as s,k as D,F as V,j as $}from"./app-589b6ab5.js";import{g as B,a as C}from"./helper-9d93711f.js";import{_ as o,a as c,b as N}from"./EmptyState-fbc63e87.js";import{_ as R}from"./Breadcrumbs-65bf6fa9.js";import{_ as T}from"./Datatable-9e7bd542.js";import{r as j}from"./ArrowDownTrayIcon-4230dc7c.js";import"./logo1637145113-c7398df9.js";const A={class:"px-4 sm:px-6 lg:px-8"},F={class:"sm:flex sm:items-center"},L={class:"sm:flex-auto"},P={class:"text-2xl font-semibold leading-6 text-gray-900 dark:text-white"},S={class:"mt-2 text-sm text-gray-700 dark:text-white"},q={key:0,class:"space-x-2 mt-4 sm:ml-16 sm:mt-0 sm:flex-none"},E=["href"],O={key:0,class:"min-w-full divide-y divide-gray-300 dark:divide-black"},U={class:"bg-gray-50 dark:bg-grayish"},Z={class:"divide-y divide-gray-200 dark:divide-black bg-white dark:bg-grayish"},z={key:1,class:"text-center bg-white dark:bg-grayish text-lg text-gray-600 py-4"},h="",X={__name:"ClaimsDetails",props:{claims:{type:Object},phase:{},org:{},type:{}},setup(t){const m=t,p=[{name:"Statistiques",href:route("admin-dashboard.index",{org_id:m.org.org_id,phase_id:m.phase.phase_id}),current:!1},{name:"Détails des Réclamations demandées",href:"#",current:!0}],y=b(()=>B(m.claims)),u=k(m.claims.data);return(v,f)=>(n(),_(x,null,{default:a(()=>[e(g(w),{title:"Agents"}),i("div",A,[e(R,{pages:p}),i("div",F,[i("div",L,[i("h1",P,'Réclamation du type "'+l(t.type.claim_type_name)+`" pour l'année `+l(t.phase.phase_year)+" "+l(t.org!==-1?" - "+t.org.org_name:""),1),i("p",S," La liste des réclamations demandées pour l'année "+l(t.phase.phase_year)+". ",1)]),u.value.length>0?(n(),d("div",q,[i("a",{href:v.route("admin-dashboard.download-claims-details",{org_id:t.org.org_id,phase_id:t.phase.phase_id,type:t.type.claim_type_id}),class:"inline-flex gap-x-1.5 rounded-md bg-cyan-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"},[s(" Télécharger "),e(g(j),{class:"-mr-0.5 h-5 w-5"})],8,E)])):D("",!0)]),g(C)(t.claims.data)?(n(),_(T,{key:0,modelValue:h,"onUpdate:modelValue":f[0]||(f[0]=r=>h=r),pagination:y.value,search:!1},{default:a(()=>[u.value.length>0?(n(),d("table",O,[i("thead",U,[i("tr",null,[e(o,{first:!0},{default:a(()=>[s("Réclamation")]),_:1}),e(o,null,{default:a(()=>[s("Évalué")]),_:1}),e(o,null,{default:a(()=>[s("Évaluateur")]),_:1}),e(o,null,{default:a(()=>[s("Demandée par")]),_:1}),e(o,null,{default:a(()=>[s("Commentaire")]),_:1})])]),i("tbody",Z,[(n(!0),d(V,null,$(u.value,r=>(n(),d("tr",{key:r.rating_claim_id},[e(c,{first:!0,class:"whitespace-pre-line"},{default:a(()=>[s(l(t.type.claim_type_name),1)]),_:1}),e(c,null,{default:a(()=>[s(l(r.rating.evaluated.user_display_name),1)]),_:2},1024),e(c,null,{default:a(()=>[s(l(r.rating.evaluator.user_display_name),1)]),_:2},1024),e(c,{class:"whitespace-pre-line"},{default:a(()=>[s(l(r.rating.evaluated.user_display_name),1)]),_:2},1024),e(c,{class:"whitespace-pre-line"},{default:a(()=>[s(l(r.rating_claim_comment),1)]),_:2},1024)]))),128))])])):(n(),d("div",z," Aucun élément trouvé."))]),_:1},8,["pagination"])):(n(),_(N,{key:1,message:"Tous les agents ont été évalués",title:"Pas d'agent non évalué"}))])]),_:1}))}};export{X as default};
