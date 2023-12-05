import{_ as D}from"./AuthenticatedLayout-60aabe79.js";import{b as A,h as E,r as y,w as $,A as O,o as l,d as b,e as a,f as s,u as p,Z as T,a as o,t as _,g as n,l as S,c as r,F as P,j as q,n as z,k as F,O as x,Q as L,m as M}from"./app-97f24108.js";import{_ as U}from"./Breadcrumbs-128d3fe8.js";import{g as Q,a as Z}from"./helper-00cc7808.js";import{_ as m,a as h,b as G}from"./EmptyState-e29df9ce.js";import{_ as H}from"./Datatable-bd1675da.js";import{_ as I}from"./ToggleOnDatatable-5fb430db.js";import{_ as J}from"./Separator-ebb927f5.js";import{_ as K}from"./SectionTitle-4e3f2362.js";import{r as R}from"./PencilSquareIcon-abbf943b.js";import{r as W}from"./CheckIcon-1e89fb52.js";import"./logo1637145113-c7398df9.js";import"./switch-4a375a0d.js";import"./use-controllable-5e55b309.js";const X={class:"px-4 sm:px-6 lg:px-8"},Y={class:"sm:flex sm:items-center"},ee={class:"sm:flex-auto"},te={class:"text-2xl font-semibold leading-6 text-gray-900 dark:text-white"},se=o("p",{class:"mt-2 text-sm text-gray-700 dark:text-white"}," Details et paramètres de l'évaluation. ",-1),ae={class:"space-x-2 mt-4 sm:ml-16 sm:mt-0 sm:flex-none"},ie={key:0,class:"min-w-full divide-y divide-gray-300 dark:divide-black"},le={class:"bg-gray-50 dark:bg-grayish"},oe={class:"divide-y divide-gray-200 dark:divide-black bg-white dark:bg-grayish"},ne={key:0,class:"flex items-center justify-center space-x-2"},re={class:"flex items-center justify-center space-x-4"},de=["value"],ue=o("p",{class:"ml-0.5"},"points",-1),ce=["onClick"],pe=["onClick"],_e={key:1,class:"text-center bg-white dark:bg-grayish text-lg text-gray-600 py-4"},Ve={__name:"PhaseSkills",props:{phase:{type:Object},skills:{type:Object}},setup(f){const d=f,V=[{name:"Phases d'évaluation",href:route("phases.index"),current:!1},{name:"Compétences",href:"#",current:!0}],j=A(()=>Q(d.skills)),c=E({keyword:"",fields:["skill_name"],phase_id:d.phase.phase_id}),u=y(d.skills.data),g=y([]),k=y([]),w=()=>u.value.forEach(t=>g.value.push({id:t.skill_id,edit:!1})),C=t=>g.value.filter(i=>i.id===t)[0].edit,B=t=>{const i=k.value[t];g.value.find(e=>e.id===t).edit=!1,x.put(route("phaseSkills.update",{phaseSkill:d.phase.phase_id}),{skill_id:t,phase_skill_marking:i.value},{onError:e=>{L().props.flash.notify={type:"error",message:e.phase_skill_marking}},onSuccess:()=>c.keyword=""})};return w(),$(()=>c.keyword,function(t){t===""?u.value=d.skills.data:M.post(route("phaseSkills.search"),c).then(i=>{u.value=i.data,w()}).catch(i=>console.log(i))}),$(()=>d.skills,function(t){u.value=t.data,!u.value.length>0&&(t.prev_page_url?x.get(t.prev_page_url):x.get(t.first_page_url))}),O(()=>k.value=[]),(t,i)=>(l(),b(D,null,{default:a(()=>[s(p(T),{title:"Paramètre de Phase"}),o("div",X,[s(U,{pages:V}),o("div",Y,[o("div",ee,[o("h1",te,"Paramètres "+_(f.phase.phase_name),1),se]),o("div",ae,[s(p(S),{href:t.route("phaseSkills.show",{phaseSkill:f.phase.phase_id}),as:"button",class:"inline-flex gap-x-1.5 rounded-md bg-cyan-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"},{default:a(()=>[n(" Compétences ")]),_:1},8,["href"]),s(p(S),{href:t.route("periods.show",{period:f.phase.phase_id}),as:"button",class:"inline-flex gap-x-1.5 rounded-md bg-cyan-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"},{default:a(()=>[n(" Périodes d'évaluation ")]),_:1},8,["href"])])]),s(J,{title:"Compétences"}),s(K,{desc:"La liste des compétences que les évaluateurs pourront noter lors de cette évaluation. Vous pouvez changer le barème de chaque compétence pour cette évaluation sans affecter les autres.",title:"Compétences"}),p(Z)(d.skills.data)?(l(),b(H,{key:0,modelValue:c.keyword,"onUpdate:modelValue":i[1]||(i[1]=e=>c.keyword=e),pagination:j.value},{default:a(()=>[u.value.length>0?(l(),r("table",ie,[o("thead",le,[o("tr",null,[s(m,{first:!0},{default:a(()=>[n("Nom")]),_:1}),s(m,null,{default:a(()=>[n("Status pour cette phase")]),_:1}),s(m,null,{default:a(()=>[n("Barème pour cette phase")]),_:1}),s(m,null,{default:a(()=>[n("College")]),_:1}),s(m,null,{default:a(()=>[n("Type")]),_:1})])]),o("tbody",oe,[(l(!0),r(P,null,q(u.value,e=>(l(),r("tr",{key:e.skill_id},[s(h,{first:!0,class:"whitespace-pre-line"},{default:a(()=>[n(_(e.skill_name),1)]),_:2},1024),s(h,null,{default:a(()=>[e.group?F("",!0):(l(),r("div",ne,[s(I,{data:{phase_skill_is_active:e.pivot.phase_skill_is_active,skill_id:e.skill_id},link:t.route("phaseSkills.update",{phaseSkill:f.phase.phase_id}),value:e.pivot.phase_skill_is_active,obj:"phase_skill_is_active",onToggled:i[0]||(i[0]=v=>c.keyword="")},null,8,["data","link","value"]),o("span",{class:z([e.pivot.phase_skill_is_active?"bg-green-50 text-green-700 ring-green-600/20 dark:bg-green-600 dark:text-white":"bg-red-50 text-red-700 ring-red-600/20 dark:bg-red-600 dark:text-white","rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset"])},_(e.pivot.phase_skill_is_active?"Activé":"Désactivé"),3)]))]),_:2},1024),s(h,null,{default:a(()=>[o("div",re,[C(e.skill_id)?(l(),r("input",{key:1,ref_for:!0,ref:v=>{k.value[e.skill_id]=v},value:e.pivot.phase_skill_marking,class:"w-10 rounded-md border-0 py-1.5 text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-cyan-700 sm:text-sm sm:leading-6",type:"text"},null,8,de)):(l(),r(P,{key:0},[n(_(e.pivot.phase_skill_marking),1)],64)),ue,C(e.skill_id)?(l(),r("button",{key:3,class:"rounded-full bg-cyan-600 p-2 text-white shadow-sm hover:bg-cyan-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600",type:"button",onClick:v=>B(e.skill_id)},[s(p(W),{"aria-hidden":"true",class:"h-5 w-5"})],8,pe)):(l(),r("button",{key:2,class:"rounded-full bg-cyan-600 p-2 text-white shadow-sm hover:bg-cyan-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600",type:"button",onClick:v=>g.value.find(N=>N.id===e.skill_id).edit=!0},[s(p(R),{"aria-hidden":"true",class:"h-5 w-5"})],8,ce))])]),_:2},1024),s(h,null,{default:a(()=>[n(_(e.group?e.group.group_name:"Commun"),1)]),_:2},1024),s(h,null,{default:a(()=>[n(_(e.type.skill_type_name),1)]),_:2},1024)]))),128))])])):(l(),r("div",_e," Aucun élément trouvé."))]),_:1},8,["modelValue","pagination"])):(l(),b(G,{key:1,link:t.route("phases.create"),action:"Nouveau",message:"Ajouter des compétences a évaluer lors de cette phase.",title:"Pas de Compétence affecté à cette phase."},null,8,["link"]))])]),_:1}))}};export{Ve as default};
