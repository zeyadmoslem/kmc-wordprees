rndefine("#RNMainRadioField",["#RNMainCore/EventManager","#RNMainFormBuilderCore/FieldBase.Options","#RNMainFormBuilderCore/MultipleOptionsBase","lit/decorators","lit","lit/directives/repeat.js","lit-html/directives/live.js","#RNMainFormBuilderCore/MultipleOptionsBase.Model","#RNMainFormBuilderCore/MultipleOptionsBase.Options"],(function(e,i,t,l,o,s,a,n,d){"use strict";var r;let p=l.customElement("rn-radio-field")(r=class extends t.MultipleOptionsBase{SubRender(){return o.html` <div style="position: relative;display: block;" class="layout_${this.model.Options.Layout}"> ${s.repeat(this.model.OptionItemsToUse,(e=>e.Id),(e=>o.html` <div class="option_item"> <input @click="${e=>(e.preventDefault(),e.stopPropagation(),!1)}" @mouseup="${i=>(i.preventDefault(),i.stopPropagation(),this.model.ToggleSelection(e.Id),!1)}" type="radio" .checked="${a.live(this.model.IsOptionSelected(e.Id))}"/> <label @click="${i=>this.model.ToggleSelection(e.Id)}">${e.Label}</label> </div> `))} </div> `}OnChange(e){this.model.ToggleSelection(e.target.value,!0)}})||r;class u extends n.MultipleOptionsBaseModel{get AllowMultiple(){return!1}render(){return o.html` <rn-radio-field .model="${this}"></rn-radio-field> `}}class c extends d.MultipleOptionsBaseOptions{LoadDefaultValues(){super.LoadDefaultValues(),this.Label="Radio",this.Type=i.FieldTypeEnum.Radio,this.Layout="1"}}e.EventManager.Subscribe("GetFieldOptions",(e=>{if(e==i.FieldTypeEnum.Radio)return new c})),e.EventManager.Subscribe("GetFieldModel",(e=>{if(e.Options.Type==i.FieldTypeEnum.Radio)return new u(e.Options,e.Parent)})),exports.RadioField=p,exports.RadioFieldModel=u,exports.RadioFieldOptions=c}));
