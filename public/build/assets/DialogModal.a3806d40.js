import{_ as c}from"./Modal.082b1bf0.js";import{o as i,c as r,w as d,a as e,r as o}from"./app.bb000322.js";const n={class:"bg-black text-white"},h={class:"text-lg"},f={class:"my-4"},m={class:"flex flex-row justify-end py-4 bg-black border-t border-gray-100 text-white text-right"},b={__name:"DialogModal",props:{show:{type:Boolean,default:!1},maxWidth:{type:String,default:"2xl"},closeable:{type:Boolean,default:!0}},emits:["close"],setup(t,{emit:a}){const l=()=>{a("close")};return(s,_)=>(i(),r(c,{show:t.show,"max-width":t.maxWidth,closeable:t.closeable,onClose:l},{default:d(()=>[e("div",n,[e("div",h,[o(s.$slots,"title")]),e("div",f,[o(s.$slots,"content")])]),e("div",m,[o(s.$slots,"footer")])]),_:3},8,["show","max-width","closeable"]))}};export{b as _};