import{r as D,w as z,o as c,e as V,u as s,f as i,T as G,g as t,Z as A,a as e,t as h,k as r,m as H,h as P,p as U,c as y,i as q,F as M,j as $,n as g}from"./app-e4fe6d8c.js";import{m as R,p as Q,i as p,_ as Z,h as N}from"./AuthenticatedLayout-5f178db5.js";import{_ as I}from"./Breadcrumbs-3fa0880f.js";import{_ as J}from"./Separator-cf512a22.js";import{_ as K}from"./SectionTitle-ce55fcf8.js";import{_ as W}from"./FormIndications-dad71e4b.js";import{_ as m}from"./InputLabel-8b45f4b3.js";import{_ as X}from"./SubmitButton-c51ff986.js";import{_ as f}from"./InputError-c615efff.js";import{_ as ee}from"./TextInput-b351b6a1.js";import{_ as B}from"./TextArea-952daf78.js";import{_ as se}from"./Switch-fd676ffd.js";import{G as ae}from"./vue-tailwind-datepicker-cb2a1bec.js";import{_ as O}from"./NumberInput-d6765056.js";import{_ as te}from"./GoalActivity-a41f6785.js";import{r as le}from"./ChevronDoubleRightIcon-06644ea9.js";import{r as S}from"./ChevronUpDownIcon-173d3c94.js";import{r as Y}from"./CheckIcon-d11f2fe2.js";import{N as C,H as F,B as L,U as T}from"./listbox-12d96b80.js";import"./logo1637145113-c7398df9.js";import"./switch-14562af2.js";import"./use-controllable-78d2c8e4.js";const oe={__name:"DatePicker",props:{modelValue:{type:Date,required:!0},invalid:{type:Boolean}},emits:["update:modelValue"],setup(d,{emit:o}){const k=d,_=D([]);_.value=[R(k.modelValue).format("DD-MM-YYYY")];const j=D({date:"DD-MM-YYYY",month:"MM"});return z(()=>_.value,function(u){o("update:modelValue",Q(u[0],"dd.mm.yyyy"))}),(u,a)=>(c(),V(s(ae),{modelValue:_.value,"onUpdate:modelValue":a[0]||(a[0]=b=>_.value=b),formatter:j.value,"input-classes":[d.invalid?"ring-red-400 focus:ring-red-600":"focus:ring-cyan-700","block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6"],"as-single":"",i18n:"fr"},null,8,["modelValue","formatter","input-classes"]))}},ie={class:"px-4 sm:px-6 lg:px-8"},ne={class:"sm:flex sm:items-center"},de={class:"sm:flex-auto"},re={class:"text-2xl font-semibold leading-6 text-gray-900"},ce=e("p",{class:"mt-2 text-sm text-gray-700"}," Objectifs de l'agent. ",-1),me={class:"space-x-2 mt-4 sm:ml-16 sm:mt-0 sm:flex-none"},ue=["onSubmit"],_e={class:"grid max-w-7xl grid-cols-1 gap-x-8 gap-y-10 px-4 py-16 sm:px-6 md:grid-cols-3 lg:px-8"},ge=e("div",null,[e("h2",{class:"text-base font-semibold leading-7 text-gray-900"},"Libellé et Valeur Cible"),e("p",{class:"mt-1 text-sm leading-6 text-gray-400"},"Renseigner le libellé de l'objectif ainsi que la valeur cible.")],-1),pe={class:"md:col-span-2"},fe={class:"grid grid-cols-1 gap-x-6 gap-y-8 sm:max-w-xl sm:grid-cols-6"},xe={class:"sm:col-span-full"},ve={class:"mt-2"},he={class:"flex flex-col space-y-2"},ye={class:"sm:col-span-full"},be={class:"mt-2"},we={class:"flex flex-col space-y-2"},Ve={class:"grid max-w-7xl grid-cols-1 gap-x-8 gap-y-10 px-4 py-16 sm:px-6 md:grid-cols-3 lg:px-8 border-t-2"},ke=e("div",null,[e("h2",{class:"text-base font-semibold leading-7 text-gray-900"},"Disponibilité et Échéance"),e("p",{class:"mt-1 text-sm leading-6 text-gray-400"},"Les moyens pour atteindre l'objectif sont ils réunis ? Qu'elle sera l'échéance pour cette objectif. ")],-1),je={class:"md:col-span-2"},$e={class:"grid grid-cols-1 gap-x-6 gap-y-8 sm:max-w-xl sm:grid-cols-6"},De={class:"sm:col-span-3"},Ue={class:"mt-2"},qe={class:"flex flex-col space-y-2"},Me={class:"sm:col-span-3"},Ne={class:"mt-2"},Be={class:"grid max-w-7xl grid-cols-1 gap-x-8 gap-y-10 px-4 py-16 sm:px-6 md:grid-cols-3 lg:px-8 border-t-2"},Oe=e("div",null,[e("h2",{class:"text-base font-semibold leading-7 text-gray-900"},"Évaluation"),e("p",{class:"mt-1 text-sm leading-6 text-gray-400"},"Renseigner les informations relatives à l'évaluation de cet objectif.")],-1),Se={class:"md:col-span-2"},Ye={class:"grid grid-cols-1 gap-x-6 gap-y-8 sm:max-w-xl sm:grid-cols-6"},Ce={class:"mt-8 sm:col-span-3"},Fe={class:"mt-2"},Le={class:"relative mt-2"},Te={class:"block truncate"},ze={class:"pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2"},Ee={class:"mt-8 sm:col-span-3"},Ge={class:"mt-2"},Ae={class:"relative mt-2"},He={class:"block truncate"},Pe={class:"pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2"},Re={class:"mt-8 col-span-full"},Qe={class:"mt-2"},Ze={class:"flex flex-col space-y-2"},Ie={key:0,class:"grid max-w-7xl grid-cols-1 gap-x-8 gap-y-10 px-4 py-16 sm:px-6 md:grid-cols-2 lg:px-8 border-t-2"},Je=e("h2",{class:"text-base font-semibold leading-7 text-gray-900"},"Suivi de l'objectif",-1),Ke=e("p",{class:"mt-1 text-sm leading-6 text-gray-400"},"Faites le suivi de cet objectif en renseignant le taux réalisé et en laissant un commentaire.",-1),We={class:"md:col-span-1"},Xe={class:"grid grid-cols-1 gap-x-6 gap-y-8 sm:max-w-xl sm:grid-cols-6"},es={class:"col-span-full"},ss={class:"mt-2"},as={class:"flex flex-col space-y-2"},ts={class:"sm:col-span-full"},ls={class:"mt-2"},os={class:"flex flex-col space-y-2"},is={class:"flex items-center justify-between gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8"},qs={__name:"SaveAgentGoal",props:{agent:{type:Object},phases:{type:Object},goal:{type:Object,required:!1,default:{}},history:{}},setup(d){const o=d,k=p(o.goal)?"Nouvel objectif":"Modifier l'objectif",_=p(o.goal)?"Fixer un objectif a cet agent":"Modifier un objectif pour cet agent",j=[{name:"Objectifs",href:route("agent-goals.index",{agent:o.agent.user_id}),current:!1},{name:p(o.goal)?"Nouveau":"Modifier",href:"#",current:!0}],u=D();let a;const b=()=>{a=G(p(o.goal)?{goal_name:"",goal_means_available:1,goal_expected_date:new Date,goal_expected_result:"",goal_marking:5,phase_id:N(o.phases)?o.phases[0].phase_id:null,evaluation_period_id:N(o.phases)?o.phases[0].periods[0].evaluation_period_id:null}:{goal_name:o.goal.goal_name,goal_means_available:o.goal.goal_means_available,goal_expected_date:new Date(o.goal.goal_expected_date),goal_expected_result:o.goal.goal_expected_result,goal_marking:o.goal.goal_marking,phase_id:o.goal.phase_id,goal_rate:o.goal.goal_rate,comment:"",evaluation_period_id:o.goal.evaluation_period_id})},E=()=>{p(o.goal)?a.post(route("agent-goals.store",{agent:o.agent.user_id}),{onSuccess:()=>a.reset()}):a.put(route("agent-goals.update",{agent:o.agent.user_id,agent_goal:o.goal.goal_id}),{onSuccess:()=>b(),preserveScroll:!0})};return b(),z(()=>a.phase_id,function(w){w&&(u.value=o.phases.filter(n=>n.phase_id===w)[0].periods,a.evaluation_period_id=u.value[0].evaluation_period_id)},{immediate:!0}),(w,n)=>(c(),V(Z,null,{default:i(()=>[t(s(A),{title:"Nouvel Objectif"}),e("div",ie,[t(I,{pages:j}),e("div",ne,[e("div",de,[e("h1",re,"Objectifs de "+h(d.agent.user_display_name),1),ce]),e("div",me,[t(s(H),{href:w.route("agent-ratings.index",{agent:d.agent.user_id}),class:"inline-flex gap-x-1.5 rounded-md bg-cyan-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"},{default:i(()=>[r(" Évaluations "),t(s(le),{class:"-mr-0.5 h-5 w-5"})]),_:1},8,["href"])])]),t(J,{title:"Objectifs"}),t(K,{desc:s(_),title:s(k)},null,8,["desc","title"]),e("form",{class:"mt-8 shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg bg-white",onSubmit:P(E,["prevent"])},[e("div",_e,[ge,e("div",pe,[e("div",fe,[e("div",xe,[t(m,{for:"start_date",required:""},{default:i(()=>[r("Libelle")]),_:1}),e("div",ve,[t(ee,{modelValue:s(a).goal_name,"onUpdate:modelValue":n[0]||(n[0]=l=>s(a).goal_name=l),invalid:s(a).errors.goal_name!==void 0},null,8,["modelValue","invalid"])]),e("div",he,[t(f,{message:s(a).errors.goal_name},null,8,["message"])])]),e("div",ye,[t(m,{for:"start_date",required:""},{default:i(()=>[r("Valeur Cible")]),_:1}),e("div",be,[t(B,{modelValue:s(a).goal_expected_result,"onUpdate:modelValue":n[1]||(n[1]=l=>s(a).goal_expected_result=l),invalid:s(a).errors.goal_expected_result!==void 0},null,8,["modelValue","invalid"])]),e("div",we,[t(f,{message:s(a).errors.goal_expected_result},null,8,["message"])])])])])]),e("div",Ve,[ke,e("div",je,[e("div",$e,[e("div",De,[t(m,{for:"start_date",required:""},{default:i(()=>[r("Échéance")]),_:1}),e("div",Ue,[t(oe,{modelValue:s(a).goal_expected_date,"onUpdate:modelValue":n[2]||(n[2]=l=>s(a).goal_expected_date=l),invalid:s(a).errors.goal_expected_date!==void 0},null,8,["modelValue","invalid"])]),e("div",qe,[t(f,{message:s(a).errors.goal_expected_date},null,8,["message"])])]),e("div",Me,[e("div",Ne,[t(se,{modelValue:s(a).goal_means_available,"onUpdate:modelValue":n[3]||(n[3]=l=>s(a).goal_means_available=l),desc:"Les moyens pour accomplir cette objectif sont t-il disponible ?",label:"Disponibilité des moyens"},null,8,["modelValue"])])])])])]),e("div",Be,[Oe,e("div",Se,[e("div",Ye,[e("div",Ce,[t(m,{required:""},{default:i(()=>[r("Année d'évaluation")]),_:1}),e("div",Fe,[t(s(L),{modelValue:s(a).phase_id,"onUpdate:modelValue":n[4]||(n[4]=l=>s(a).phase_id=l),as:"div"},{default:i(()=>[e("div",Le,[t(s(C),{class:"relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2 focus:ring-cyan-700 sm:text-sm sm:leading-6"},{default:i(()=>[e("span",Te,h(d.phases.filter(l=>l.phase_id===s(a).phase_id)[0].phase_year),1),e("span",ze,[t(s(S),{"aria-hidden":"true",class:"h-5 w-5 text-gray-400"})])]),_:1}),t(U,{"leave-active-class":"transition ease-in duration-100","leave-from-class":"opacity-100","leave-to-class":"opacity-0"},{default:i(()=>[t(s(F),{class:"absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"},{default:i(()=>[(c(!0),y(M,null,q(d.phases,l=>(c(),V(s(T),{key:l.phase_id,value:l.phase_id,as:"template"},{default:i(({active:x,selected:v})=>[e("li",{class:g([x?"bg-cyan-600  text-white":"text-gray-900","relative cursor-default select-none py-2 pl-3 pr-9"])},[e("span",{class:g([v?"font-semibold":"font-normal","block truncate"])},h(l.phase_year),3),v?(c(),y("span",{key:0,class:g([x?"text-white":"text-cyan-600","absolute inset-y-0 right-0 flex items-center pr-4"])},[t(s(Y),{"aria-hidden":"true",class:"h-5 w-5"})],2)):$("",!0)],2)]),_:2},1032,["value"]))),128))]),_:1})]),_:1})])]),_:1},8,["modelValue"])])]),e("div",Ee,[t(m,{required:""},{default:i(()=>[r("Période")]),_:1}),e("div",Ge,[t(s(L),{modelValue:s(a).evaluation_period_id,"onUpdate:modelValue":n[5]||(n[5]=l=>s(a).evaluation_period_id=l),as:"div"},{default:i(()=>[e("div",Ae,[t(s(C),{class:"relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2 focus:ring-cyan-700 sm:text-sm sm:leading-6"},{default:i(()=>[e("span",He,h(u.value.filter(l=>l.evaluation_period_id===s(a).evaluation_period_id)[0].evaluation_period_name),1),e("span",Pe,[t(s(S),{"aria-hidden":"true",class:"h-5 w-5 text-gray-400"})])]),_:1}),t(U,{"leave-active-class":"transition ease-in duration-100","leave-from-class":"opacity-100","leave-to-class":"opacity-0"},{default:i(()=>[t(s(F),{class:"absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"},{default:i(()=>[(c(!0),y(M,null,q(u.value,l=>(c(),V(s(T),{key:l.evaluation_period_id,value:l.evaluation_period_id,as:"template"},{default:i(({active:x,selected:v})=>[e("li",{class:g([x?"bg-cyan-600  text-white":"text-gray-900","relative cursor-default select-none py-2 pl-3 pr-9"])},[e("span",{class:g([v?"font-semibold":"font-normal","block truncate"])},h(l.evaluation_period_name),3),v?(c(),y("span",{key:0,class:g([x?"text-white":"text-cyan-600","absolute inset-y-0 right-0 flex items-center pr-4"])},[t(s(Y),{"aria-hidden":"true",class:"h-5 w-5"})],2)):$("",!0)],2)]),_:2},1032,["value"]))),128))]),_:1})]),_:1})])]),_:1},8,["modelValue"])])]),e("div",Re,[t(m,{for:"start_date",required:""},{default:i(()=>[r("Barème")]),_:1}),e("div",Qe,[t(O,{modelValue:s(a).goal_marking,"onUpdate:modelValue":n[6]||(n[6]=l=>s(a).goal_marking=l),invalid:s(a).errors.goal_marking!==void 0,maxlength:"2"},null,8,["modelValue","invalid"])]),e("div",Ze,[t(f,{message:s(a).errors.goal_marking},null,8,["message"])])])])])]),s(p)(d.goal)?$("",!0):(c(),y("div",Ie,[e("div",null,[Je,Ke,t(te,{history:d.history},null,8,["history"])]),e("div",We,[e("div",Xe,[e("div",es,[t(m,{for:"start_date",required:""},{default:i(()=>[r("Taux d'avancement")]),_:1}),e("div",ss,[t(O,{modelValue:s(a).goal_rate,"onUpdate:modelValue":n[7]||(n[7]=l=>s(a).goal_rate=l),invalid:s(a).errors.goal_rate!==void 0,maxlength:"3"},null,8,["modelValue","invalid"])]),e("div",as,[t(f,{message:s(a).errors.goal_rate},null,8,["message"])])]),e("div",ts,[t(m,{for:"start_date"},{default:i(()=>[r("Commentaire")]),_:1}),e("div",ls,[t(B,{modelValue:s(a).comment,"onUpdate:modelValue":n[8]||(n[8]=l=>s(a).comment=l),invalid:s(a).errors.comment!==void 0},null,8,["modelValue","invalid"])]),e("div",os,[t(f,{message:s(a).errors.comment},null,8,["message"])])])])])])),e("div",is,[t(W),t(X,{processing:s(a).processing},{default:i(()=>[r(" Enregistrer")]),_:1},8,["processing"])])],40,ue)])]),_:1}))}};export{qs as default};
