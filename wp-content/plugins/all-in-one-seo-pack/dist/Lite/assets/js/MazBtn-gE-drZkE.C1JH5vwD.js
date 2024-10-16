const __vite__fileDeps=[window.__aioseoDynamicImportPreload__("js/MazSpinner-Q02SOFkL.BFslkogk.js"),window.__aioseoDynamicImportPreload__("js/Phone.C3KaOZCO.js"),window.__aioseoDynamicImportPreload__("js/links.C572zDFG.js"),window.__aioseoDynamicImportPreload__("js/runtime-core.esm-bundler.DMBo7TXk.js"),window.__aioseoDynamicImportPreload__("js/default-i18n.Bd0Z306Z.js"),window.__aioseoDynamicImportPreload__("js/helpers.D5tYIqKS.js"),window.__aioseoDynamicImportPreload__("js/preload-helper.M0ZNWaht.js"),window.__aioseoDynamicImportPreload__("js/_plugin-vue_export-helper.BLXtEB-G.js"),window.__aioseoDynamicImportPreload__("css/Phone.DP3dKgFd.css"),window.__aioseoDynamicImportPreload__("css/MazSpinner-Q02SOFkL.TKBjL_aI.css"),window.__aioseoDynamicImportPreload__("js/MazIcon-CUOwXGOK.D_XsgE-T.js")],__vite__mapDeps=i=>i.map(i=>__vite__fileDeps[i]);
import{_}from"./preload-helper.M0ZNWaht.js";import{s as E}from"./Phone.C3KaOZCO.js";import{e as T,ag as P,ah as O,ai as R,f as a,o as t,k as l,l as j,c as r,aa as s,b as e,m as u,u as c,q as d,aj as g}from"./runtime-core.esm-bundler.DMBo7TXk.js";import"./links.C572zDFG.js";import"./default-i18n.Bd0Z306Z.js";import"./helpers.D5tYIqKS.js";import"./_plugin-vue_export-helper.BLXtEB-G.js";const D=T({__name:"MazBtn",props:{variant:{default:"button"},size:{default:"md"},color:{default:"primary"},type:{default:"button"},rounded:{type:Boolean},roundedSize:{default:"lg"},noRounded:{type:Boolean},outline:{type:Boolean},pastel:{type:Boolean},block:{type:Boolean},noUnderline:{type:Boolean},loading:{type:Boolean},disabled:{type:Boolean},fab:{type:Boolean},icon:{type:[String,Function,Object],default:void 0},leftIcon:{type:[String,Function,Object],default:void 0},rightIcon:{type:[String,Function,Object],default:void 0},noPadding:{type:Boolean},noElevation:{type:Boolean},contentClass:{default:void 0}},setup(h){const n=h,k=g(()=>_(()=>import("./MazSpinner-Q02SOFkL.BFslkogk.js"),__vite__mapDeps([0,1,2,3,4,5,6,7,8,9]),import.meta.url)),p=g(()=>_(()=>import("./MazIcon-CUOwXGOK.D_XsgE-T.js"),__vite__mapDeps([10,1,2,3,4,5,6,7,8]),import.meta.url)),{href:B,to:z}=P(),f=O();R(()=>{n.icon&&!n.fab&&console.error('[maz-ui](MazBtn) the prop "icon" must be used only with "fab" props')});const m=a(()=>B?"a":z?"router-link":"button"),I=a(()=>n.pastel?`--${n.color}-pastel`:n.outline?`--${n.color}-outline`:`--${n.color}`),v=a(()=>(n.loading||n.disabled)&&m.value==="button"),$=a(()=>v.value?"--cursor-default":"--cursor-pointer"),C=a(()=>`--is-${n.variant}`),i=a(()=>n.loading&&n.variant==="button"),y=a(()=>!!f["left-icon"]||n.leftIcon),b=a(()=>!!f["right-icon"]||n.rightIcon),S=a(()=>y.value||b.value),A=a(()=>n.fab&&(n.icon||!!f.icon)),x=a(()=>m.value==="button"?n.type:void 0);return(o,L)=>(t(),l(d(m.value),{disabled:v.value||void 0,class:s(["m-btn",[`--${o.size}`,!o.fab&&o.roundedSize&&`--rounded-${o.roundedSize}`,I.value,$.value,C.value,{"--block":o.block,"--no-underline":o.noUnderline,"--fab":o.fab,"--loading":o.loading,"--disabled":v.value,"--icon":S.value,"--rounded":o.rounded,"--no-rounded":o.noRounded,"--no-padding":o.noPadding,"--no-elevation":o.noElevation}]]),type:x.value},{default:j(()=>[y.value?(t(),r("div",{key:0,class:s(["m-btn__icon-left maz-flex maz-flex-center",{"maz-invisible":i.value}])},[e(`
        @slot left-icon - The icon to display on the left of the button
      `),u(o.$slots,"left-icon",{},()=>[typeof o.leftIcon=="string"?(t(),l(c(p),{key:0,name:o.leftIcon},null,8,["name"])):o.leftIcon?(t(),l(d(o.leftIcon),{key:1})):e("v-if",!0)],!0)],2)):e("v-if",!0),A.value?(t(),r("div",{key:1,class:s(["m-btn__icon",{"maz-invisible":i.value}])},[e(`
        @slot icon - The icon to display on the fab button
      `),u(o.$slots,"icon",{},()=>[typeof o.icon=="string"?(t(),l(c(p),{key:0,name:o.icon},null,8,["name"])):o.icon?(t(),l(d(o.icon),{key:1})):e("v-if",!0)],!0)],2)):e("v-if",!0),o.$slots.default?(t(),r("span",{key:2,class:s([{"maz-invisible":i.value},o.contentClass])},[e(`
        @slot default - The content of the button
      `),u(o.$slots,"default",{},void 0,!0)],2)):e("v-if",!0),b.value?(t(),r("div",{key:3,class:s(["m-btn__icon-right",{"maz-invisible":i.value}])},[e(`
        @slot right-icon - The icon to display on the right of the button
      `),u(o.$slots,"right-icon",{},()=>[typeof o.rightIcon=="string"?(t(),l(c(p),{key:0,name:o.rightIcon},null,8,["name"])):o.rightIcon?(t(),l(d(o.rightIcon),{key:1})):e("v-if",!0)],!0)],2)):e("v-if",!0),i.value?(t(),l(c(k),{key:4,class:"m-btn-loader",size:"2em",color:o.color},null,8,["color"])):e("v-if",!0)]),_:3},8,["disabled","class","type"]))}}),G=E(D,[["__scopeId","data-v-48f14785"]]);export{G as default};