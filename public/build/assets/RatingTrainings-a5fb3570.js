import{_ as U}from"./AuthenticatedLayout-60aabe79.js";import{r as y,w as B,o as u,d as w,e as a,f as e,u as n,a as t,g as m,Q as G,b as V,T as L,Z as P,c as p,k as E,F as Q,j as Z,t as h,n as N,O as S}from"./app-97f24108.js";import{_ as q,a as H}from"./Title-08694859.js";import{_ as I}from"./Breadcrumbs-128d3fe8.js";import{U as J,h as T,G as K,V as W,S as X,g as Y,a as ee}from"./helper-00cc7808.js";import{_ as te}from"./Datatable-bd1675da.js";import{r as ae,_,a as b,b as se}from"./EmptyState-e29df9ce.js";import{r as ie}from"./ExclamationTriangleIcon-46c414a4.js";import ne from"./SaveTrainingModal-4e42d534.js";import{_ as re}from"./SectionTitle-4e3f2362.js";import{r as le}from"./PencilSquareIcon-abbf943b.js";import{r as oe}from"./TrashIcon-9fcee4f2.js";import"./logo1637145113-c7398df9.js";import"./InputLabel-29a6a3dc.js";import"./InputError-cd59225c.js";import"./TextArea-6aebc6cb.js";import"./FormIndications-b5d9b5bb.js";import"./SubmitButton-ac7c7d0a.js";import"./CheckIcon-1e89fb52.js";import"./ChevronUpDownIcon-7bd5fcff.js";import"./CheckIcon-b96e0b0f.js";import"./listbox-20c62403.js";import"./use-controllable-5e55b309.js";const de=t("div",{class:"fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"},null,-1),ue={class:"fixed inset-0 z-10 w-screen overflow-y-auto"},me={class:"flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"},ce={class:"sm:flex sm:items-start"},ge={class:"mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10"},fe={class:"mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left"},ve=t("div",{class:"mt-2"},[t("p",{class:"text-sm text-gray-500 dark:text-gray-100"},"Êtes vous sûre de vouloir continuer ? Cette action est irréversible.")],-1),pe={class:"mt-5 sm:mt-4 sm:flex sm:flex-row-reverse"},_e={__name:"RevokeTraining",props:{opened:{type:Boolean,default:!1},link:{type:String},form:{}},emits:["closeModal"],setup(r){const i=r,c=y(!1);B(()=>i.opened,l=>{c.value=l},{immediate:!0});const g=()=>{i.form.delete(i.link)};return(l,f)=>(u(),w(n(X),{show:c.value,as:"template"},{default:a(()=>[e(n(J),{as:"div",class:"relative z-10",onClose:f[2]||(f[2]=x=>{c.value=!1,l.$emit("closeModal")})},{default:a(()=>[e(n(T),{as:"template",enter:"ease-out duration-300","enter-from":"opacity-0","enter-to":"opacity-100",leave:"ease-in duration-200","leave-from":"opacity-100","leave-to":"opacity-0"},{default:a(()=>[de]),_:1}),t("div",ue,[t("div",me,[e(n(T),{as:"template",enter:"ease-out duration-300","enter-from":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95","enter-to":"opacity-100 translate-y-0 sm:scale-100",leave:"ease-in duration-200","leave-from":"opacity-100 translate-y-0 sm:scale-100","leave-to":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"},{default:a(()=>[e(n(K),{class:"relative transform overflow-hidden rounded-lg bg-white dark:bg-grayish px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6"},{default:a(()=>[t("div",ce,[t("div",ge,[e(n(ie),{"aria-hidden":"true",class:"h-6 w-6 text-red-600"})]),t("div",fe,[e(n(W),{as:"h3",class:"text-base font-semibold leading-6 text-gray-900 dark:text-white"},{default:a(()=>[m("Suppression")]),_:1}),ve])]),t("div",pe,[t("button",{class:"inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto",type:"button",onClick:f[0]||(f[0]=x=>{g(),c.value=!1,l.$emit("closeModal")})},"Supprimer "),t("button",{ref:"cancelButtonRef",class:"mt-3 inline-flex w-full justify-center rounded-md bg-white dark:bg-grayish px-3 py-2 text-sm font-semibold text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto",type:"button",onClick:f[1]||(f[1]=x=>{c.value=!1,l.$emit("closeModal")})},"Annuler ",512)])]),_:1})]),_:1})])])]),_:1})]),_:1},8,["show"]))}},ye={class:"px-4 sm:px-6 lg:px-8"},he={class:"sm:flex sm:items-center border-b border-gray-400 pb-5 mt-8"},be={key:0,class:"space-x-2 mt-4 sm:ml-16 sm:mt-0 sm:flex-none"},xe={key:0,class:"min-w-full divide-y divide-gray-300 dark:divide-black"},ke={class:"bg-gray-50 dark:bg-grayish"},we={class:"divide-y divide-gray-200 dark:divide-black bg-white dark:bg-grayish"},$e={class:"relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"},Ce={key:0,class:"flex items-center justify-center gap-2"},Ve=["onClick"],Me=["onClick"],De={key:1,class:"text-center bg-white dark:bg-grayish text-lg text-gray-600 py-4"},j="",Xe={__name:"RatingTrainings",props:{agent:{},rating:{},types:{type:Array},trainings:{}},setup(r){var D;const i=r,c=G().props.auth.user,g=V(()=>c.user_id===i.rating.evaluated_id),l=V(()=>c.user_id!==i.rating.evaluated_id&&c.user_id!==i.rating.evaluator_id),f=g.value?[{name:"Mes Évaluations",href:route("ratings.index",{agent_rating:i.rating.rating_id}),current:!1},{name:"Evaluation",href:"#",current:!0}]:l?[{name:"Mes validations",href:route("validations.index"),current:!1},{name:"Évaluation",href:"#",current:!0}]:[{name:"Mes Agents",href:route("agents.index"),current:!1},{name:"Évaluations",href:route("agent-ratings.index",{agent:i.agent.user_id}),current:!1},{name:"Evaluation",href:"#",current:!0}],x=V(()=>Y(i.trainings)),v=y(i.trainings.data),$=y(!1),k=y(!1),C=y((D=v[0])==null?void 0:D.rating_training_id),M=y(v[0]),A=o=>{C.value=o,$.value=!0},F=o=>{M.value=v.value.filter(d=>d.rating_training_id===o)[0],k.value=!0},O=()=>{k.value=!0},z=L(g.value?{asked_by_evaluated:0}:{asked_by_evaluator:0});return B(()=>i.trainings,function(o){v.value=o.data,!v.value.length>0&&(o.prev_page_url?S.get(o.prev_page_url):S.get(o.first_page_url))}),(o,d)=>(u(),w(U,null,{default:a(()=>[e(n(P),{title:"Formations"}),t("div",ye,[e(I,{pages:n(f)},null,8,["pages"]),e(q,{agent:r.agent,rating:r.rating},null,8,["agent","rating"]),e(H,{agent_id:i.agent.user_id,evaluated:g.value,rating_id:i.rating.rating_id,validator:l.value},null,8,["agent_id","evaluated","rating_id","validator"]),t("div",he,[e(re,{desc:"Liste des formations demandées pour cette évaluation",title:"Formations"}),!l.value&&!r.rating.rating_is_validated?(u(),p("div",be,[t("button",{class:"inline-flex gap-x-1.5 rounded-md bg-cyan-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600",onClick:d[0]||(d[0]=s=>O())},[m(" Nouvelle Formation "),e(n(ae),{class:"-mr-0.5 h-5 w-5"})])])):E("",!0)]),n(ee)(r.trainings.data)?(u(),w(te,{key:0,modelValue:j,"onUpdate:modelValue":d[1]||(d[1]=s=>j=s),pagination:x.value,search:!1},{default:a(()=>[v.value.length>0?(u(),p("table",xe,[t("thead",ke,[t("tr",null,[e(_,{first:!0},{default:a(()=>[m("Type")]),_:1}),e(_,null,{default:a(()=>[m("Demandée par l'évaluateur")]),_:1}),e(_,null,{default:a(()=>[m("Demandée par l'évalué")]),_:1}),e(_,{class:"whitespace-pre-line"},{default:a(()=>[m("Commentaire de l'évaluateur")]),_:1}),e(_,{class:"whitespace-pre-line"},{default:a(()=>[m("Commentaire de l'évalué")]),_:1}),e(_)])]),t("tbody",we,[(u(!0),p(Q,null,Z(v.value,s=>(u(),p("tr",{key:s.rating_training_id},[e(b,{first:!0,class:"whitespace-pre-line"},{default:a(()=>[m(h(s.type.training_type_name),1)]),_:2},1024),e(b,null,{default:a(()=>[t("span",{class:N([s.asked_by_evaluator?"bg-green-50 text-green-700 ring-green-600/20 dark:bg-green-600 dark:text-white":"bg-red-50 text-red-700 ring-red-600/20 dark:bg-red-600 dark:text-white","inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset"])},h(s.asked_by_evaluator?"Oui":"Non"),3)]),_:2},1024),e(b,null,{default:a(()=>[t("span",{class:N([s.asked_by_evaluated?"bg-green-50 text-green-700 ring-green-600/20 dark:bg-green-600 dark:text-white":"bg-red-50 text-red-700 ring-red-600/20 dark:bg-red-600 dark:text-white","inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset"])},h(s.asked_by_evaluated?"Oui":"Non"),3)]),_:2},1024),e(b,{class:"whitespace-pre-line"},{default:a(()=>[m(h(s.evaluator_comment||"__"),1)]),_:2},1024),e(b,{class:"whitespace-pre-line"},{default:a(()=>[m(h(s.evaluated_comment||"__"),1)]),_:2},1024),t("td",$e,[!l.value&&(g.value&&s.asked_by_evaluated||!g.value&&s.asked_by_evaluator)&&!r.rating.rating_is_validated?(u(),p("div",Ce,[t("button",{class:"rounded-lg bg-cyan-600 p-2 text-white shadow-sm hover:bg-cyan-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600",type:"button",onClick:R=>F(s.rating_training_id)},[e(n(le),{"aria-hidden":"true",class:"h-5 w-5"})],8,Ve),t("button",{class:"rounded-lg bg-red-600 p-2 text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600",type:"button",onClick:R=>A(s.rating_training_id)},[e(n(oe),{"aria-hidden":"true",class:"h-5 w-5"})],8,Me)])):E("",!0)])]))),128))])])):(u(),p("div",De," Aucun élément trouvé."))]),_:1},8,["pagination"])):(u(),w(se,{key:1,message:"Demander une formation en utilisant la liste déroulante en haut.",title:"Aucune formation demandée pour l'instant."}))]),e(_e,{form:n(z),link:o.route("rating-trainings.destroy",{rating:r.rating.rating_id,rating_training:C.value?C.value:-1}),opened:$.value,onCloseModal:d[2]||(d[2]=s=>$.value=!1)},null,8,["form","link","opened"]),e(ne,{isEvaluated:g.value,isValidator:l.value,opened:k.value,rating:r.rating,training:M.value,types:r.types,onCloseModal:d[3]||(d[3]=s=>k.value=!1)},null,8,["isEvaluated","isValidator","opened","rating","training","types"])]),_:1}))}};export{Xe as default};
