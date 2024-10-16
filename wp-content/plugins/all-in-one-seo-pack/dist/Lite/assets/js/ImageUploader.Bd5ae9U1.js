import{B as b}from"./Caret.CGwYaMo_.js";import{B as y}from"./Img.D1d3ge3U.js";import{B as I,S as V}from"./index.CdwEuUIl.js";import{S as w}from"./Plus.iqCbU08m.js";import{_ as C,u as z,w as d}from"./_plugin-vue_export-helper.BLXtEB-G.js";import{v as o,o as p,c as B,a as _,B as i,l as c,k as M,b as P,C as k,t as U,aa as N}from"./runtime-core.esm-bundler.DMBo7TXk.js";let a={};const m={components:{BaseButton:b,BaseImg:y,BaseInput:I,SvgCirclePlus:w,SvgTrash:V},emits:["update:modelValue"],methods:{setImgSrc(e){this.$emit("update:modelValue",e)},openUploadModal(){a=window.wp.media({title:this.$t.__("Choose Image",this.$td),button:{text:this.$t.__("Choose Image",this.$td)},multiple:!1}),a.on("select",()=>{const e=a.state().get("selection").first().toJSON();this.setImgSrc((e==null?void 0:e.url)||null)}),a.on("close",()=>{a.detach()}),this.$nextTick(()=>{a.open()})}},props:{baseSize:{type:String,default:"medium"},imgPreviewMaxHeight:{type:String,default:"525px"},imgPreviewMaxWidth:{type:String,default:"525px"},description:String,modelValue:{type:String,default:""}},data(){return{strings:{description:this.$t.__("Minimum size: 112px x 112px, The image must be in JPG, PNG, GIF, SVG, or WEBP format.",this.$td),pasteYourImageUrl:this.$t.__("Paste your image URL or select a new image",this.$td),remove:this.$t.__("Remove",this.$td),uploadOrSelectImage:this.$t.__("Upload or Select Image",this.$td)}}},computed:{iconWidth(){return this.baseSize==="small"?"16":"20"}}},g=()=>{z(e=>({60602498:e.imgPreviewMaxHeight,a69ae8ce:e.imgPreviewMaxWidth}))},h=m.setup;m.setup=h?(e,t)=>(g(),h(e,t)):g;const T={class:"image-upload"},L=["innerHTML"];function W(e,t,s,$,r,n){const f=o("svg-trash"),u=o("base-button"),S=o("base-input"),v=o("svg-circle-plus"),x=o("base-img");return p(),B("div",{class:N(["aioseo-image-uploader",{"aioseo-image-uploader--has-image":!!s.modelValue}])},[_("div",T,[i(S,{size:s.baseSize,modelValue:s.modelValue,placeholder:r.strings.pasteYourImageUrl,onChange:t[1]||(t[1]=l=>n.setImgSrc(l))},{"append-icon":c(()=>[s.modelValue?(p(),M(u,{key:0,size:s.baseSize,class:"remove-image",type:"gray",onClick:t[0]||(t[0]=d(l=>n.setImgSrc(null),["prevent"]))},{default:c(()=>[i(f,{width:n.iconWidth},null,8,["width"])]),_:1},8,["size"])):P("",!0)]),_:1},8,["size","modelValue","placeholder"]),i(u,{size:s.baseSize,class:"insert-image",type:"black",onClick:t[2]||(t[2]=d(l=>n.openUploadModal(),["prevent"]))},{default:c(()=>[i(v,{width:"14"}),k(" "+U(r.strings.uploadOrSelectImage),1)]),_:1},8,["size"])]),_("div",{class:"aioseo-description",innerHTML:s.description||r.strings.description},null,8,L),i(x,{class:"image-preview",src:s.modelValue},null,8,["src"])],2)}const J=C(m,[["render",W],["__scopeId","data-v-8f427e02"]]);export{J as C};
