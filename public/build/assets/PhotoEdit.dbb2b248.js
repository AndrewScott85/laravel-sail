import{u as _,o as n,c as b,w as c,a as t,p as v,x as f,G as x,h as o,g as p,b as g,e as r,t as l,f as d,L as y}from"./app.bb000322.js";import{_ as w}from"./AppLayout.4d459c1e.js";import"./_plugin-vue_export-helper.cdc0426e.js";const k=t("h2",{class:"font-semibold text-3xl leading-tight"}," Edit Photo ",-1),C={class:"py-12 max-w-7xl mx-auto"},j={class:"sm:px-4 lg:px-8 mt-5 md:col-span-2 md:mt-0"},P={class:"flex flex-col px-4"},B=t("label",{for:"title",class:"block text-m font-bold"},"Title (max 35 characters)",-1),V={class:"m-1"},E={class:"pt-2"},M={key:0,class:"text-red-600"},N=t("label",{class:"block text-m mt-6 font-bold"},"Photo",-1),G={class:"flex bg-white flex-col lg:flex-row items-center px-4 py-10 gap-10"},I=["src"],L={class:"flex flex-col grow justify-center"},S=t("label",{class:"self-center text-lg font-bold text-gray-700 p-4"},"Change this photo?",-1),T={class:"mt-1 flex justify-center rounded-md border-2 border-dashed border-gray-300 px-6 pt-5 pb-6"},U={class:"space-y-1 text-center"},D={key:0},H=t("svg",{class:"mx-auto h-12 w-12 text-gray-400",stroke:"currentColor",fill:"none",viewBox:"0 0 48 48","aria-hidden":"true"},[t("path",{d:"M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02","stroke-width":"2","stroke-linecap":"round","stroke-linejoin":"round"})],-1),$={class:"flex text-sm text-gray-600"},F={for:"path",class:"relative cursor-pointer rounded-md bg-white font-medium text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:text-indigo-500"},J=t("span",null,"Upload a file",-1),K=t("p",{class:"pl-1"},"or drag and drop",-1),O=t("p",{class:"text-xs text-gray-500"}," PNG, JPG, GIF up to 2MB ",-1),q={key:0,class:"flex flex-col lg:flex-row justify-center items-center gap-10 text-slate-800"},z={class:"font-bold text-gray-600"},A={class:"font-medium px-4"},Q={key:0,class:"text-red-600 font-bold"},R=t("label",{for:"description",class:"block text-m font-bold text-white pt-8"}," Edit Description Here",-1),W={class:"mt-1"},X={key:0,class:"text-red-600"},Y={class:"pt-6 flex justify-end gap-4 px-4"},Z=["disabled"],st={__name:"PhotoEdit",props:{photo:Object},setup(a){const h=a,e=_({_method:"PUT",path:null,description:h.photo.description,title:h.photo.title}),u=()=>30-e.title.length;return(m,s)=>(n(),b(w,{title:"Edit Photo"},{header:c(()=>[k]),default:c(()=>[t("div",C,[t("div",j,[t("form",{onSubmit:s[4]||(s[4]=v(i=>o(e).post(m.route("admin.photos.update",a.photo.id)),["prevent"]))},[t("div",P,[t("div",null,[B,t("div",V,[f(t("input",{id:"title",name:"title",maxlength:"30",class:"py-1 px-2 block w-full text-gray-600 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-m","onUpdate:modelValue":s[0]||(s[0]=i=>o(e).title=i),onKeydown:u},null,544),[[x,o(e).title]]),t("p",E,[p("Characters remaining: "),g(u)])])]),o(e).errors.title?(n(),r("div",M,l(o(e).errors.title),1)):d("",!0),t("div",null,[N,t("div",G,[o(e).path?d("",!0):(n(),r("img",{key:0,class:"flex-start",width:"300",src:"/storage/"+a.photo.path,alt:""},null,8,I)),t("div",L,[S,t("div",T,[t("div",U,[o(e).path?d("",!0):(n(),r("div",D,[H,t("div",$,[t("label",F,[J,t("input",{id:"path",name:"path",type:"file",class:"sr-only",accept:"image/*",onInput:s[1]||(s[1]=i=>o(e).path=i.target.files[0])},null,32)]),K]),O]))]),o(e).path?(n(),r("div",q,[t("p",z,[p("Selected Image: "),t("span",A,l(o(e).path.name),1)]),o(e).errors.path?(n(),r("div",Q,l(o(e).errors.path),1)):d("",!0),t("button",{class:"inline-flex justify-center rounded-md border border-transparent bg-indigo-500 py-2 px-4 text-lg font-bold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2",onClick:s[2]||(s[2]=i=>o(e).path=null)},"Change Image")])):d("",!0)])])])]),t("div",null,[R,t("div",W,[f(t("textarea",{id:"description",name:"description",rows:"3",class:"mt-1 block w-full text-gray-600 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-m","onUpdate:modelValue":s[3]||(s[3]=i=>o(e).description=i)},null,512),[[x,o(e).description]])]),o(e).errors.description?(n(),r("div",X,l(o(e).errors.description),1)):d("",!0)])]),t("div",Y,[g(o(y),{class:"bg-slate-700 hover:bg-slate-800 text-white font-bold px-4 py-2 rounded-md",href:m.route("admin.posts")},{default:c(()=>[p(" Cancel ")]),_:1},8,["href"]),t("button",{type:"submit",disabled:o(e).processing,class:"inline-flex justify-center rounded-md border border-transparent bg-emerald-800 py-2 px-4 font-bold text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2"}," Save Changes ",8,Z)])],32)])])]),_:1}))}};export{st as default};
