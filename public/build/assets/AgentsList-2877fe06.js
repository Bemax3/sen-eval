import{o as d,c as y,a as s,r as v,w as M,b as Q,d as x,e as a,f as e,u as r,g as o,O as j,T as P,h as S,Z as X,i as Y,n as V,j as T,t as c,k as D,F as O,l as G,Q as H,m as R}from"./app-97f24108.js";import{_ as Z}from"./AuthenticatedLayout-60aabe79.js";import{_ as I}from"./Datatable-bd1675da.js";import{_ as g,a as h,b as K}from"./EmptyState-e29df9ce.js";import{U as W,h as F,G as ee,V as te,S as se,g as ae,a as re}from"./helper-00cc7808.js";import{_ as le}from"./Breadcrumbs-128d3fe8.js";import{_ as U}from"./Separator-ebb927f5.js";import{_ as oe}from"./SubmitButton-ac7c7d0a.js";import{r as ie}from"./ExclamationTriangleIcon-46c414a4.js";import{Q as ne,G as de,X as ue,Y as me,J as ce}from"./combobox-8b7fd72b.js";import{r as ge}from"./ChevronUpDownIcon-7bd5fcff.js";import{r as fe}from"./CheckIcon-1e89fb52.js";import{r as pe}from"./EyeIcon-17ce3fa6.js";import{r as _e}from"./TrashIcon-9fcee4f2.js";import"./logo1637145113-c7398df9.js";import"./use-controllable-5e55b309.js";function he(w,u){return d(),y("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[s("path",{"fill-rule":"evenodd",d:"M1 6a3 3 0 013-3h12a3 3 0 013 3v8a3 3 0 01-3 3H4a3 3 0 01-3-3V6zm4 1.5a2 2 0 114 0 2 2 0 01-4 0zm2 3a4 4 0 00-3.665 2.395.75.75 0 00.416 1A8.98 8.98 0 007 14.5a8.98 8.98 0 003.249-.604.75.75 0 00.416-1.001A4.001 4.001 0 007 10.5zm5-3.75a.75.75 0 01.75-.75h2.5a.75.75 0 010 1.5h-2.5a.75.75 0 01-.75-.75zm0 6.5a.75.75 0 01.75-.75h2.5a.75.75 0 010 1.5h-2.5a.75.75 0 01-.75-.75zm.75-4a.75.75 0 000 1.5h2.5a.75.75 0 000-1.5h-2.5z","clip-rule":"evenodd"})])}const ye=s("div",{class:"fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"},null,-1),ve={class:"fixed inset-0 z-10 w-screen overflow-y-auto"},xe={class:"flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"},we={class:"sm:flex sm:items-start"},be={class:"mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10"},ke={class:"mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left"},$e=s("div",{class:"mt-2"},[s("p",{class:"text-sm text-gray-500 dark:text-gray-100"},"Êtes vous sûre de vouloir continuer ? Vous aller retirer cet agent de votre liste.")],-1),Ce={class:"mt-5 sm:mt-4 sm:flex sm:flex-row-reverse"},Ve={__name:"RemoveAgentModal",props:{opened:{type:Boolean,default:!1},id:{type:Number||null,default:null}},emits:["closeModal"],setup(w){const u=w,f=v(!1);M(()=>u.opened,m=>{f.value=m},{immediate:!0});const b=Q(()=>u.id),z=()=>{j.put(route("agents.update",{agent:b.value}))};return(m,i)=>(d(),x(r(se),{show:f.value,as:"template"},{default:a(()=>[e(r(W),{as:"div",class:"relative z-10",onClose:i[2]||(i[2]=p=>{f.value=!1,m.$emit("closeModal")})},{default:a(()=>[e(r(F),{as:"template",enter:"ease-out duration-300","enter-from":"opacity-0","enter-to":"opacity-100",leave:"ease-in duration-200","leave-from":"opacity-100","leave-to":"opacity-0"},{default:a(()=>[ye]),_:1}),s("div",ve,[s("div",xe,[e(r(F),{as:"template",enter:"ease-out duration-300","enter-from":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95","enter-to":"opacity-100 translate-y-0 sm:scale-100",leave:"ease-in duration-200","leave-from":"opacity-100 translate-y-0 sm:scale-100","leave-to":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"},{default:a(()=>[e(r(ee),{class:"relative transform overflow-hidden rounded-lg bg-white dark:bg-grayish px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6"},{default:a(()=>[s("div",we,[s("div",be,[e(r(ie),{"aria-hidden":"true",class:"h-6 w-6 text-red-600"})]),s("div",ke,[e(r(te),{as:"h3",class:"text-base font-semibold leading-6 text-gray-900 dark:text-white"},{default:a(()=>[o("Suppression")]),_:1}),$e])]),s("div",Ce,[s("button",{class:"inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto",type:"button",onClick:i[0]||(i[0]=p=>{z(),f.value=!1,m.$emit("closeModal")})},"Supprimer "),s("button",{ref:"cancelButtonRef",class:"mt-3 inline-flex w-full justify-center rounded-md bg-white dark:bg-grayish px-3 py-2 text-sm font-semibold text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto",type:"button",onClick:i[1]||(i[1]=p=>{f.value=!1,m.$emit("closeModal")})},"Annuler ",512)])]),_:1})]),_:1})])])]),_:1})]),_:1},8,["show"]))}},Me={class:"px-4 sm:px-6 lg:px-8"},ze=s("div",{class:"sm:flex sm:items-center"},[s("div",{class:"sm:flex-auto"},[s("h1",{class:"text-2xl font-semibold leading-6 text-gray-900 dark:text-white"},"Mes Agents"),s("p",{class:"mt-2 text-sm text-gray-700 dark:text-white"}," La liste de mes agents à évaluer. ")])],-1),Ae={class:"bg-white dark:bg-grayish shadow sm:rounded-lg"},je={class:"px-4 py-5 sm:p-6"},Ne=s("h3",{class:"text-base font-semibold leading-6 text-gray-900 dark:text-white"},"Trouver vos agents",-1),Be=s("div",{class:"mt-2 max-w-xl text-sm text-gray-500 dark:text-gray-100"},[s("p",null,"Rechercher les agents que vous devrez évaluer en utilisant leur matricule, nom ou prénom. ")],-1),Le=["onSubmit"],Se={class:"w-full sm:max-w-xl"},Te={class:"relative"},De={class:"flex"},Oe={key:0,class:"min-w-full divide-y divide-gray-300 dark:divide-black"},Ge={class:"bg-gray-50 dark:bg-grayish"},Re={class:"divide-y divide-gray-200 dark:divide-black bg-white dark:bg-grayish"},Fe={class:"relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"},Ue={class:"flex items-center justify-center"},Qe=["onClick"],qe={key:1,class:"text-center bg-white dark:bg-grayish text-lg text-gray-600 py-4"},ot={__name:"AgentsList",props:{agents:{type:Object},others:{type:Object}},setup(w){var L;const u=w,f=[{name:"Mes Agents",href:"#",current:!0}],b=u.others,z=Q(()=>ae(u.agents)),m=P({agent_id:null}),i=v(u.agents.data),p=S({keyword:"",fields:["user_display_name","user_matricule"]}),N=S({keyword:"",fields:["user_display_name","user_matricule"]}),$=v(""),k=v(b),A=v(!1),B=v((L=u.agents[0])==null?void 0:L.agent_id),q=()=>{m.post(route("agents.store"),{onError:l=>{H().props.flash.notify={type:"error",message:l.agent_id}}})},E=l=>{A.value=!0,B.value=l},J=()=>R.post(route("users.search"),N);return M(()=>$.value,function(l){let n=l===""?b:b.filter(t=>t.user_matricule.toLowerCase().includes($.value.toLowerCase())||t.user_display_name.toLowerCase().includes($.value.toLowerCase()));n.length>0?k.value=n:l.length>=3&&J().then(t=>k.value=t.data)}),M(()=>p.keyword,function(l){l===""?i.value=u.agents.data:R.post(route("agents.search"),p).then(n=>i.value=n.data)}),M(()=>u.agents,function(l){i.value=l.data,!i.value.length>0&&(l.prev_page_url?j.get(l.prev_page_url):j.get(l.first_page_url))}),(l,n)=>(d(),x(Z,null,{default:a(()=>[e(r(X),{title:"Mes Agents"}),s("div",Me,[e(le,{pages:f}),ze,e(U,{title:"Trouver mes agents"}),s("div",Ae,[s("div",je,[Ne,Be,s("form",{class:"mt-5 sm:flex sm:items-center",onSubmit:Y(q,["prevent"])},[s("div",Se,[e(r(ce),{modelValue:r(m).agent_id,"onUpdate:modelValue":n[1]||(n[1]=t=>r(m).agent_id=t)},{default:a(()=>[s("div",Te,[e(r(ne),{class:V([r(m).errors.agent_id!==void 0?"focus:ring-red-600 ring-red-600":"","w-full rounded-md border-0 bg-white dark:bg-grayish py-1.5 pl-3 pr-12 text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 focus:ring-2 focus:ring-inset focus:ring-cyan-700 sm:text-sm sm:leading-6"]),"display-value":t=>{let _=k.value.filter(C=>C.user_id===t)[0];return _?_.user_matricule+" "+_.user_display_name:""},placeholder:"Chercher un agent...",onChange:n[0]||(n[0]=t=>{N.keyword=$.value=t.target.value})},null,8,["class","display-value"]),e(r(de),{class:"absolute inset-y-0 right-0 flex items-center rounded-r-md px-2 focus:outline-none"},{default:a(()=>[e(r(ge),{"aria-hidden":"true",class:"h-5 w-5 text-gray-400"})]),_:1}),k.value.length>0?(d(),x(r(ue),{key:0,class:"absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white dark:bg-grayish py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"},{default:a(()=>[(d(!0),y(O,null,T(k.value,t=>(d(),x(r(me),{key:t.user_id,value:t.user_id,as:"template"},{default:a(({active:_,selected:C})=>[s("li",{class:V(["relative cursor-default select-none py-2 pl-3 pr-9",_?"bg-cyan-600  text-white":"text-gray-900 dark:text-white"])},[s("div",De,[s("span",{class:V(["truncate",C&&"font-semibold"])},c((t==null?void 0:t.user_matricule)+" "+(t==null?void 0:t.user_display_name)),3)]),C?(d(),y("span",{key:0,class:V(["absolute inset-y-0 right-0 flex items-center pr-4",_?"text-white":"text-cyan-600"])},[e(r(fe),{"aria-hidden":"true",class:"h-5 w-5"})],2)):D("",!0)],2)]),_:2},1032,["value"]))),128))]),_:1})):D("",!0)])]),_:1},8,["modelValue"])]),e(oe,{class:"mt-3 sm:ml-3 sm:mt-0 sm:w-auto",type:"submit"},{default:a(()=>[o("Ajouter")]),_:1})],40,Le)])]),e(U,{title:"Mes agents"}),r(re)(w.agents.data)?(d(),x(I,{key:0,modelValue:p.keyword,"onUpdate:modelValue":n[2]||(n[2]=t=>p.keyword=t),pagination:z.value},{default:a(()=>[i.value.length>0?(d(),y("table",Oe,[s("thead",Ge,[s("tr",null,[e(g,{first:!0},{default:a(()=>[o("Matricule")]),_:1}),e(g,null,{default:a(()=>[o("Nom")]),_:1}),e(g,null,{default:a(()=>[o("Poste")]),_:1}),e(g,null,{default:a(()=>[o("GF")]),_:1}),e(g,null,{default:a(()=>[o("NR")]),_:1}),e(g,null,{default:a(()=>[o("CR")]),_:1}),e(g,null,{default:a(()=>[o("Organisation")]),_:1}),e(g)])]),s("tbody",Re,[(d(!0),y(O,null,T(i.value,t=>(d(),y("tr",{key:t.user_id},[e(h,{first:!0,class:"whitespace-pre-line"},{default:a(()=>[o(c(t.user_matricule),1)]),_:2},1024),e(h,null,{default:a(()=>[o(c(t.user_display_name),1)]),_:2},1024),e(h,{class:"whitespace-pre-line"},{default:a(()=>[o(c(t.user_title),1)]),_:2},1024),e(h,null,{default:a(()=>[o(c(t.user_gf),1)]),_:2},1024),e(h,null,{default:a(()=>[o(c(t.user_nr),1)]),_:2},1024),e(h,null,{default:a(()=>[o(c(t.user_responsibility_center),1)]),_:2},1024),e(h,{class:"whitespace-pre-line"},{default:a(()=>[o(c(t.org?t.org.org_name:"No Org"),1)]),_:2},1024),s("td",Fe,[s("div",Ue,[e(r(G),{href:l.route("agent-ratings.index",{agent:t.user_id}),class:"group flex items-center px-4 py-2 text-sm"},{default:a(()=>[e(r(pe),{"aria-hidden":"true",class:"mr-3 h-5 w-5 text-gray-400 group-hover:text-cyan-600"})]),_:2},1032,["href"]),e(r(G),{href:l.route("agents.show",{agent:t.user_id}),class:"group flex items-center px-4 py-2 text-sm"},{default:a(()=>[e(r(he),{"aria-hidden":"true",class:"mr-3 h-5 w-5 text-gray-400 group-hover:text-amber-600"})]),_:2},1032,["href"]),s("button",{class:"group flex items-center px-4 py-2 text-sm",onClick:_=>E(t.user_id)},[e(r(_e),{"aria-hidden":"true",class:"mr-3 h-5 w-5 text-gray-400 group-hover:text-red-600"})],8,Qe)])])]))),128))])])):(d(),y("div",qe," Aucun élément trouvé."))]),_:1},8,["modelValue","pagination"])):(d(),x(K,{key:1,message:"Trouver vos agents à l'aide de la barre de recherche plus haut",title:"Vous n'avez aucun agent a évaluer."})),e(Ve,{id:B.value,opened:A.value,onCloseModal:n[3]||(n[3]=t=>A.value=!1)},null,8,["id","opened"])])]),_:1}))}};export{ot as default};
