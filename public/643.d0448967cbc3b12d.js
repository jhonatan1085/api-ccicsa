"use strict";(self.webpackChunkpreclinic_angular=self.webpackChunkpreclinic_angular||[]).push([[643],{3643:(p,m,t)=>{t.r(m),t.d(m,{CicsaModule:()=>R});var r=t(6814),o=t(1303),i=t(5879),c=t(6130),v=t(764),C=t(7157),g=t(9488);const B=function(s,V,e){return{"expand-menu":s,"mini-sidebar":V,"slide-nav":e}},f=function(s){return{"d-none":s}},S=function(s){return{opened:s}},M=[{path:"",component:(()=>{class s{constructor(e,n,a){this.sideBar=e,this.router=n,this.data=a,this.miniSidebar=!1,this.expandMenu=!1,this.mobileSidebar=!1,this.sideBarActivePath=!1,this.headerActivePath=!1,this.base="",this.page="",this.currentUrl="",this.sideBar.toggleSideBar.subscribe(l=>{this.miniSidebar=l}),this.sideBar.toggleMobileSideBar.subscribe(l=>{this.mobileSidebar=l}),this.sideBar.expandSideBar.subscribe(l=>{this.expandMenu=l,!l&&this.miniSidebar&&this.data.sideBar.map(h=>{h.menu.map(d=>{d.showSubRoute=!1})}),l&&this.miniSidebar&&this.data.sideBar.map(h=>{h.menu.map(d=>{const u=sessionStorage.getItem("menuValue");d.showSubRoute=!(!u||u!=d.menuValue)})})}),this.getRoutes(this.router)}toggleMobileSideBar(){this.sideBar.switchMobileSideBarPosition()}getRoutes(e){"confirm-mail"===e.url.split("/")[2]?(this.sideBarActivePath=!1,this.headerActivePath=!1):(this.sideBarActivePath=!0,this.headerActivePath=!0)}static#t=this.\u0275fac=function(n){return new(n||s)(i.Y36(c.G),i.Y36(o.F0),i.Y36(v.D))};static#s=this.\u0275cmp=i.Xpm({type:s,selectors:[["app-cicsa"]],decls:5,vars:14,consts:[[1,"main-wrapper",3,"ngClass"],[3,"ngClass"],[1,"sidebar-overlay",3,"ngClass"]],template:function(n,a){1&n&&(i.TgZ(0,"div",0),i._UZ(1,"app-header",1)(2,"app-sidebar",1)(3,"router-outlet")(4,"div",2),i.qZA()),2&n&&(i.Q6J("ngClass",i.kEZ(4,B,a.expandMenu&&a.miniSidebar,a.miniSidebar,a.mobileSidebar)),i.xp6(1),i.Q6J("ngClass",i.VKq(8,f,!1===a.sideBarActivePath&&!1===a.headerActivePath)),i.xp6(1),i.Q6J("ngClass",i.VKq(10,f,!1===a.sideBarActivePath&&!1===a.headerActivePath)),i.xp6(2),i.Q6J("ngClass",i.VKq(12,S,a.mobileSidebar)))},dependencies:[r.mk,o.lC,C.G,g.k]})}return s})(),canActivate:[t(1813).a],children:[{path:"usuarios",loadChildren:()=>Promise.all([t.e(313),t.e(592),t.e(637)]).then(t.bind(t,4637)).then(s=>s.UsuariosModule)},{path:"site",loadChildren:()=>Promise.all([t.e(313),t.e(592),t.e(890)]).then(t.bind(t,9890)).then(s=>s.SiteModule)},{path:"bitacoras",loadChildren:()=>Promise.all([t.e(313),t.e(135),t.e(707),t.e(592),t.e(675)]).then(t.bind(t,675)).then(s=>s.BitacorasModule)},{path:"cuadrilla",loadChildren:()=>Promise.all([t.e(313),t.e(135),t.e(592),t.e(263)]).then(t.bind(t,6263)).then(s=>s.CuadrillaModule)},{path:"unidades-moviles",loadChildren:()=>Promise.all([t.e(313),t.e(135),t.e(707),t.e(37)]).then(t.bind(t,37)).then(s=>s.UnidadesMovilesModule)},{path:"lideres",loadChildren:()=>Promise.all([t.e(313),t.e(135),t.e(592),t.e(857)]).then(t.bind(t,5857)).then(s=>s.LideresModule)}]}];let y=(()=>{class s{static#t=this.\u0275fac=function(n){return new(n||s)};static#s=this.\u0275mod=i.oAB({type:s});static#i=this.\u0275inj=i.cJS({imports:[o.Bz.forChild(M),o.Bz]})}return s})();var J=t(15);let R=(()=>{class s{static#t=this.\u0275fac=function(n){return new(n||s)};static#s=this.\u0275mod=i.oAB({type:s});static#i=this.\u0275inj=i.cJS({imports:[r.ez,y,J.m]})}return s})()}}]);