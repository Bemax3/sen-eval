<<<<<<<< HEAD:public/build/assets/ToggleOnDatatable-3676339b.js
import{r as c,w as d,O as r,o as p,e as f,f as g,a as e,n as o,u as h}from"./app-009e6676.js";import{u as m}from"./switch-7eb20ab8.js";const y=e("span",{class:"sr-only"},"Use setting",-1),v=e("svg",{class:"h-3 w-3 text-gray-400",fill:"none",viewBox:"0 0 12 12"},[e("path",{d:"M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2",stroke:"currentColor","stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2"})],-1),_=[v],b=e("svg",{class:"h-3 w-3 text-cyan-600",fill:"currentColor",viewBox:"0 0 12 12"},[e("path",{d:"M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z"})],-1),w=[b],j={__name:"ToggleOnDatatable",props:{link:{type:String,required:!0},data:{type:Object,required:!1},obj:{type:String},value:{type:Number,required:!0}},emits:["toggled"],setup(l,{emit:i}){const t=l,a=c(t.value===1);return d(()=>a.value,function(n){if(t.data){const s=t.data;s[t.obj]=n,r.put(t.link,s)}else r.put(t.link,{[t.obj]:n});i("toggled",!0)}),(n,s)=>(p(),f(h(m),{modelValue:a.value,"onUpdate:modelValue":s[0]||(s[0]=u=>a.value=u),class:o([a.value?"bg-cyan-600":"bg-gray-200","relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:ring-offset-2"])},{default:g(()=>[y,e("span",{class:o([a.value?"translate-x-5":"translate-x-0","pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"])},[e("span",{class:o([a.value?"opacity-0 duration-100 ease-out":"opacity-100 duration-200 ease-in","absolute inset-0 flex h-full w-full items-center justify-center transition-opacity"]),"aria-hidden":"true"},_,2),e("span",{class:o([a.value?"opacity-100 duration-200 ease-in":"opacity-0 duration-100 ease-out","absolute inset-0 flex h-full w-full items-center justify-center transition-opacity"]),"aria-hidden":"true"},w,2)],2)]),_:1},8,["modelValue","class"]))}};export{j as _};
========
import{r as c,w as d,O as r,o as p,e as f,f as g,a as e,n as o,u as h}from"./app-3e4b2772.js";import{u as m}from"./switch-117f037e.js";const y=e("span",{class:"sr-only"},"Use setting",-1),v=e("svg",{class:"h-3 w-3 text-gray-400",fill:"none",viewBox:"0 0 12 12"},[e("path",{d:"M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2",stroke:"currentColor","stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2"})],-1),_=[v],b=e("svg",{class:"h-3 w-3 text-cyan-600",fill:"currentColor",viewBox:"0 0 12 12"},[e("path",{d:"M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z"})],-1),w=[b],j={__name:"ToggleOnDatatable",props:{link:{type:String,required:!0},data:{type:Object,required:!1},obj:{type:String},value:{type:Number,required:!0}},emits:["toggled"],setup(l,{emit:i}){const t=l,a=c(t.value===1);return d(()=>a.value,function(n){if(t.data){const s=t.data;s[t.obj]=n,r.put(t.link,s)}else r.put(t.link,{[t.obj]:n});i("toggled",!0)}),(n,s)=>(p(),f(h(m),{modelValue:a.value,"onUpdate:modelValue":s[0]||(s[0]=u=>a.value=u),class:o([a.value?"bg-cyan-600":"bg-gray-200","relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:ring-offset-2"])},{default:g(()=>[y,e("span",{class:o([a.value?"translate-x-5":"translate-x-0","pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"])},[e("span",{class:o([a.value?"opacity-0 duration-100 ease-out":"opacity-100 duration-200 ease-in","absolute inset-0 flex h-full w-full items-center justify-center transition-opacity"]),"aria-hidden":"true"},_,2),e("span",{class:o([a.value?"opacity-100 duration-200 ease-in":"opacity-0 duration-100 ease-out","absolute inset-0 flex h-full w-full items-center justify-center transition-opacity"]),"aria-hidden":"true"},w,2)],2)]),_:1},8,["modelValue","class"]))}};export{j as _};
>>>>>>>> 6ba55a1 (bug fixes):public/build/assets/ToggleOnDatatable-b04d1ccb.js
