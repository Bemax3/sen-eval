import{r as _,w as V,o as b,e as w,u as o,f as n,T as D,g as t,Z as P,a as s,t as Y,k as c,m as v,h as $}from"./app-009e6676.js";import{m as g,p as y,i as l,_ as S}from"./AuthenticatedLayout-a6827bda.js";import{_ as k}from"./Breadcrumbs-6f218844.js";import{_ as j}from"./Separator-75b2b080.js";import{_ as N}from"./SectionTitle-d7629aad.js";import{_ as A}from"./FormIndications-fac9b7ef.js";import{_ as B}from"./InputLabel-00850faa.js";import{_ as C}from"./SubmitButton-d98e5e89.js";import{_ as x}from"./InputError-db0f38c0.js";import{G as E}from"./vue-tailwind-datepicker-9c852ff9.js";import"./logo1637145113-11387d37.js";import"./CheckIcon-44d763b6.js";const q={__name:"RangePicker",props:{modelValue:{type:Array,required:!0},invalid:{type:Boolean}},emits:["update:modelValue"],setup(r,{emit:e}){const u=r,d=_([]);d.value=[g(u.modelValue[0]).format("DD-MM-YYYY"),g(u.modelValue[1]).format("DD-MM-YYYY")];const f=_({date:"DD-MM-YYYY",month:"MMMM"});V(()=>d.value,function(i){i.length>0?e("update:modelValue",[y(i[0],"dd.mm.yyyy"),y(i[1],"dd.mm.yyyy")]):e("update:modelValue",[])});const a=_({shortcuts:{today:"Aujourd'hui",yesterday:"Hier",past:i=>`${i} derniers jours`,currentMonth:"Ce mois ci",pastMonth:"Dernier mois"},footer:{apply:"Choisir",cancel:"Annuler"}});return(i,p)=>(b(),w(o(E),{modelValue:d.value,"onUpdate:modelValue":p[0]||(p[0]=m=>d.value=m),formatter:f.value,"input-classes":[r.invalid?"ring-red-400 focus:ring-red-600":"focus:ring-cyan-600","block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6"],options:a.value,i18n:"fr",separator:" au ","use-range":""},null,8,["modelValue","formatter","input-classes","options"]))}},G={class:"px-4 sm:px-6 lg:px-8"},O={class:"sm:flex sm:items-center"},T={class:"sm:flex-auto"},U={class:"text-2xl font-semibold leading-6 text-gray-900"},F=s("p",{class:"mt-2 text-sm text-gray-700"}," Details et paramètres de l'évaluation. ",-1),H={class:"space-x-2 mt-4 sm:ml-16 sm:mt-0 sm:flex-none"},R={class:"mt-8 flow-root"},Z=["onSubmit"],z={class:"px-4 py-6 sm:p-8"},I={class:"grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6"},J={class:"col-span-full"},K={class:"mt-2"},L={class:"flex flex-col space-y-2"},Q={class:"flex items-center justify-between gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8"},ue={__name:"SavePhasePeriod",props:{phase:{type:Object},period:{type:Object,default:{}}},setup(r){const e=r,u=[{name:"Phase d'évaluation",href:route("phases.index"),current:!1},{name:"Périodes d'évaluation",href:route("periods.show",{period:e.phase.phase_id}),current:!0},{name:l(e.period)?"Nouveau":"Modifier",href:"#",current:!0}],d=l(e.period)?"Nouvelle Période d'évaluation":"Modifier la période d'évaluation",f=l(e.period)?"Ajouter une période d'évaluation à cette phase.":"Modifier une période d'évaluation de cette phase";let a;const i=()=>{a=D(l(e.period)?{phase_id:e.phase.phase_id,period:[new Date,new Date]}:{phase_id:e.phase.phase_id,period:[e.period.evaluation_period_start,e.period.evaluation_period_end]})},p=()=>{l(e.period)?a.post(route("periods.store"),{onSuccess:()=>i()}):a.put(route("periods.update",{period:e.period.evaluation_period_id}),{onSuccess:()=>i()})};return i(),(m,h)=>(b(),w(S,null,{default:n(()=>[t(o(P),{title:"Paramètre de Phase"}),s("div",G,[t(k,{pages:u}),s("div",O,[s("div",T,[s("h1",U,"Paramètres "+Y(r.phase.phase_name),1),F]),s("div",H,[t(o(v),{href:m.route("phaseSkills.show",{phaseSkill:r.phase.phase_id}),as:"button",class:"inline-flex gap-x-1.5 rounded-md bg-cyan-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"},{default:n(()=>[c(" Compétences ")]),_:1},8,["href"]),t(o(v),{href:m.route("periods.show",{period:r.phase.phase_id}),as:"button",class:"inline-flex gap-x-1.5 rounded-md bg-cyan-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"},{default:n(()=>[c(" Périodes d'évaluation ")]),_:1},8,["href"])])]),t(j,{title:"Périodes"}),t(N,{desc:o(f),title:o(d)},null,8,["desc","title"]),s("div",R,[s("form",{class:"bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2",onSubmit:$(p,["prevent"])},[s("div",z,[s("div",I,[s("div",J,[t(B,{for:"start_date",required:""},{default:n(()=>[c("Période d'évaluation")]),_:1}),s("div",K,[t(q,{modelValue:o(a).period,"onUpdate:modelValue":h[0]||(h[0]=M=>o(a).period=M),invalid:o(a).errors.evaluation_period_end!==void 0},null,8,["modelValue","invalid"])]),s("div",L,[t(x,{message:o(a).errors.Evaluation_period_start},null,8,["message"]),t(x,{message:o(a).errors.evaluation_period_end},null,8,["message"])])])])]),s("div",Q,[t(A),t(C,{disabled:o(a).processing},{default:n(()=>[c(" Enregistrer")]),_:1},8,["disabled"])])],40,Z)])])]),_:1}))}};export{ue as default};
