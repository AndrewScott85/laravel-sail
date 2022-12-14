import{_ as $}from"./AppLayout.4d459c1e.js";import{u as j,d as b,o as n,e as c,a as t,t as s,h as r,b as l,w as o,g as d,L as w,F as y,c as P,i as D}from"./app.bb000322.js";import{_ as E}from"./DialogModal.a3806d40.js";import{_ as v}from"./DangerButton.3cfab6d3.js";import{_ as L}from"./FullScreenPhoto.bcb24795.js";import"./_plugin-vue_export-helper.cdc0426e.js";import"./Modal.082b1bf0.js";const B={class:"flex flex-col shadow-lg bg-neutral-800 p-4 w-[22rem] lg:w-96 rounded-sm hover:bg-neutral-900 hover:ring hover:ring-indigo-600/50 ring-offset-4 ring-offset-black"},F={class:"text-lg font-bold self-start cursor-pointer hover:underline"},M={class:"text-base self-end"},N=["src"],A={key:0,class:"text-white text-base px-2 py-2 h-32"},S={key:1,class:"text-white text-base px-2 py-4 h-32"},T={class:"flex gap-2 justify-center mt-4"},V=t("div",{class:"font-bold border-b border-gray-100"},[t("p",{class:"px-4 py-4"}," Are you sure you want to delete this photo?")],-1),I={class:"flex flex-col items-center gap-4 p-4 mx-20"},O=["src"],q={class:"text-lg text-white"},z={class:"pr-4"},G={class:"flex flex-col md:flex-row items-center justify-between"},H={class:"order-last md:order-first font-bold text-left pl-2 md:text-2xl md:pl-10"},J={class:"text-right p-2 md:text-xl md:p-6"},K={class:"flex justify-center"},Q=["src"],R={class:"max-w-7xl mx-auto"},U={class:"whitespace-pre-line md:text-xl px-4 pb-4 text-left"},W={__name:"CardEditable",props:{photo:Object},setup(e){const h=e,a=j({_method:"DELETE"}),i=b(!1),f=b(!1),p=()=>{i.value=!1,a.reset()},u=()=>{f.value=!1},k=()=>{i.value=!0},C=m=>{a.delete(route("admin.photos.delete",m.id),{preserveScroll:!0,onSuccess:()=>p(),onFinish:()=>a.reset()})},x=()=>{f.value=!0},_=h.photo.created_at.slice(2,10).split("-").reverse().join("/");return(m,g)=>(n(),c(y,null,[t("div",B,[t("div",{class:"flex justify-between items-center text-white font-base",onClick:x},[t("h3",F,s(e.photo.title),1),t("p",M,s(r(_)),1)]),t("div",{class:"cursor-pointer",onClick:x},[t("img",{class:"h-60 object-contain py-4",src:"/storage/"+e.photo.path,alt:""},null,8,N),e.photo.description.length>185?(n(),c("div",A,[t("p",null,s(e.photo.description.slice(0,185)+"...."),1)])):(n(),c("div",S,s(e.photo.description),1))]),t("div",T,[l(r(w),{class:"inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-16 py-1 rounded-sm",href:m.route("admin.photos.edit",e.photo.id)},{default:o(()=>[d(" EDIT ")]),_:1},8,["href"]),l(v,{class:"font-bold rounded-sm",onClick:k},{default:o(()=>[d(" Delete ")]),_:1})])]),l(E,{show:i.value,onClose:p},{title:o(()=>[V]),content:o(()=>[t("div",I,[t("img",{class:"h-48",src:"/storage/"+e.photo.path,alt:""},null,8,O),t("p",q,s(e.photo.description.slice(0,50)+"..."),1)])]),footer:o(()=>[t("div",z,[t("button",{onClick:p,class:"inline-flex text-sm items-center uppercase px-8 py-2 mr-4 rounded-sm font-bold bg-white text-black"}," CANCEL "),l(v,{onClick:g[0]||(g[0]=ot=>C(e.photo))},{default:o(()=>[d("Delete")]),_:1})])]),_:1},8,["show"]),l(L,{show:f.value,onClose:u},{content:o(()=>[t("div",{class:"flex flex-col bg-auto gap-4",onClick:u},[t("div",G,[t("h2",H,s(e.photo.title),1),t("h3",J,s(r(_)),1)]),t("div",K,[t("img",{class:"object-scale-down py-6 px-4",src:"/storage/"+e.photo.path,alt:""},null,8,Q)]),t("div",R,[t("p",U,s(e.photo.description),1)])])]),_:1},8,["show"])],64))}},X={class:"flex justify-between items-center"},Y=t("h2",{class:"font-semibold text-3xl text-gray-100 leading-tight"}," Posts ",-1),Z={class:"py-8"},tt={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},et={class:"grid sm:grid-cols-1 md:grid-cols-2 xl:grid-cols-3 3xl:grid-cols-4 gap-4 justify-items-center"},dt={__name:"Posts",props:{photos:Array},setup(e){return(h,a)=>(n(),P($,{title:"Photos"},{header:o(()=>[t("div",X,[Y,l(r(w),{class:"py-2 px-4 bg-emerald-700 text-white text-4xl font-bold rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2",href:h.route("admin.photos.create")},{default:o(()=>[d("+")]),_:1},8,["href"])])]),default:o(()=>[t("div",Z,[t("div",tt,[t("div",et,[(n(!0),c(y,null,D(e.photos,i=>(n(),c("div",{class:"m-2 flex flex-1",key:i.id},[l(W,{photo:i},null,8,["photo"])]))),128))])])])]),_:1}))}};export{dt as default};
