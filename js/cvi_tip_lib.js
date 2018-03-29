/**
 * cvi_tip_lib.js 1.0 (11-Apr-2010) (c) by Christian Effenberger 
 * All Rights Reserved. Source: cvi.netzgesta.de
 * Distributed under Netzgestade Software License Agreement.
 * This license permits free of charge use on non-commercial 
 * and private web sites only under special conditions. 
 * Read more at... http://www.netzgesta.de/cvi/LICENSE.html	
 * Commercial licenses available via... cvi[at]netzgesta[dot]de	
**/

var cvi_tip = { version : 1.0, released : '2010-04-11 19:38:00', name: 'cvi_tooltip', tag : 'a', attr : 'tooltip', capture : false, xoff : 32, yoff : 16, fixw : 0, fixh : 0, etach : (window.attachEvent&&window.detachEvent&&!window.opera?1:0), 
	init : function() {function getByClass(v) {var i,j,h,c,d=document.getElementsByTagName(cvi_tip.tag),e=new Array();for(i=0;i<d.length;i++) {h=d[i];c=h.className.split(' ');for(j=0;j<c.length;j++) {if(c[j]==v) {e.push(h);break;}}}return e;}; 
		var i,t,x,r,u,l=getByClass(cvi_tip.attr);cvi_tip.create();if(l.length>0) {for(i=0;i<l.length;i++) {if(l[i].getAttribute(cvi_tip.attr)!=null) {cvi_tip.add(l[i]);}}} return false;
	},
	add : function(ele,tip) {
		if(ele) {var ttv=ele.getAttribute(cvi_tip.attr)||''; tip=tip||'';if(ttv!=''||tip!='') {if(tip!='') {ele.setAttribute(cvi_tip.attr,tip);}if(ele.title!='') {ele.tip=ele.title; ele.title='';}
		if(cvi_tip.etach) {ele.attachEvent("onmouseenter",cvi_tip._show);ele.attachEvent("onmouseleave",cvi_tip._hide);ele.attachEvent("onmousemove",cvi_tip._move);}
		else {ele.addEventListener("mouseover",cvi_tip._show,cvi_tip.capture);ele.addEventListener("mouseout",cvi_tip._hide,cvi_tip.capture);ele.addEventListener("mousemove",cvi_tip._move,cvi_tip.capture);}}}return false;
	},
	remove : function(ele) {
		if(ele) {if(ele.tip!='') {ele.title=ele.tip;}if(cvi_tip.etach) {ele.detachEvent("onmouseenter",cvi_tip._show);ele.detachEvent("onmouseleave",cvi_tip._hide);ele.detachEvent("onmousemove",cvi_tip._move);}
		else {ele.removeEventListener("mouseover",cvi_tip._show,cvi_tip.capture);ele.removeEventListener("mouseout",cvi_tip._hide,cvi_tip.capture);ele.removeEventListener("mousemove",cvi_tip._move,cvi_tip.capture);}}return false;
	},
	create : function() {if(!cvi_tip.$(cvi_tip.name)) {var o=document.body,p=document.createElement('div'),e=p.style;p.id=cvi_tip.name;e.visibility="hidden";e.position="absolute";e.display="none";o.appendChild(p);cvi_tip._trans(e,0);}return false;},
	_show : function(e) {e=e?e:window.event;var tt=cvi_tip.$(cvi_tip.name),s=e.target||e.srcElement,c=e.currentTarget;if(s.nodeType==3) {s=s.parentNode;}if(!cvi_tip.etach&&(s!=c)) {s=c;}
		if(tt&&e) {e.title='';tt.innerHTML=s.getAttribute(cvi_tip.attr);tt.style.display="block";tt.style.left=cvi_tip._getx()+"px";tt.style.top=cvi_tip._gety()+"px";
			cvi_tip.fixw=tt.offsetWidth;cvi_tip.fixh=tt.offsetHeight;tt.style.left=cvi_tip._getcx(e)+"px";tt.style.top=cvi_tip._getcy(e)+"px";cvi_tip._move(e);
			if(cvi_tip.etach) {tt.detachEvent("onmousemove",cvi_tip._move);}else {tt.removeEventListener("mousemove",cvi_tip._move,cvi_tip.capture);}tt.style.visibility="visible"; 
			if(tt.timer) {window.clearInterval(tt.timer);}var o=0,c=0,p=20,s=100/p; cvi_tip._trans(tt.style,0); tt.timer=window.setInterval(function() {o=p*c; cvi_tip._trans(tt.style,o); c++; 
			if(c>s) {window.clearInterval(tt.timer);cvi_tip._trans(tt.style,100);if(cvi_tip.etach) {tt.attachEvent("onmousemove",cvi_tip._move);}else {tt.addEventListener("mousemove",cvi_tip._move,cvi_tip.capture);}}},30);
		}return false;
	},
	_hide : function(e) {e=e?e:window.event;var tt=cvi_tip.$(cvi_tip.name);
		if(tt) {if(cvi_tip.etach) {tt.detachEvent("onmousemove",cvi_tip._move);}else {tt.removeEventListener("mousemove",cvi_tip._move,cvi_tip.capture);}
			if(tt.timer) {window.clearInterval(tt.timer);}var o=0,c=0,p=20,s=100/p; cvi_tip._trans(tt.style,100);tt.timer=window.setInterval(function() {o=100-(p*c); cvi_tip._trans(tt.style,o); c++; 
			if(c>s) {window.clearInterval(tt.timer); cvi_tip._trans(tt.style,0);tt.style.visibility="hidden";tt.style.display="none";tt.innerHTML="";
			if(cvi_tip.etach) {tt.attachEvent("onmousemove",cvi_tip._move);}else {tt.addEventListener("mousemove",cvi_tip._move,cvi_tip.capture);}}},30);
		}return false;
	},
	_move : function(e) {e=e?e:window.event;var tt=cvi_tip.$(cvi_tip.name);
		if(tt) {var xo=cvi_tip.xoff,yo=cvi_tip.yoff,tx=cvi_tip._getcx(e),ty=cvi_tip._getcy(e),tw=cvi_tip.fixw,th=cvi_tip.fixh,w=cvi_tip._getw(),h=cvi_tip._geth(),x=cvi_tip._getx(),y=cvi_tip._gety(),l=tx-x,r=x+w-tx,t=ty-y,b=y+h-ty,a=20;
			if((t-yo)>=th) {tt.style.top=(ty-yo-th)+"px";tt.style.left=(Math.min(x+w-tw-a,Math.max(x,tx-(tw/2))))+"px";}else if((b-(yo*2))>=th) {tt.style.top=(ty+yo+yo)+"px";tt.style.left=(Math.min(x+w-tw-a,Math.max(x,tx-(tw/2))))+"px";}
			else {tt.style.top=(y+((h-th)/2))+"px";if((r-xo)>=tw) {tt.style.left=(tx+xo)+"px";}else if((l-xo)>=tw) {tt.style.left=(tx-xo-tw)+"px";}else {if(r>=l) {tt.style.left=(tx+xo)+"px";}else {tt.style.left=(tx-xo-tw)+"px";}}}
		}return false;
	},
	_trans : function(o,v) {if(document.all&&!window.opera&&(!document.documentMode||document.documentMode<9)){o.filter="alpha(opacity="+v+")";}else{o.MozOpacity=v*0.01;o.KhtmlOpacity=v*0.01;o.opacity=v*0.01;}return false;},
	_getw : function() {if(typeof window.innerWidth!='undefined') {return window.innerWidth;}else {if(typeof document.documentElement!='undefined') {return document.documentElement.clientWidth;}else {return document.body.clientWidth;}}},		
	_geth : function() {if(typeof window.innerHeight!='undefined') {return window.innerHeight;}else {if(typeof document.documentElement!='undefined') {return document.documentElement.clientHeight;}else {return document.body.clientHeight;}}},		
	_getx : function() {if(typeof window.pageXOffset!='undefined') {return window.pageXOffset;}else {if(typeof document.documentElement!='undefined') {return document.documentElement.scrollLeft;}else {return document.body.scrollLeft;}}},		
	_gety : function() {if(typeof window.pageYOffset!='undefined') {return window.pageYOffset;}else {if(typeof document.documentElement!='undefined') {return document.documentElement.scrollTop;}else {return document.body.scrollTop;}}},
	_getcx : function(e) {if(typeof e.pageX!='undefined') {return e.pageX;}else if(typeof e.clientX!='undefined') {if(typeof document.documentElement!='undefined') {return (e.clientX+document.documentElement.scrollLeft);}else {return (e.clientX+document.body.scrollLeft);}}},
	_getcy : function(e) {if(typeof e.pageY!='undefined') {return e.pageY;}else if(typeof e.clientY!='undefined') {if(typeof document.documentElement!='undefined') {return (e.clientY+document.documentElement.scrollTop);}else {return (e.clientY+document.body.scrollTop);}}},
	$ : function(v) {return(document.getElementById(v));}
}

if(window.attachEvent) window.attachEvent("onload",cvi_tip.init);
else window.addEventListener("load",cvi_tip.init,false);