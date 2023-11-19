<<<<<<<< HEAD:public/build/assets/SaveGoal-7d08e279.js
import{o as f,e as v,f as i,T as h,g as s,u as l,Z as b,a as e,h as y,k as d}from"./app-3e4b2772.js";import{_ as V,c as w,m as j}from"./AuthenticatedLayout-3ac73bac.js";import{_ as $}from"./Breadcrumbs-51f948bf.js";import{_ as k}from"./FormIndications-a1b732ed.js";import{_ as r}from"./InputLabel-57921aff.js";import{_ as M}from"./SubmitButton-7f722cda.js";import{_ as c}from"./TextInput-6ea32040.js";import{_ as u}from"./TextArea-899d3dd8.js";import{_ as U}from"./Switch-2c51b47b.js";import{_ as S}from"./GoalActivity-54bbe7f5.js";import{_ as q}from"./NumberInput-8877794b.js";import{_ as D}from"./InputError-35896e53.js";import{r as m}from"./LockClosedIcon-a0ca47ca.js";import"./logo1637145113-11387d37.js";import"./CheckIcon-433ec1c5.js";import"./switch-117f037e.js";import"./use-controllable-49f1610e.js";const L={class:"px-4 sm:px-6 lg:px-8"},B=e("div",{class:"sm:flex sm:items-center"},[e("div",{class:"sm:flex-auto"},[e("h1",{class:"text-2xl font-semibold leading-6 text-gray-900"},"Objectif"),e("p",{class:"mt-2 text-sm text-gray-700"}," Details de l'Objectif ")])],-1),C=["onSubmit"],O={class:"grid max-w-7xl grid-cols-1 gap-x-8 gap-y-10 px-4 py-16 sm:px-6 md:grid-cols-3 lg:px-8"},Y=e("div",null,[e("h2",{class:"text-base font-semibold leading-7 text-gray-900"},"Libellé et Valeur Cible"),e("p",{class:"mt-1 text-sm leading-6 text-gray-400"},"Informations sur le libellé de l'objectif ainsi que la valeur cible.")],-1),N={class:"md:col-span-2"},P={class:"grid grid-cols-1 gap-x-6 gap-y-8 sm:max-w-xl sm:grid-cols-6"},F={class:"sm:col-span-full"},I={class:"relative mt-2"},T={class:"pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3"},z={class:"sm:col-span-full"},A={class:"relative mt-2"},E={class:"pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3"},G={class:"grid max-w-7xl grid-cols-1 gap-x-8 gap-y-10 px-4 py-16 sm:px-6 md:grid-cols-3 lg:px-8 border-t-2"},Q=e("div",null,[e("h2",{class:"text-base font-semibold leading-7 text-gray-900"},"Disponibilité et Échéance"),e("p",{class:"mt-1 text-sm leading-6 text-gray-400"},"Les moyens pour atteindre l'objectif sont ils réunis ? Qu'elle sera l'échéance pour cette objectif. ")],-1),Z={class:"md:col-span-2"},H={class:"grid grid-cols-1 gap-x-6 gap-y-8 sm:max-w-xl sm:grid-cols-6"},J={class:"sm:col-span-3"},K={class:"relative mt-2"},R=["value"],W={class:"pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3"},X={class:"sm:col-span-3"},ee={class:"mt-2"},se={class:"grid max-w-7xl grid-cols-1 gap-x-8 gap-y-10 px-4 py-16 sm:px-6 md:grid-cols-3 lg:px-8 border-t-2"},te=e("div",null,[e("h2",{class:"text-base font-semibold leading-7 text-gray-900"},"Évaluation"),e("p",{class:"mt-1 text-sm leading-6 text-gray-400"},"Informations relatives á l'évaluation de cet objectif.")],-1),ae={class:"md:col-span-2"},le={class:"grid grid-cols-1 gap-x-6 gap-y-8 sm:max-w-xl sm:grid-cols-6"},oe={class:"sm:col-span-3"},ie={class:"relative mt-2"},de={class:"pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3"},ne={class:"sm:col-span-3"},re={class:"relative mt-2"},me={class:"pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3"},ce={class:"mt-8 col-span-full"},ge={class:"relative mt-2"},ue={class:"pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3"},_e={class:"grid max-w-7xl grid-cols-1 gap-x-8 gap-y-10 px-4 py-16 sm:px-6 md:grid-cols-2 lg:px-8 border-t-2"},pe=e("h2",{class:"text-base font-semibold leading-7 text-gray-900"},"Suivi de l'objectif",-1),xe=e("p",{class:"mt-1 text-sm leading-6 text-gray-400"},"Faites le suivi de cet objectif en laissant un commentaire. Le taux de réalisation sera renseigné par votre évaluateur.",-1),fe={class:"md:col-span-1"},ve={class:"grid grid-cols-1 gap-x-6 gap-y-8 sm:max-w-xl sm:grid-cols-6"},he={class:"col-span-full"},be={class:"relative mt-2"},ye={class:"flex items-center justify-between gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8"},Ie={__name:"SaveGoal",props:{goal:{type:Object,default:{}},history:{}},setup(t){const _=t,p=[{name:"Mes Objectifs",href:route("goals.index"),current:!1},{name:"Modifier",href:"#",current:!0}];let n;const g=()=>{n=h({comment:""})},x=()=>{n.put(route("goals.update",{goal:_.goal.goal_id}),{onSuccess:()=>g(),preserveScroll:!0})};return g(),(Ve,a)=>(f(),v(V,null,{default:i(()=>[s(l(b),{title:"Paramètre de Phase"}),e("div",L,[s($,{pages:p}),B,e("form",{class:"mt-8 shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg bg-white",onSubmit:y(x,["prevent"])},[e("div",O,[Y,e("div",N,[e("div",P,[e("div",F,[s(r,{for:"start_date",required:""},{default:i(()=>[d("Libelle")]),_:1}),e("div",I,[s(c,{modelValue:t.goal.goal_name,"onUpdate:modelValue":a[0]||(a[0]=o=>t.goal.goal_name=o),disabled:!0},null,8,["modelValue"]),e("div",T,[s(l(m),{"aria-hidden":"true",class:"h-5 w-5 text-gray-400"})])])]),e("div",z,[s(r,{for:"start_date",required:""},{default:i(()=>[d("Valeur Cible")]),_:1}),e("div",A,[s(u,{modelValue:t.goal.goal_expected_result,"onUpdate:modelValue":a[1]||(a[1]=o=>t.goal.goal_expected_result=o),disabled:!0},null,8,["modelValue"]),e("div",E,[s(l(m),{"aria-hidden":"true",class:"h-5 w-5 text-gray-400"})])])])])])]),e("div",G,[Q,e("div",Z,[e("div",H,[e("div",J,[s(r,{for:"start_date",required:""},{default:i(()=>[d("Échéance")]),_:1}),e("div",K,[e("input",{disabled:!0,value:l(w)(l(j)(t.goal.goal_expected_date).format("DD MMMM YYYY")),class:"block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6"},null,8,R),e("div",W,[s(l(m),{"aria-hidden":"true",class:"h-5 w-5 text-gray-400"})])])]),e("div",X,[e("div",ee,[s(U,{modelValue:t.goal.goal_means_available,"onUpdate:modelValue":a[2]||(a[2]=o=>t.goal.goal_means_available=o),disabled:!0,desc:"Les moyens pour accomplir cette objectif sont t-il disponible ?",label:"Disponibilité des moyens"},null,8,["modelValue"])])])])])]),e("div",se,[te,e("div",ae,[e("div",le,[e("div",oe,[s(r,null,{default:i(()=>[d("Année d'évaluation")]),_:1}),e("div",ie,[s(c,{modelValue:t.goal.phase.phase_year,"onUpdate:modelValue":a[3]||(a[3]=o=>t.goal.phase.phase_year=o),disabled:!0},null,8,["modelValue"]),e("div",de,[s(l(m),{"aria-hidden":"true",class:"h-5 w-5 text-gray-400"})])])]),e("div",ne,[s(r,null,{default:i(()=>[d("Période d'évaluation")]),_:1}),e("div",re,[s(c,{modelValue:t.goal.period.evaluation_period_name,"onUpdate:modelValue":a[4]||(a[4]=o=>t.goal.period.evaluation_period_name=o),disabled:!0},null,8,["modelValue"]),e("div",me,[s(l(m),{"aria-hidden":"true",class:"h-5 w-5 text-gray-400"})])])]),e("div",ce,[s(r,{for:"start_date",required:""},{default:i(()=>[d("Barème")]),_:1}),e("div",ge,[s(q,{modelValue:t.goal.goal_marking,"onUpdate:modelValue":a[5]||(a[5]=o=>t.goal.goal_marking=o),disabled:!0},null,8,["modelValue"]),e("div",ue,[s(l(m),{"aria-hidden":"true",class:"h-5 w-5 text-gray-400"})])])])])])]),e("div",_e,[e("div",null,[pe,xe,s(S,{history:t.history},null,8,["history"])]),e("div",fe,[e("div",ve,[e("div",he,[s(r,{for:"start_date"},{default:i(()=>[d("Commentaire")]),_:1}),e("div",be,[s(u,{modelValue:l(n).comment,"onUpdate:modelValue":a[6]||(a[6]=o=>l(n).comment=o),invalid:l(n).errors.comment!==void 0},null,8,["modelValue","invalid"])]),s(D,{message:l(n).errors.comment},null,8,["message"])])])])]),e("div",ye,[s(k),s(M,{disabled:l(n).processing},{default:i(()=>[d("Enregistrer")]),_:1},8,["disabled"])])],40,C)])]),_:1}))}};export{Ie as default};
========
import{o as f,e as v,f as i,T as h,g as s,u as l,Z as b,a as e,h as y,k as d}from"./app-f4ee1640.js";import{_ as V,c as w,m as j}from"./AuthenticatedLayout-3d8b9239.js";import{_ as $}from"./Breadcrumbs-cd355c51.js";import{_ as k}from"./FormIndications-d335c0b6.js";import{_ as r}from"./InputLabel-a8f27f18.js";import{_ as M}from"./SubmitButton-2ce7826b.js";import{_ as c}from"./TextInput-a9b70e17.js";import{_ as u}from"./TextArea-28fa2c21.js";import{_ as U}from"./Switch-42db658c.js";import{_ as S}from"./GoalActivity-ca8da510.js";import{_ as q}from"./NumberInput-ada92c29.js";import{_ as D}from"./InputError-c4459739.js";import{r as m}from"./LockClosedIcon-0d574b95.js";import"./logo1637145113-11387d37.js";import"./CheckIcon-fb39e1b4.js";import"./switch-285aba3f.js";import"./use-controllable-05c16e4e.js";const L={class:"px-4 sm:px-6 lg:px-8"},B=e("div",{class:"sm:flex sm:items-center"},[e("div",{class:"sm:flex-auto"},[e("h1",{class:"text-2xl font-semibold leading-6 text-gray-900"},"Objectif"),e("p",{class:"mt-2 text-sm text-gray-700"}," Details de l'Objectif ")])],-1),C=["onSubmit"],O={class:"grid max-w-7xl grid-cols-1 gap-x-8 gap-y-10 px-4 py-16 sm:px-6 md:grid-cols-3 lg:px-8"},Y=e("div",null,[e("h2",{class:"text-base font-semibold leading-7 text-gray-900"},"Libellé et Valeur Cible"),e("p",{class:"mt-1 text-sm leading-6 text-gray-400"},"Informations sur le libellé de l'objectif ainsi que la valeur cible.")],-1),N={class:"md:col-span-2"},P={class:"grid grid-cols-1 gap-x-6 gap-y-8 sm:max-w-xl sm:grid-cols-6"},F={class:"sm:col-span-full"},I={class:"relative mt-2"},T={class:"pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3"},z={class:"sm:col-span-full"},A={class:"relative mt-2"},E={class:"pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3"},G={class:"grid max-w-7xl grid-cols-1 gap-x-8 gap-y-10 px-4 py-16 sm:px-6 md:grid-cols-3 lg:px-8 border-t-2"},Q=e("div",null,[e("h2",{class:"text-base font-semibold leading-7 text-gray-900"},"Disponibilité et Échéance"),e("p",{class:"mt-1 text-sm leading-6 text-gray-400"},"Les moyens pour atteindre l'objectif sont ils réunis ? Qu'elle sera l'échéance pour cette objectif. ")],-1),Z={class:"md:col-span-2"},H={class:"grid grid-cols-1 gap-x-6 gap-y-8 sm:max-w-xl sm:grid-cols-6"},J={class:"sm:col-span-3"},K={class:"relative mt-2"},R=["value"],W={class:"pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3"},X={class:"sm:col-span-3"},ee={class:"mt-2"},se={class:"grid max-w-7xl grid-cols-1 gap-x-8 gap-y-10 px-4 py-16 sm:px-6 md:grid-cols-3 lg:px-8 border-t-2"},te=e("div",null,[e("h2",{class:"text-base font-semibold leading-7 text-gray-900"},"Évaluation"),e("p",{class:"mt-1 text-sm leading-6 text-gray-400"},"Informations relatives á l'évaluation de cet objectif.")],-1),ae={class:"md:col-span-2"},le={class:"grid grid-cols-1 gap-x-6 gap-y-8 sm:max-w-xl sm:grid-cols-6"},oe={class:"sm:col-span-3"},ie={class:"relative mt-2"},de={class:"pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3"},ne={class:"sm:col-span-3"},re={class:"relative mt-2"},me={class:"pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3"},ce={class:"mt-8 col-span-full"},ge={class:"relative mt-2"},ue={class:"pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3"},_e={class:"grid max-w-7xl grid-cols-1 gap-x-8 gap-y-10 px-4 py-16 sm:px-6 md:grid-cols-2 lg:px-8 border-t-2"},pe=e("h2",{class:"text-base font-semibold leading-7 text-gray-900"},"Suivi de l'objectif",-1),xe=e("p",{class:"mt-1 text-sm leading-6 text-gray-400"},"Faites le suivi de cet objectif en laissant un commentaire. Le taux de réalisation sera renseigné par votre évaluateur.",-1),fe={class:"md:col-span-1"},ve={class:"grid grid-cols-1 gap-x-6 gap-y-8 sm:max-w-xl sm:grid-cols-6"},he={class:"col-span-full"},be={class:"relative mt-2"},ye={class:"flex items-center justify-between gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8"},Ie={__name:"SaveGoal",props:{goal:{type:Object,default:{}},history:{}},setup(t){const _=t,p=[{name:"Mes Objectifs",href:route("goals.index"),current:!1},{name:"Modifier",href:"#",current:!0}];let n;const g=()=>{n=h({comment:""})},x=()=>{n.put(route("goals.update",{goal:_.goal.goal_id}),{onSuccess:()=>g(),preserveScroll:!0})};return g(),(Ve,a)=>(f(),v(V,null,{default:i(()=>[s(l(b),{title:"Paramètre de Phase"}),e("div",L,[s($,{pages:p}),B,e("form",{class:"mt-8 shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg bg-white",onSubmit:y(x,["prevent"])},[e("div",O,[Y,e("div",N,[e("div",P,[e("div",F,[s(r,{for:"start_date",required:""},{default:i(()=>[d("Libelle")]),_:1}),e("div",I,[s(c,{modelValue:t.goal.goal_name,"onUpdate:modelValue":a[0]||(a[0]=o=>t.goal.goal_name=o),disabled:!0},null,8,["modelValue"]),e("div",T,[s(l(m),{"aria-hidden":"true",class:"h-5 w-5 text-gray-400"})])])]),e("div",z,[s(r,{for:"start_date",required:""},{default:i(()=>[d("Valeur Cible")]),_:1}),e("div",A,[s(u,{modelValue:t.goal.goal_expected_result,"onUpdate:modelValue":a[1]||(a[1]=o=>t.goal.goal_expected_result=o),disabled:!0},null,8,["modelValue"]),e("div",E,[s(l(m),{"aria-hidden":"true",class:"h-5 w-5 text-gray-400"})])])])])])]),e("div",G,[Q,e("div",Z,[e("div",H,[e("div",J,[s(r,{for:"start_date",required:""},{default:i(()=>[d("Échéance")]),_:1}),e("div",K,[e("input",{disabled:!0,value:l(w)(l(j)(t.goal.goal_expected_date).format("DD MMMM YYYY")),class:"block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6"},null,8,R),e("div",W,[s(l(m),{"aria-hidden":"true",class:"h-5 w-5 text-gray-400"})])])]),e("div",X,[e("div",ee,[s(U,{modelValue:t.goal.goal_means_available,"onUpdate:modelValue":a[2]||(a[2]=o=>t.goal.goal_means_available=o),disabled:!0,desc:"Les moyens pour accomplir cette objectif sont t-il disponible ?",label:"Disponibilité des moyens"},null,8,["modelValue"])])])])])]),e("div",se,[te,e("div",ae,[e("div",le,[e("div",oe,[s(r,null,{default:i(()=>[d("Année d'évaluation")]),_:1}),e("div",ie,[s(c,{modelValue:t.goal.phase.phase_year,"onUpdate:modelValue":a[3]||(a[3]=o=>t.goal.phase.phase_year=o),disabled:!0},null,8,["modelValue"]),e("div",de,[s(l(m),{"aria-hidden":"true",class:"h-5 w-5 text-gray-400"})])])]),e("div",ne,[s(r,null,{default:i(()=>[d("Période d'évaluation")]),_:1}),e("div",re,[s(c,{modelValue:t.goal.period.evaluation_period_name,"onUpdate:modelValue":a[4]||(a[4]=o=>t.goal.period.evaluation_period_name=o),disabled:!0},null,8,["modelValue"]),e("div",me,[s(l(m),{"aria-hidden":"true",class:"h-5 w-5 text-gray-400"})])])]),e("div",ce,[s(r,{for:"start_date",required:""},{default:i(()=>[d("Barème")]),_:1}),e("div",ge,[s(q,{modelValue:t.goal.goal_marking,"onUpdate:modelValue":a[5]||(a[5]=o=>t.goal.goal_marking=o),disabled:!0},null,8,["modelValue"]),e("div",ue,[s(l(m),{"aria-hidden":"true",class:"h-5 w-5 text-gray-400"})])])])])])]),e("div",_e,[e("div",null,[pe,xe,s(S,{history:t.history},null,8,["history"])]),e("div",fe,[e("div",ve,[e("div",he,[s(r,{for:"start_date"},{default:i(()=>[d("Commentaire")]),_:1}),e("div",be,[s(u,{modelValue:l(n).comment,"onUpdate:modelValue":a[6]||(a[6]=o=>l(n).comment=o),invalid:l(n).errors.comment!==void 0},null,8,["modelValue","invalid"])]),s(D,{message:l(n).errors.comment},null,8,["message"])])])])]),e("div",ye,[s(k),s(M,{disabled:l(n).processing},{default:i(()=>[d("Enregistrer")]),_:1},8,["disabled"])])],40,C)])]),_:1}))}};export{Ie as default};
>>>>>>>> cc7aab3 (First Docker Version !):public/build/assets/SaveGoal-28428a91.js
