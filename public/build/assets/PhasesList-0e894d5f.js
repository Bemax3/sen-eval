import{_ as k,g as $,h as A}from"./AuthenticatedLayout-a6827bda.js";import{_ as P}from"./Datatable-f7bebf15.js";import{_ as m,a as f}from"./TableData-551b2a58.js";import{o as r,c as u,a,b as V,r as B,d as D,w as x,e as h,f as s,g as e,u as i,Z as N,k as o,m as g,F as C,i as L,l as j,O as y,t as v,n as z}from"./app-009e6676.js";import{_ as O}from"./EmptyState-148efe32.js";import{_ as S}from"./Breadcrumbs-6f218844.js";import{_ as F}from"./ToggleOnDatatable-3676339b.js";import{r as M}from"./PlusIcon-1fd1de74.js";import{r as E}from"./PencilSquareIcon-009b9a21.js";import"./logo1637145113-11387d37.js";import"./switch-7eb20ab8.js";import"./use-controllable-a4a0a7b6.js";function H(_,d){return r(),u("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[a("path",{"fill-rule":"evenodd",d:"M7.84 1.804A1 1 0 018.82 1h2.36a1 1 0 01.98.804l.331 1.652a6.993 6.993 0 011.929 1.115l1.598-.54a1 1 0 011.186.447l1.18 2.044a1 1 0 01-.205 1.251l-1.267 1.113a7.047 7.047 0 010 2.228l1.267 1.113a1 1 0 01.206 1.25l-1.18 2.045a1 1 0 01-1.187.447l-1.598-.54a6.993 6.993 0 01-1.929 1.115l-.33 1.652a1 1 0 01-.98.804H8.82a1 1 0 01-.98-.804l-.331-1.652a6.993 6.993 0 01-1.929-1.115l-1.598.54a1 1 0 01-1.186-.447l-1.18-2.044a1 1 0 01.205-1.251l1.267-1.114a7.05 7.05 0 010-2.227L1.821 7.773a1 1 0 01-.206-1.25l1.18-2.045a1 1 0 011.187-.447l1.598.54A6.993 6.993 0 017.51 3.456l.33-1.652zM10 13a3 3 0 100-6 3 3 0 000 6z","clip-rule":"evenodd"})])}const T={class:"px-4 sm:px-6 lg:px-8"},U={class:"sm:flex sm:items-center"},Z=a("div",{class:"sm:flex-auto"},[a("h1",{class:"text-2xl font-semibold leading-6 text-gray-900"},"Phases d'évaluation"),a("p",{class:"mt-2 text-sm text-gray-700"}," La liste des phases d'évaluation ")],-1),q={class:"mt-4 sm:ml-16 sm:mt-0 sm:flex-none"},G={key:0,class:"min-w-full divide-y divide-gray-300"},I={class:"bg-gray-50"},J={class:"divide-y divide-gray-200 bg-white"},K={class:"flex space-x-4"},Q={class:"relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"},R={class:"flex items-center"},W={key:1,class:"text-center bg-white text-lg text-gray-600 py-4"},ue={__name:"PhasesList",props:{phases:{type:Object}},setup(_){const d=_,w=V(()=>$(d.phases)),n=B(d.phases.data),c=D({keyword:"",fields:["phase_name"]}),b=[{name:"Phase d'évaluation",href:"#",current:!0}];return x(()=>c.keyword,function(t){t===""?n.value=d.phases.data:j.post(route("phases.search"),c).then(p=>n.value=p.data)}),x(()=>d.phases,function(t){n.value=t.data,!n.value.length>0&&(t.prev_page_url?y.get(t.prev_page_url):y.get(t.first_page_url))}),(t,p)=>(r(),h(k,null,{default:s(()=>[e(i(N),{title:"Phases d'évaluation"}),a("div",T,[e(S,{pages:b}),a("div",U,[Z,a("div",q,[e(i(g),{href:t.route("phases.create"),as:"button",class:"inline-flex gap-x-1.5 rounded-md bg-cyan-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"},{default:s(()=>[o(" Ajouter une phase "),e(i(M),{class:"-mr-0.5 h-5 w-5"})]),_:1},8,["href"])])]),i(A)(_.phases.data)?(r(),h(P,{key:0,modelValue:c.keyword,"onUpdate:modelValue":p[0]||(p[0]=l=>c.keyword=l),pagination:w.value},{default:s(()=>[n.value.length>0?(r(),u("table",G,[a("thead",I,[a("tr",null,[e(m,{first:!0},{default:s(()=>[o("Nom")]),_:1}),e(m,null,{default:s(()=>[o("Année de l'évaluation")]),_:1}),e(m,null,{default:s(()=>[o("Activée")]),_:1}),e(m,null,{default:s(()=>[o("Details et modification")]),_:1})])]),a("tbody",J,[(r(!0),u(C,null,L(n.value,l=>(r(),u("tr",{key:l.phase_id},[e(f,{first:!0},{default:s(()=>[o(v(l.phase_name),1)]),_:2},1024),e(f,null,{default:s(()=>[o(v(l.phase_year),1)]),_:2},1024),e(f,null,{default:s(()=>[a("div",K,[e(F,{link:t.route("phases.update-status",{phase:l.phase_id}),value:l.phase_is_active,obj:"phase_is_active"},null,8,["link","value"]),a("span",{class:z([l.phase_is_active?"bg-green-50 text-green-700 ring-green-600/20":"bg-red-50 text-red-700 ring-red-600/20","rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset"])},v(l.phase_is_active?"Activé":"Désactivé"),3)])]),_:2},1024),a("td",Q,[a("div",R,[e(i(g),{href:t.route("phaseSkills.show",{phaseSkill:l.phase_id}),class:"group flex items-center px-4 py-2 text-sm"},{default:s(()=>[e(i(H),{"aria-hidden":"true",class:"mr-3 h-5 w-5 text-gray-400 group-hover:text-amber-600"})]),_:2},1032,["href"]),e(i(g),{href:t.route("phases.edit",{phase:l.phase_id}),class:"group flex items-center px-4 py-2 text-sm"},{default:s(()=>[e(i(E),{"aria-hidden":"true",class:"mr-3 h-5 w-5 text-gray-400 group-hover:text-cyan-600"})]),_:2},1032,["href"])])])]))),128))])])):(r(),u("div",W," Aucun élément trouvé."))]),_:1},8,["modelValue","pagination"])):(r(),h(O,{key:1,link:t.route("phases.create"),action:"Nouveau",message:"Créer un nouveau type en appuyant sur ce bouton",title:"Pas de type de réclamation"},null,8,["link"]))])]),_:1}))}};export{ue as default};
