import{_ as y}from"./AuthenticatedLayout-60aabe79.js";import{b,r as k,o as r,d as _,e as a,f as e,u as o,Z as w,a as t,t as l,c as u,g as i,k as V,F as $,j as N,n as j,l as B}from"./app-97f24108.js";import{_ as D}from"./Breadcrumbs-128d3fe8.js";import{g as A,a as C}from"./helper-00cc7808.js";import{_ as P}from"./Datatable-bd1675da.js";import{_ as d,a as c,b as E}from"./EmptyState-e29df9ce.js";import{r as F}from"./ArrowDownTrayIcon-473920c2.js";import{r as L}from"./EyeIcon-17ce3fa6.js";import"./logo1637145113-c7398df9.js";const S={class:"px-4 sm:px-6 lg:px-8"},T={class:"sm:flex sm:items-center"},q={class:"sm:flex-auto"},z={class:"text-2xl font-semibold leading-6 text-gray-900 dark:text-white"},M={class:"mt-2 text-sm text-gray-700 dark:text-white"},O={key:0,class:"space-x-2 mt-4 sm:ml-16 sm:mt-0 sm:flex-none"},U=["href"],Z={key:0,class:"min-w-full divide-y divide-gray-300 dark:divide-black"},G={class:"bg-gray-50 dark:bg-grayish"},H={class:"divide-y divide-gray-200 dark:divide-black bg-white dark:bg-grayish"},I={class:"flex-shrink-0"},J={class:"flex h-10 w-10 items-center justify-center rounded-full border-2 border-cyan-600"},K={class:"text-cyan-700"},Q={class:"relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"},R={class:"flex items-center justify-center"},W={key:1,class:"text-center bg-white dark:bg-grayish text-lg text-gray-600 py-4"},p="",le={__name:"PendingDetails",props:{ratings:{type:Object},phase:{},org:{}},setup(n){const m=n,x=[{name:"Statistiques",href:route("admin-dashboard.index",{org_id:m.org.org_id,phase_id:m.phase.phase_id}),current:!1},{name:"Évaluations Non Validées",href:"#",current:!0}],v=b(()=>A(m.ratings)),g=k(m.ratings.data);return(h,f)=>(r(),_(y,null,{default:a(()=>[e(o(w),{title:"Mes Èvaluations"}),t("div",S,[e(D,{pages:x}),t("div",T,[t("div",q,[t("h1",z,"Évaluations en attente de validation en "+l(n.phase.phase_year)+" "+l(n.org!==-1?" - "+n.org.org_name:""),1),t("p",M," Liste des évaluations en attente de validation pour l'année "+l(n.phase.phase_year)+". ",1)]),g.value.length>0?(r(),u("div",O,[t("a",{href:h.route("admin-dashboard.download-pending",{org_id:n.org.org_id,phase_id:n.phase.phase_id}),class:"inline-flex gap-x-1.5 rounded-md bg-cyan-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"},[i(" Télécharger "),e(o(F),{class:"-mr-0.5 h-5 w-5"})],8,U)])):V("",!0)]),o(C)(n.ratings.data)?(r(),_(P,{key:0,modelValue:p,"onUpdate:modelValue":f[0]||(f[0]=s=>p=s),pagination:v.value,search:!1},{default:a(()=>[g.value.length>0?(r(),u("table",Z,[t("thead",G,[t("tr",null,[e(d,{first:!0},{default:a(()=>[i("Évaluateur")]),_:1}),e(d,null,{default:a(()=>[i("Évalué")]),_:1}),e(d,null,{default:a(()=>[i("Année")]),_:1}),e(d,null,{default:a(()=>[i("Note")]),_:1}),e(d,null,{default:a(()=>[i("Validation")]),_:1}),e(d)])]),t("tbody",H,[(r(!0),u($,null,N(g.value,s=>(r(),u("tr",{key:s.rating_id},[e(c,{first:!0,class:"whitespace-pre-line"},{default:a(()=>[i(l(s.evaluator.user_display_name+" "+s.evaluator.user_matricule),1)]),_:2},1024),e(c,{class:"whitespace-pre-line"},{default:a(()=>[i(l(s.evaluated.user_display_name+" "+s.evaluated.user_matricule),1)]),_:2},1024),e(c,null,{default:a(()=>[i(l(s.phase.phase_year),1)]),_:2},1024),e(c,null,{default:a(()=>[t("span",I,[t("span",J,[t("span",K,l(s.rating_mark),1)])])]),_:2},1024),e(c,null,{default:a(()=>[t("span",{class:j([s.rating_is_validated?"bg-green-50 text-green-700 ring-green-600/20 dark:bg-green-600 dark:text-white":"bg-red-50 text-red-700 ring-red-600/20 dark:bg-red-600 dark:text-white","inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset"])},l(s.rating_is_validated?"Validé":"En attente"),3)]),_:2},1024),t("td",Q,[t("div",R,[e(o(B),{href:h.route("ratings.show",{rating:s.rating_id}),class:"group flex items-center px-4 py-2 text-sm"},{default:a(()=>[e(o(L),{"aria-hidden":"true",class:"mr-3 h-5 w-5 text-gray-400 group-hover:text-cyan-600"})]),_:2},1032,["href"])])])]))),128))])])):(r(),u("div",W,"Aucun élément trouvé."))]),_:1},8,["pagination"])):(r(),_(E,{key:1,message:"Aucune évaluation en attende de validation pour l'instant.",title:"Pas d'évaluations"}))])]),_:1}))}};export{le as default};
