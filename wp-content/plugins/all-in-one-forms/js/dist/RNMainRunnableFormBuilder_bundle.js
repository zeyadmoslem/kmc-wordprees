rndefine("#RNMainRunnableFormBuilder",["lit","#RNMainBuilder/Builder.Options","#RNMainBuilder/Builder.Model","#RNMainCore/WpAjaxPost","#RNMainFormBuilderCore/CurrencyManager"],(function(e,r,n,i,l){"use strict";let t=setTimeout((()=>{let o=document.getElementById("App");if(null==o)return;clearTimeout(t),o.innerHTML="",i.WpAjaxPost.SetGlobalVar(rednaoFormDesigner),l.CurrencyManager.Initialize(rednaoFormDesigner.Currency);let a=null;try{a=JSON.parse(rednaoFormDesigner.BuilderOptions)}catch(e){}let u=(new r.BuilderOptions).Merge(a),d=new n.BuilderModel(u);e.render(d.Render(),o)}),100)}));
