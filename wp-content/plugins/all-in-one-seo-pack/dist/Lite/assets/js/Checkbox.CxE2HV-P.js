import{S as u}from"./Checkmark.DL3UTTgg.js";import{_ as d,a as r,w as m}from"./_plugin-vue_export-helper.BLXtEB-G.js";import{v as f,o as g,c as p,m as c,a as s,aa as l,B as b}from"./runtime-core.esm-bundler.DMBo7TXk.js";const _={components:{SvgCheckmark:u},props:{modelValue:Boolean,name:String,labelClass:{type:String,default(){return""}},inputClass:{type:String,default(){return""}},id:String,size:String,disabled:Boolean,round:Boolean,type:{type:String,default(){return"blue"}}},methods:{labelToggle(){this.$refs.input.click()}}},k={class:"form-checkbox-wrapper"},y={class:"form-checkbox"},h=["checked","name","id","disabled"];function x(o,n,e,B,C,t){const i=f("svg-checkmark");return g(),p("label",{class:l(["aioseo-checkbox",[e.labelClass,{[e.size]:e.size},{disabled:e.disabled},{round:e.round}]]),onKeydown:[n[1]||(n[1]=r((...a)=>t.labelToggle&&t.labelToggle(...a),["enter"])),n[2]||(n[2]=r((...a)=>t.labelToggle&&t.labelToggle(...a),["space"]))],onClick:m(()=>{},["stop"])},[c(o.$slots,"header"),s("span",k,[s("span",y,[s("input",{type:"checkbox",onInput:n[0]||(n[0]=a=>o.$emit("update:modelValue",a.target.checked)),checked:e.modelValue,name:e.name,id:e.id,class:l(e.inputClass),disabled:e.disabled,ref:"input"},null,42,h),s("span",{class:l(["fancy-checkbox",e.type])},[b(i)],2)])]),c(o.$slots,"default")],34)}const T=d(_,[["render",x]]);export{T as B};
