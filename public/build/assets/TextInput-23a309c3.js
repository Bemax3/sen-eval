import{r,I as l,o as s,c as i,n as d}from"./app-9f38d36c.js";const c=["value"],p={__name:"TextInput",props:{modelValue:{type:String,required:!0,default:""},invalid:{type:Boolean}},emits:["update:modelValue"],setup(t,{expose:u}){const e=r(null);return l(()=>{e.value.hasAttribute("autofocus")&&e.value.focus()}),u({focus:()=>e.value.focus()}),(a,n)=>(s(),i("input",{ref_key:"input",ref:e,class:d([t.invalid?"ring-red-400 focus:ring-red-600":"focus:ring-cyan-600","block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6"]),value:t.modelValue,type:"text",onInput:n[0]||(n[0]=o=>a.$emit("update:modelValue",o.target.value))},null,42,c))}};export{p as _};
