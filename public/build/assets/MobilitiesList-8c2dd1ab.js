import{_ as w,g as T,h as $}from"./AuthenticatedLayout-4017efb7.js";import{_ as c,a as _}from"./TableData-ae9e5e20.js";import{_ as V}from"./Datatable-9005ab64.js";import{b as D,r as M,d as N,w as b,o as l,e as f,f as i,g as e,u as n,Z as j,a as t,k as o,m as v,c as p,F as B,i as A,l as C,O as h,t as y,n as L}from"./app-9f38d36c.js";import{r as O,_ as F}from"./EmptyState-81baf0f3.js";import{_ as P}from"./Breadcrumbs-2affa003.js";import{_ as S}from"./ToggleOnDatatable-31fe07f7.js";import{r as q}from"./PencilSquareIcon-eb46d74e.js";import"./logo1637145113-11387d37.js";import"./switch-a26d6b37.js";import"./use-controllable-d0f70e35.js";const z={class:"px-4 sm:px-6 lg:px-8"},E={class:"sm:flex sm:items-center"},U=t("div",{class:"sm:flex-auto"},[t("h1",{class:"text-2xl font-semibold leading-6 text-gray-900"},"Types de Mobilité"),t("p",{class:"mt-2 text-sm text-gray-700"},"La liste des mobilités qu'il sera possible de proposer ou demander lors de l'évaluation.")],-1),Z={class:"mt-4 sm:ml-16 sm:mt-0 sm:flex-none"},G={key:0,class:"min-w-full divide-y divide-gray-300"},H={class:"bg-gray-50"},I={class:"divide-y divide-gray-200 bg-white"},J={class:"flex space-x-4"},K={class:"relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"},Q={class:"flex items-center justify-center"},R={key:1,class:"text-center bg-white text-lg text-gray-600 py-4"},ne={__name:"MobilitiesList",props:{mobilities:{type:Object}},setup(g){const d=g,x=[{name:"Types de Mobilité",href:"#",current:!0}],k=D(()=>T(d.mobilities)),r=M(d.mobilities.data),m=N({keyword:"",fields:["mobility_type_name"]});return b(()=>m.keyword,function(s){s===""?r.value=d.mobilities.data:C.post(route("mobilityTypes.search"),m).then(u=>r.value=u.data)}),b(()=>d.mobilities,function(s){r.value=s.data,!r.value.length>0&&(s.prev_page_url?h.get(s.prev_page_url):h.get(s.first_page_url))}),(s,u)=>(l(),f(w,null,{default:i(()=>[e(n(j),{title:"Types de Mobilité"}),t("div",z,[e(P,{pages:x}),t("div",E,[U,t("div",Z,[e(n(v),{href:s.route("mobilityTypes.create"),as:"button",class:"inline-flex gap-x-1.5 rounded-md bg-cyan-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"},{default:i(()=>[o(" Ajouter un Type "),e(n(O),{class:"-mr-0.5 h-5 w-5"})]),_:1},8,["href"])])]),n($)(g.mobilities.data)?(l(),f(V,{key:0,modelValue:m.keyword,"onUpdate:modelValue":u[0]||(u[0]=a=>m.keyword=a),pagination:k.value},{default:i(()=>[r.value.length>0?(l(),p("table",G,[t("thead",H,[t("tr",null,[e(c,{first:!0},{default:i(()=>[o("Nom")]),_:1}),e(c,null,{default:i(()=>[o("Description")]),_:1}),e(c,null,{default:i(()=>[o("Status")]),_:1}),e(c,null,{default:i(()=>[o("Modifier")]),_:1})])]),t("tbody",I,[(l(!0),p(B,null,A(r.value,a=>(l(),p("tr",{key:a.mobility_type_id},[e(_,{first:!0},{default:i(()=>[o(y(a.mobility_type_name),1)]),_:2},1024),e(_,null,{default:i(()=>[o(y(a.mobility_type_desc),1)]),_:2},1024),e(_,null,{default:i(()=>[t("div",J,[e(S,{link:s.route("mobilityTypes.update",{mobilityType:a.mobility_type_id}),value:a.mobility_type_is_active,obj:"mobility_type_is_active"},null,8,["link","value"]),t("span",{class:L([a.mobility_type_is_active?"bg-green-50 text-green-700 ring-green-600/20":"bg-red-50 text-red-700 ring-red-600/20","inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset"])},y(a.mobility_type_is_active?"Activé":"Désactivé"),3)])]),_:2},1024),t("td",K,[t("div",Q,[e(n(v),{href:s.route("mobilityTypes.edit",{mobilityType:a.mobility_type_id}),class:"group flex items-center px-4 py-2 text-sm"},{default:i(()=>[e(n(q),{"aria-hidden":"true",class:"mr-3 h-5 w-5 text-gray-400 group-hover:text-cyan-600"})]),_:2},1032,["href"])])])]))),128))])])):(l(),p("div",R," Aucun élément trouvé."))]),_:1},8,["modelValue","pagination"])):(l(),f(F,{key:1,link:s.route("mobilityTypes.create"),action:"Nouveau",message:"Créer un nouveau type en appuyant sur ce bouton",title:"Pas de type de mobilité"},null,8,["link"]))])]),_:1}))}};export{ne as default};
