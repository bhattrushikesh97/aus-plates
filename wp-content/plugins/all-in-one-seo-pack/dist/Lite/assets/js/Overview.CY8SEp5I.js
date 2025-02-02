import{A as U}from"./AddonConditions.CGRZ5c5Q.js";import{_ as L}from"./_plugin-vue_export-helper.BLXtEB-G.js";import{o as r,c as b,a as u,v as a,k as _,q as R,B as s,t as h,l as n,b as g,F as T,ac as x,aa as S,C as y}from"./runtime-core.esm-bundler.DMBo7TXk.js";import{o as V,f as N}from"./links.C572zDFG.js";import{C as j}from"./Blur.tZiC08Rv.js";import{G as E,a as F}from"./Row.CHjKxnPP.js";import{C as O}from"./Card.CuS1kKeW.js";import{C as A}from"./Tooltip.CRFjFnpF.js";import{a as G}from"./index.CdwEuUIl.js";import{S as Z,a as z,b as H,c as Q}from"./InternalOutbound.DZ80pFZE.js";import{g as W}from"./Caret.CGwYaMo_.js";import{U as J}from"./AnimatedNumber.AHtyCECF.js";import{C as q}from"./DonutChartWithLegend.C7eC6_tQ.js";import"./default-i18n.Bd0Z306Z.js";import{u as K,S as X}from"./SeoSiteScore.DJJTgd8V.js";import{C as Y}from"./Tabs.C-PQxwBC.js";import{T as B,a as M}from"./Row.B02QfAwU.js";import{n as tt}from"./numbers.zAmItkHM.js";import{R as nt}from"./RequiredPlans.CWb7CJDQ.js";import{C as st}from"./Index.fxoyLS1r.js";import"./addons.tTxptju5.js";import"./upperFirst.BGtMw2rr.js";import"./_stringToArray.DnK4tKcY.js";import"./toString.CkyAieyd.js";import"./helpers.D5tYIqKS.js";import"./Slide.D2pWF0rN.js";import"./TruSeoScore.TjofuHRQ.js";import"./Ellipse.CAgnKuMU.js";import"./Information.JAmX9TGg.js";import"./license.w8vDmkyH.js";import"./constants.B6ynd7gz.js";const et={};function ot(t,e){return r(),b("div")}const it=L(et,[["render",ot]]),rt={},at={viewBox:"0 0 19 17",fill:"none",xmlns:"http://www.w3.org/2000/svg",class:"aioseo-link-orphaned"},lt=u("path",{d:"M13.875 3.87495H10.375V5.53745H13.875C15.3713 5.53745 16.5875 6.7537 16.5875 8.24995C16.5875 9.5012 15.73 10.5512 14.5663 10.8575L15.8438 12.135C17.27 11.4087 18.25 9.9562 18.25 8.24995C18.25 5.83495 16.29 3.87495 13.875 3.87495ZM13 7.37495H11.0838L12.8338 9.12495H13V7.37495ZM0.75 1.4862L3.47125 4.20745C2.66729 4.53457 1.97904 5.09383 1.49435 5.81385C1.00966 6.53387 0.750518 7.38199 0.75 8.24995C0.75 10.665 2.71 12.625 5.125 12.625H8.625V10.9625H5.125C3.62875 10.9625 2.4125 9.7462 2.4125 8.24995C2.4125 6.8587 3.47125 5.71245 4.8275 5.5637L6.63875 7.37495H6V9.12495H8.38875L10.375 11.1112V12.625H11.8888L15.3975 16.125L16.5 15.0225L1.86125 0.374954L0.75 1.4862Z",fill:"currentColor"},null,-1),ct=[lt];function ut(t,e){return r(),b("svg",at,ct)}const _t=L(rt,[["render",ut]]),dt={components:{CoreTooltip:A,SvgCircleQuestionMark:G,SvgLinkAffiliate:Z,SvgLinkExternal:z,SvgLinkInternalInbound:H,SvgLinkOrphaned:_t,SvgSearch:W,UtilAnimatedNumber:J},props:{type:{type:String,required:!0},count:{type:Number,required:!0}},data(){return{strings:{orphanedPostsDescription:this.$t.__("Orphaned posts are posts that have no inbound internal links yet and may be more difficult to find by search engines.",this.$td)},icons:[{type:"posts",name:this.$t.__("Posts Crawled",this.$td),icon:"svg-search"},{type:"external",name:this.$t.__("External Links",this.$td),icon:"svg-link-external"},{type:"internal",name:this.$t.__("Internal Links",this.$td),icon:"svg-link-internal-inbound"},{type:"affiliate",name:this.$t.__("Affiliate Links",this.$td),icon:"svg-link-affiliate"},{type:"orphaned",name:this.$t.__("Orphaned Posts",this.$td),icon:"svg-link-orphaned"}]}},computed:{getType(){return this.icons.find(t=>t.type===this.type)},getLink(){switch(this.type){case"posts":case"affiliate":case"internal":return"#/links-report?fullReport=1";case"external":return"#/domains-report";case"orphaned":return"#/links-report?orphaned-posts=1";default:return""}}}},pt=["href"],mt={class:"aioseo-link-count-top"},ht={class:"aioseo-link-count-bottom"},ft={class:"disabled-button gray"};function kt(t,e,o,m,i,c){const p=a("util-animated-number"),l=a("svg-circle-question-mark"),d=a("core-tooltip");return r(),b("a",{class:"aioseo-link-count",href:c.getLink},[u("div",mt,[(r(),_(R(c.getType.icon))),s(p,{number:parseInt(o.count)},null,8,["number"])]),u("div",ht,[u("span",null,h(c.getType.name),1),o.type==="orphaned"?(r(),_(d,{key:0},{tooltip:n(()=>[u("span",null,h(i.strings.orphanedPostsDescription),1)]),default:n(()=>[u("div",ft,[s(l)])]),_:1})):g("",!0)])],8,pt)}const gt=L(dt,[["render",kt]]),bt={components:{CoreCard:O,GridColumn:E,GridRow:F,LinkCount:gt},props:{totals:{type:Object,required:!0}}};function $t(t,e,o,m,i,c){const p=a("LinkCount"),l=a("grid-column"),d=a("grid-row"),v=a("core-card");return r(),_(v,{class:"aioseo-link-assistant-statistics",slug:"internalLinksOverviewCounter",toggles:!1,"no-slide":"","hide-header":""},{default:n(()=>[s(d,null,{default:n(()=>[s(l,{class:"counter divider-right",oneFifth:""},{default:n(()=>[s(p,{type:"posts",count:o.totals.crawledPosts},null,8,["count"])]),_:1}),s(l,{class:"counter divider-right",oneFifth:""},{default:n(()=>[s(p,{type:"orphaned",count:o.totals.orphanedPosts},null,8,["count"])]),_:1}),s(l,{class:"counter divider-right",oneFifth:""},{default:n(()=>[s(p,{type:"external",count:o.totals.externalLinks},null,8,["count"])]),_:1}),s(l,{class:"counter divider-right",oneFifth:""},{default:n(()=>[s(p,{type:"internal",count:o.totals.internalLinks},null,8,["count"])]),_:1}),s(l,{class:"counter",oneFifth:""},{default:n(()=>[s(p,{type:"affiliate",count:o.totals.affiliateLinks},null,8,["count"])]),_:1})]),_:1})]),_:1})}const Lt=L(bt,[["render",$t]]),vt={setup(){const{strings:t}=K();return{composableStrings:t}},components:{CoreCard:O,CoreDonutChartWithLegend:q},mixins:[X],props:{totals:{type:Object,required:!0}},data(){return{score:0,strings:V(this.composableStrings,{header:this.$t.__("Internal vs External vs Affiliate Links",this.$td),totalLinks:this.$t.__("Total Links",this.$td),linksReportLink:this.$t.sprintf('<a href="%1$s">%2$s</a><a href="%1$s"> <span>&rarr;</span></a>',"#/links-report?fullReport=1",this.$t.__("See a Full Links Report",this.$td))})}},computed:{parts(){return[{slug:"external",name:this.$t.__("External Links",this.$td),count:this.totals.externalLinks},{slug:"affiliate",name:this.$t.__("Affiliate Links",this.$td),count:this.totals.affiliateLinks},{slug:"internal",name:this.$t.__("Internal Links",this.$td),count:this.totals.internalLinks}]},sortedParts(){const t=this.parts;return t.sort(function(e,o){return o.count>e.count?1:-1}),t[0].ratio=100,t[1].ratio=t[1].count/this.totals.totalLinks*100,t[2].ratio=t[2].count/this.totals.totalLinks*100,t.forEach(e=>{switch(e.slug){case"external":{e.color="#005AE0";break}case"internal":{e.color="#00AA63";break}case"affiliate":{e.color="#F18200";break}}}),t.filter(function(e){return e.count!==0}),t.forEach((e,o)=>(o===0||t.forEach((m,i)=>(o<i&&(e.ratio=e.ratio+m.ratio),e)),e)),t}}};function yt(t,e,o,m,i,c){const p=a("core-donut-chart-with-legend"),l=a("core-card");return r(),_(l,{class:"aioseo-link-assistant-link-ratio",slug:"linkAssistantLinkRatio","no-slide":"","header-text":i.strings.header},{default:n(()=>[s(p,{parts:c.sortedParts,total:o.totals.totalLinks,label:i.strings.totalLinks,link:i.strings.linksReportLink},null,8,["parts","total","label","link"])]),_:1},8,["header-text"])}const wt=L(vt,[["render",yt]]),Ct={components:{CoreCard:O,CoreMainTabs:Y,CoreTooltip:A,SvgLinkInternalInbound:H,SvgLinkInternalOutbound:Q,TableColumn:B,TableRow:M},props:{linkingOpportunities:{type:Object,required:!0}},data(){return{activeTab:"inbound",strings:{linkingOpportunities:this.$t.__("Linking Opportunities",this.$td),noResults:this.$t.__("No items found.",this.$td)},link:this.$t.sprintf('<a class="links-report-link" href="%1$s">%2$s</a><a href="%1$s"> <span>&rarr;</span></a>',"#/links-report?linkingOpportunities=1",this.$t.__("See All Linking Opportunities",this.$td)),tabs:[{slug:"inbound",name:this.$t.__("Inbound Suggestions",this.$td)},{slug:"outbound",name:this.$t.__("Outbound Suggestions",this.$td)}],columns:[{slug:"post-title",label:this.$t.__("Post Title",this.$td)},{slug:"suggestions-count",label:this.$t.__("Count",this.$td)}]}},computed:{opportunities(){return this.linkingOpportunities[this.activeTab]}}},Tt={class:"linking-opportunities-table"},xt={class:"row"},St={key:0},Ot={key:1,class:"aioseo-tooltip-wrapper"},At=["innerHTML"],Pt={class:"row"},Dt=["href"],It={class:"count"},Rt={class:"count"},Et={key:0,class:"links-report-link"},Ft=["innerHTML"];function Ht(t,e,o,m,i,c){const p=a("core-main-tabs"),l=a("core-tooltip"),d=a("table-column"),v=a("table-row"),w=a("router-link"),f=a("core-card");return r(),_(f,{class:"aioseo-link-assistant-linking-opportunities",slug:"linkAssistantLinkOpportunities","no-slide":"","header-text":i.strings.linkingOpportunities},{tabs:n(()=>[s(p,{tabs:i.tabs,showSaveButton:!1,active:i.activeTab,onChanged:e[0]||(e[0]=$=>i.activeTab=$),internal:""},null,8,["tabs","active"])]),default:n(()=>{var $,P,D;return[u("div",null,[u("div",Tt,[($=c.opportunities)!=null&&$.length?(r(),_(v,{key:0,class:"header-row"},{default:n(()=>[(r(!0),b(T,null,x(i.columns,(k,C)=>(r(),_(d,{key:C,class:S(k.slug)},{default:n(()=>[u("div",xt,[k.tooltipIcon?g("",!0):(r(),b("div",St,h(k.label),1)),k.tooltipIcon?(r(),b("div",Ot,[s(l,{class:"action"},{tooltip:n(()=>[u("span",{innerHTML:k.label},null,8,At)]),default:n(()=>[(r(),_(R(k.tooltipIcon)))]),_:2},1024)])):g("",!0)])]),_:2},1032,["class"]))),128))]),_:1})):g("",!0),(r(!0),b(T,null,x(c.opportunities,(k,C)=>(r(),_(v,{key:C,class:S(["row",{even:C%2===0}])},{default:n(()=>[s(d,{class:"post-title"},{default:n(()=>[u("div",Pt,[s(l,{type:"action"},{tooltip:n(()=>[u("a",{class:"tooltip-url",href:k.permalink,target:"_blank"},h(k.postTitle),9,Dt)]),default:n(()=>[s(w,{to:{name:"links-report",query:{postTitle:k.postTitle}}},{default:n(()=>[y(h(k.postTitle),1)]),_:2},1032,["to"])]),_:2},1024)])]),_:2},1024),i.activeTab==="inbound"?(r(),_(d,{key:0,class:"internal-inbound"},{default:n(()=>[u("span",It,h(k.inboundSuggestions),1)]),_:2},1024)):g("",!0),i.activeTab==="outbound"?(r(),_(d,{key:1,class:"internal-outbound"},{default:n(()=>[u("span",Rt,h(k.outboundSuggestions),1)]),_:2},1024)):g("",!0)]),_:2},1032,["class"]))),128)),(P=c.opportunities)!=null&&P.length?g("",!0):(r(),_(v,{key:1,class:"row even"},{default:n(()=>[s(d,{class:"post-title"},{default:n(()=>[y(h(i.strings.noResults),1)]),_:1})]),_:1}))]),(D=c.opportunities)!=null&&D.length?(r(),b("div",Et,[u("span",{innerHTML:i.link},null,8,Ft)])):g("",!0)])]}),_:1},8,["header-text"])}const qt=L(Ct,[["render",Ht]]),Bt={components:{CoreCard:O,CoreTooltip:A,CoreDonutChartWithLegend:q,TableColumn:B,TableRow:M},props:{totals:{type:Object,required:!0},mostLinkedDomains:{type:Array,required:!0}},data(){return{numbers:tt,strings:{mostLinkedDomains:this.$t.__("Most Linked to Domains",this.$td),totalExternalLinks:this.$t.__("Total External Links",this.$td),noResults:this.$t.__("No items found.",this.$td),link:this.$t.sprintf('<a href="%1$s">%2$s</a><a href="%1$s"> <span>&rarr;</span></a>',"#/domains-report?fullReport=1",this.$t.__("See a Full Domains Report",this.$td))}}},computed:{sortedParts(){const t=this.mostLinkedDomains.map(o=>o).splice(0,3);let e=this.totals.externalLinks;return t[0]&&(t[0].color="#005AE0",t[0].ratio=100,e=e-t[0].count),t[1]&&(t[1].color="#80ACF0",t[1].ratio=t[1].count/this.totals.externalLinks*100,e=e-t[1].count),t[2]&&(t[2].color="#BFD6F7",t[2].ratio=t[2].count/this.totals.externalLinks*100,e=e-t[2].count),e&&t.push({name:this.$t.__("other domains",this.$td),color:"#E8E8EB",count:e,ratio:e/this.totals.externalLinks*100,last:!0}),t.filter(function(o){return o.count!==0}).sort(function(o,m){return parseInt(m.count)>parseInt(o.count)?1:-1}),t.forEach((o,m)=>(m===0||t.forEach((i,c)=>(m<c&&(o.ratio=o.ratio+i.ratio),o)),o)),t},columns(){return[{slug:"name",label:this.$t.__("Domain",this.$td)},{slug:"count",label:this.$t.__("# of Links",this.$td)}]}}},Mt={class:"domains-table"},Ut={class:"row"},Vt=["src"],Nt=["href"],jt=["href"];function Gt(t,e,o,m,i,c){const p=a("core-donut-chart-with-legend"),l=a("table-column"),d=a("table-row"),v=a("core-tooltip"),w=a("core-card");return r(),_(w,{class:"aioseo-link-assistant-linked-domains",slug:"linkAssistantLinkedDomains","no-slide":"","header-text":i.strings.mostLinkedDomains},{default:n(()=>[s(p,{parts:c.sortedParts,total:o.totals.externalLinks,label:i.strings.totalExternalLinks,link:i.strings.link},null,8,["parts","total","label","link"]),u("div",Mt,[s(d,{class:"header-row"},{default:n(()=>[(r(!0),b(T,null,x(c.columns,(f,$)=>(r(),_(l,{key:$,class:S(f.slug)},{default:n(()=>[y(h(f.label),1)]),_:2},1032,["class"]))),128))]),_:1}),(r(!0),b(T,null,x(o.mostLinkedDomains,(f,$)=>(r(),_(d,{key:$,class:S(["row",{even:$%2===0}])},{default:n(()=>[s(l,{class:"domain"},{default:n(()=>[u("div",Ut,[u("img",{alt:"Domain Favicon",class:"favicon",src:`https://www.google.com/s2/favicons?sz=32&domain=${f.name}`},null,8,Vt),s(v,{type:"action"},{tooltip:n(()=>[u("a",{class:"tooltip-url",href:`https://${f.name}`,target:"_blank"},h(f.name),9,jt)]),default:n(()=>[u("a",{class:"domain-name",href:`#/domains-report?hostname=${f.name}`},h(f.name),9,Nt)]),_:2},1024)])]),_:2},1024),s(l,{class:"count"},{default:n(()=>[u("span",null,h(i.numbers.numberFormat(f.count)),1)]),_:2},1024)]),_:2},1032,["class"]))),128)),o.mostLinkedDomains.length?g("",!0):(r(),_(d,{key:0,class:"row even"},{default:n(()=>[s(l,{class:"domain"},{default:n(()=>[y(h(i.strings.noResults),1)]),_:1})]),_:1}))])]),_:1},8,["header-text"])}const Zt=L(Bt,[["render",Gt]]),zt={components:{CoreBlur:j,GridColumn:E,GridRow:F,LinkCounts:Lt,LinkRatio:wt,LinkingOpportunities:qt,MostLinkedDomains:Zt},props:{showTotals:{type:Boolean,default(){return!0}}},computed:{totals(){return{crawledPosts:102,externalLinks:753,internalLinks:56,affiliateLinks:175,orphanedPosts:78,totalLinks:984}},linkingOpportunities(){return[{postTitle:"Test Post Title 1",postId:"123",suggestionsInbound:"2",suggestionsOutbound:"13"},{postTitle:"Test Post Title 2",postId:"124",suggestionsInbound:"2",suggestionsOutbound:"13"},{postTitle:"Test Post Title 3",postId:"125",suggestionsInbound:"2",suggestionsOutbound:"13"},{postTitle:"Test Post Title 4",postId:"126",suggestionsInbound:"2",suggestionsOutbound:"13"},{postTitle:"Test Post Title 5",postId:"127",suggestionsInbound:"2",suggestionsOutbound:"13"}]},mostLinkedDomains(){return[{name:"aioseo.com",count:100},{name:"wpbeginner.com",count:99},{name:"wpforms.com",count:50},{name:"optinmonster.com",count:40},{name:"monsterinsights.com",count:30},{name:"smashballoon.com",count:20},{name:"exactmetrics.com",count:10},{name:"seedprod.com",count:5},{name:"awesomemotive.com",count:4},{name:"easydigitaldownloads.com",count:3}]}}};function Qt(t,e,o,m,i,c){const p=a("link-counts"),l=a("grid-column"),d=a("grid-row"),v=a("link-ratio"),w=a("linking-opportunities"),f=a("most-linked-domains"),$=a("core-blur");return r(),_($,null,{default:n(()=>[o.showTotals?(r(),_(d,{key:0,class:"overview-link-count"},{default:n(()=>[s(l,null,{default:n(()=>[s(p,{totals:c.totals},null,8,["totals"])]),_:1})]),_:1})):g("",!0),s(d,null,{default:n(()=>[s(l,{md:"6"},{default:n(()=>[s(v,{totals:c.totals},null,8,["totals"]),s(w,{"linking-opportunities":c.linkingOpportunities},null,8,["linking-opportunities"])]),_:1}),s(l,{md:"6"},{default:n(()=>[s(f,{totals:c.totals,"most-linked-domains":c.mostLinkedDomains},null,8,["totals","most-linked-domains"])]),_:1})]),_:1})]),_:1})}const Wt=L(zt,[["render",Qt]]),Jt={setup(){return{licenseStore:N()}},components:{Blur:Wt,RequiredPlans:nt,Cta:st},data(){return{strings:{ctaButtonText:this.$t.__("Unlock Link Assistant",this.$td),ctaHeader:this.$t.sprintf(this.$t.__("Link Assistant is a %1$s Feature",this.$td),"PRO"),linkAssistantDescription:this.$t.__("Get relevant suggestions for adding internal links to all your content as well as finding any orphaned posts that have no internal links.",this.$td),linkOpportunities:this.$t.__("Actionable Link Suggestions",this.$td),orphanedPosts:this.$t.__("See Orphaned Posts",this.$td),affiliateLinks:this.$t.__("See Affiliate Links",this.$td),domainReports:this.$t.__("Top Domain Reports",this.$td)}}}},Kt={class:"aioseo-link-assistant-overview"};function Xt(t,e,o,m,i,c){const p=a("blur"),l=a("required-plans"),d=a("cta");return r(),b("div",Kt,[s(p),s(d,{class:"aioseo-link-assistant-cta","cta-link":t.$links.getPricingUrl("link-assistant","link-assistant-upsell","overview"),"button-text":i.strings.ctaButtonText,"learn-more-link":t.$links.getUpsellUrl("link-assistant","overview",t.$isPro?"pricing":"liteUpgrade"),"feature-list":[i.strings.linkOpportunities,i.strings.domainReports,i.strings.orphanedPosts,i.strings.affiliateLinks],"align-top":"","hide-bonus":!m.licenseStore.isUnlicensed},{"header-text":n(()=>[y(h(i.strings.ctaHeader),1)]),description:n(()=>[s(l,{addon:"aioseo-link-assistant"}),y(" "+h(i.strings.linkAssistantDescription),1)]),_:1},8,["cta-link","button-text","learn-more-link","feature-list","hide-bonus"])])}const I=L(Jt,[["render",Xt]]),Yt={mixins:[U],components:{Cta:it,Lite:I,Overview:I},data(){return{addonSlug:"aioseo-link-assistant"}}},tn={class:"aioseo-link-assistant-overview"};function nn(t,e,o,m,i,c){const p=a("overview",!0),l=a("cta"),d=a("lite");return r(),b("div",tn,[t.shouldShowMain?(r(),_(p,{key:0})):g("",!0),t.shouldShowUpdate||t.shouldShowActivate?(r(),_(l,{key:1})):g("",!0),t.shouldShowLite?(r(),_(d,{key:2})):g("",!0)])}const Rn=L(Yt,[["render",nn]]);export{Rn as default};
