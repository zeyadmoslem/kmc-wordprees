rndefine("#RNMainNumericField",["#RNMainCore/EventManager","#RNMainFormBuilderCore/FieldBase.Options","#RNMainFormBuilderCore/FieldWithPrice.Model","lit","lit/decorators","#RNMainFormBuilderCore/FieldBase","#RNMainFormBuilderCore/IconDirective","#RNMainFormBuilderCore/FieldWithPrice","lit-html/directives/live.js","#RNMainCore/StoreBase","#RNMainFormBuilderCore/FieldWithPrice.Options","#RNMainFormBuilderCore/FormBuilder.Options"],(function(e,i,t,r,s,l,n,a,o,u,d,h){"use strict";class m extends t.FieldWithPriceModel{constructor(e,i){super(e,i),this.IsFocused=!1}InternalSerialize(e){super.InternalSerialize(e),e.Value=this.GetValue()}GetStoresInformation(){return!0}GetIsUsed(){return!!super.GetIsUsed()&&""!=this.Text.trim()}InternalToText(){return this.Text}GetValue(){return this.GetIsVisible()?this.Text:""}InitializeStartingValues(){this.Text=this.GetPreviousDataProperty("Value",this.Options.DefaultValue)}ToText(){return this.Text}SetText(e){this.Text=e,""!=this.Text.trim()&&this.RemoveError("required");let i=parseFloat(this.Text);if(isNaN(i))return this.Text="",void this.FireValueChanged();if(""!=this.Options.MaximumValue){let e=parseFloat(this.Options.MaximumValue);i>e?this.AddError("MaximumValue",RNTranslate("The maximum value is ")+e):this.RemoveError("MaximumValue")}if(""!=this.Options.MinimumValue){let e=parseFloat(this.Options.MinimumValue);i<e?this.AddError("MinimumValue",RNTranslate("The minimum value is ")+e):this.RemoveError("MinimumValue")}this.FireValueChanged()}render(){return r.html`<rn-numeric-field .model="${this}"></rn-numeric-field>`}}var c;let p=s.customElement("rn-numeric-field")(c=class extends a.FieldWithPrice{static get properties(){return l.FieldBase.properties}SubRender(){return r.html` <div style="position: relative;"> <input @keypress=${e=>this.OnKeyPress(e)} ${n.IconDirective(this.model.Options.Icon)} ?readOnly=${this.model.IsReadonly} @focus=${()=>{this.model.IsFocused=!0,this.model.Refresh()}} @blur=${()=>{this.model.IsFocused=!1,this.model.Refresh()}} class='rnInputPrice' placeholder=${this.model.Options.Placeholder} style="width: 100%;" type='number' value=${o.live(this.model.ToText())} @input=${e=>this.OnChange(e)}/> </div> `}OnKeyPress(e){var i=e.which?e.which:e.keyCode;return"."==e.key?0!=this.model.Options.NumberOfDecimals&&!this.model.Text.includes(".")||(e.preventDefault(),!1):!(i>31&&(i<48||i>57))||(e.preventDefault(),!1)}OnChange(e){if(e.target.value.includes(".")&&this.model.Options.NumberOfDecimals>0){let i=e.target.value.split(".");if(i.length>1&&i[1].length>this.model.Options.NumberOfDecimals)return void this.forceUpdate()}this.model.SetText(e.target.value)}})||c;var F,O,f;let v=(F=u.StoreDataType(Object),O=class extends d.FieldWithPriceOptions{constructor(...e){super(...e),this.FreeCharOrWords=0,babelHelpers.initializerDefineProperty(this,"Icon",f,this)}LoadDefaultValues(){super.LoadDefaultValues(),this.Type=i.FieldTypeEnum.Numeric,this.Label="Numeric",this.NumberOfDecimals=2,this.MinimumValue="",this.MaximumValue="",this.IgnoreSpaces=!1,this.Icon=(new h.IconOptions).Merge(),this.Placeholder="",this.DefaultValue="",this.FreeCharOrWords=0}},f=babelHelpers.applyDecoratedDescriptor(O.prototype,"Icon",[F],{configurable:!0,enumerable:!0,writable:!0,initializer:null}),O);exports.NumericFieldModel=m,exports.NumericField=p,exports.NumericFieldOptions=v,e.EventManager.Subscribe("GetFieldOptions",(e=>{if(e==i.FieldTypeEnum.Numeric)return new v})),e.EventManager.Subscribe("GetFieldModel",(e=>{if(e.Options.Type==i.FieldTypeEnum.Numeric)return new m(e.Options,e.Parent)}))}));
