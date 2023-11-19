import{Q as F,b as V,r as S,T as N,w as z,o as n,e as v,f as s,g as e,u as a,Z as H,a as i,c as o,k as d,n as p,t as m,p as P,F as C,i as E,j as y,h as q,O as B}from"./app-3e4b2772.js";import{h as k,_ as L,g as Q}from"./AuthenticatedLayout-3ac73bac.js";import{_ as R,a as Z}from"./Title-9f03dc8d.js";import{_ as G}from"./Breadcrumbs-51f948bf.js";import{_ as I}from"./Separator-96913dff.js";import{_ as J}from"./SubmitButton-7f722cda.js";import{_ as K}from"./InputError-35896e53.js";import{_ as W}from"./Datatable-4bce3106.js";import{_ as X}from"./EmptyState-74c2db4d.js";import{_ as f,a as h}from"./TableData-81b0e721.js";import{_ as Y}from"./TextArea-899d3dd8.js";import{_ as ee}from"./FormIndications-a1b732ed.js";import{_ as A}from"./InputLabel-57921aff.js";import{r as te}from"./ChevronUpDownIcon-1b8e9b2e.js";import{r as ae}from"./CheckIcon-433ec1c5.js";import{r as se}from"./TrashIcon-183a4f2b.js";import{N as ie,H as ne,B as re,U as le}from"./listbox-3d2e36ea.js";import"./logo1637145113-11387d37.js";import"./PlusIcon-a937723d.js";import"./use-controllable-49f1610e.js";const oe={class:"px-4 sm:px-6 lg:px-8"},de=["onSubmit"],ue=i("h3",{class:"text-base font-semibold leading-6 text-gray-900"},"Demander une formation",-1),me=i("div",{class:"mt-2 max-w-xl text-sm text-gray-500"},[i("p",null,"Demander une formation et ajouter la á la liste des demandes pour cette évaluation. ")],-1),_e={class:"px-4 py-6 sm:p-8"},ce={class:"grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6"},ge={class:"col-span-full relative"},pe={class:"relative"},fe={key:0,class:"block truncate"},ve={key:1,class:"block truncate"},ye={class:"pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2"},he={class:"col-span-full"},xe={class:"mt-2"},be={class:"flex items-center justify-between gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8"},ke={key:0,class:"min-w-full divide-y divide-gray-300"},we={class:"bg-gray-50"},$e={class:"divide-y divide-gray-200 bg-white"},Ve={class:"relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"},De={key:0,class:"flex items-center justify-center"},Ne=["onClick"],Ce={key:1,class:"text-center bg-white text-lg text-gray-600 py-4"},T="",Je={__name:"RatingTrainings",props:{agent:{},rating:{},types:{type:Array},trainings:{}},setup(l){const r=l,w=F().props.auth.user,_=V(()=>w.user_id===r.rating.evaluated_id),x=V(()=>w.user_id!==r.rating.evaluated_id&&w.user_id!==r.rating.evaluator_id),U=_.value?[{name:"Mes Evaluations",href:route("ratings.index",{agent_rating:r.rating.rating_id}),current:!1},{name:"Evaluation",href:"#",current:!0}]:x?[{name:"Mes validations",href:route("validations.index"),current:!1},{name:"Évaluation",href:"#",current:!0}]:[{name:"Mes Agents",href:route("agents.index"),current:!1},{name:"Evaluations",href:route("agent-ratings.index",{agent:r.agent.user_id}),current:!1},{name:"Evaluation",href:"#",current:!0}],j=V(()=>Q(r.trainings)),b=S(r.trainings.data),u=N(_.value?{asked_by_evaluated:1,training_type_id:null,comment:""}:{asked_by_evaluator:1,training_type_id:null,comment:""});u.training_type_id=k(r.types)?r.types[0].training_type_id:null;const M=N(_.value?{asked_by_evaluated:0}:{asked_by_evaluator:0}),O=()=>u.post(route("rating-trainings.store",{rating:r.rating.rating_id}));return z(()=>r.trainings,function(c){b.value=c.data,!b.value.length>0&&(c.prev_page_url?B.get(c.prev_page_url):B.get(c.first_page_url))}),(c,g)=>(n(),v(L,null,{default:s(()=>[e(a(H),{title:"Profil"}),i("div",oe,[e(G,{pages:a(U)},null,8,["pages"]),e(R,{agent:l.agent,rating:l.rating},null,8,["agent","rating"]),e(Z,{agent_id:r.agent.user_id,evaluated:_.value,rating_id:r.rating.rating_id,validator:x.value},null,8,["agent_id","evaluated","rating_id","validator"]),!x.value&&!l.rating.rating_is_validated?(n(),o("form",{key:0,class:"mt-8 bg-white px-4 py-5 sm:p-6 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2",onSubmit:q(O,["prevent"])},[ue,me,i("div",_e,[i("div",ce,[i("div",ge,[e(A,{for:"",required:""},{default:s(()=>[d("Nature")]),_:1}),e(a(re),{modelValue:a(u).training_type_id,"onUpdate:modelValue":g[0]||(g[0]=t=>a(u).training_type_id=t)},{default:s(()=>[i("div",pe,[e(a(ie),{class:p([a(u).errors.phase_id?"ring-red-300":"ring-gray-300","w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset focus:outline-none focus:ring-2 focus:ring-cyan-600 sm:text-sm sm:leading-6"])},{default:s(()=>[a(k)(l.types)?(n(),o("span",fe,m(l.types.filter(t=>t.training_type_id===a(u).training_type_id)[0].training_type_name),1)):(n(),o("span",ve,"Aucune formation disponible pour l'instant.")),i("span",ye,[e(a(te),{"aria-hidden":"true",class:"h-5 w-5 text-gray-400"})])]),_:1},8,["class"]),e(P,{"leave-active-class":"transition ease-in duration-100","leave-from-class":"opacity-100","leave-to-class":"opacity-0"},{default:s(()=>[a(k)(l.types)?(n(),v(a(ne),{key:0,class:"absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"},{default:s(()=>[(n(!0),o(C,null,E(l.types,t=>(n(),v(a(le),{key:t.training_type_id,value:t.training_type_id,as:"template"},{default:s(({active:$,selected:D})=>[i("li",{class:p([$?"bg-cyan-600 text-white":"text-gray-900","relative cursor-default select-none py-2 pl-3 pr-9"])},[i("span",{class:p([D?"font-semibold":"font-normal","block truncate"])},m(t.training_type_name),3),D?(n(),o("span",{key:0,class:p([$?"text-white":"text-cyan-600","absolute inset-y-0 right-0 flex items-center pr-4"])},[e(a(ae),{"aria-hidden":"true",class:"h-5 w-5"})],2)):y("",!0)],2)]),_:2},1032,["value"]))),128))]),_:1})):y("",!0)]),_:1})])]),_:1},8,["modelValue"]),e(K,{message:a(u).errors.training_type_id},null,8,["message"])]),i("div",he,[e(A,{for:""},{default:s(()=>[d("Commentaire")]),_:1}),i("div",xe,[e(Y,{modelValue:a(u).comment,"onUpdate:modelValue":g[1]||(g[1]=t=>a(u).comment=t)},null,8,["modelValue"])])])])]),i("div",be,[e(ee),e(J,{disabled:l.rating.rating_is_validated,processing:a(u).processing,class:"mt-3 sm:ml-3 sm:mt-0 sm:w-auto",type:"submit"},{default:s(()=>[d("Enregistrer ")]),_:1},8,["disabled","processing"])])],40,de)):y("",!0),e(I,{title:"Formations Demandées"}),a(k)(l.trainings.data)?(n(),v(W,{key:1,modelValue:T,"onUpdate:modelValue":g[2]||(g[2]=t=>T=t),pagination:j.value,search:!1},{default:s(()=>[b.value.length>0?(n(),o("table",ke,[i("thead",we,[i("tr",null,[e(f,{first:!0},{default:s(()=>[d("Type")]),_:1}),e(f,null,{default:s(()=>[d("Demandée par l'évaluateur")]),_:1}),e(f,null,{default:s(()=>[d("Demandée par l'évalué")]),_:1}),e(f,{class:"whitespace-pre-line"},{default:s(()=>[d("Commentaire de l'évaluateur")]),_:1}),e(f,{class:"whitespace-pre-line"},{default:s(()=>[d("Commentaire de l'évalué")]),_:1}),e(f)])]),i("tbody",$e,[(n(!0),o(C,null,E(b.value,t=>(n(),o("tr",{key:t.rating_training_id},[e(h,{first:!0,class:"whitespace-pre-line"},{default:s(()=>[d(m(t.type.training_type_name),1)]),_:2},1024),e(h,null,{default:s(()=>[i("span",{class:p([t.asked_by_evaluator?"bg-green-50 text-green-700 ring-green-600/20":"bg-red-50 text-red-700 ring-red-600/20","inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset"])},m(t.asked_by_evaluator?"Oui":"Non"),3)]),_:2},1024),e(h,null,{default:s(()=>[i("span",{class:p([t.asked_by_evaluated?"bg-green-50 text-green-700 ring-green-600/20":"bg-red-50 text-red-700 ring-red-600/20","inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset"])},m(t.asked_by_evaluated?"Oui":"Non"),3)]),_:2},1024),e(h,{class:"whitespace-pre-line"},{default:s(()=>[d(m(t.evaluator_comment||"__"),1)]),_:2},1024),e(h,{class:"whitespace-pre-line"},{default:s(()=>[d(m(t.evaluated_comment||"__"),1)]),_:2},1024),i("td",Ve,[l.rating.rating_is_validated?y("",!0):(n(),o("div",De,[!x.value&&(_.value&&t.asked_by_evaluated||!_.value&&t.asked_by_evaluator)?(n(),o("button",{key:0,class:"rounded-lg bg-red-600 p-2 text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600",type:"button",onClick:$=>a(M).put(c.route("rating-trainings.update",{rating:l.rating.rating_id,rating_training:t.rating_training_id}))},[e(a(se),{"aria-hidden":"true",class:"h-5 w-5"})],8,Ne)):y("",!0)]))])]))),128))])])):(n(),o("div",Ce," Aucun élément trouvé."))]),_:1},8,["pagination"])):(n(),v(X,{key:2,message:"Demander une formation en utilisant la liste déroulante en haut.",title:"Aucune formation demandée pour l'instant."}))])]),_:1}))}};export{Je as default};
