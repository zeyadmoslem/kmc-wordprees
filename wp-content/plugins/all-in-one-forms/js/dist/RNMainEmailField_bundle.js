rndefine("#RNMainEmailField",["#RNMainCore/EventManager","#RNMainFormBuilderCore/FieldBase.Options","#RNMainFormBuilderCore/FieldWithPrice.Model","lit","lit/decorators","#RNMainFormBuilderCore/FieldBase","#RNMainFormBuilderCore/FieldWithPrice","lit-html/directives/live.js","#RNMainCore/StoreBase","#RNMainFormBuilderCore/FieldWithPrice.Options","#RNMainFormBuilderCore/FormBuilder.Options"],(function(e,i,t,r,l,s,a,n,o,d,u){"use strict";class h extends t.FieldWithPriceModel{InternalSerialize(e){super.InternalSerialize(e),e.Value=this.GetValue()}GetStoresInformation(){return!0}GetIsUsed(){return!!super.GetIsUsed()&&""!=this.Text.trim()}ToText(){return this.Text}GetValue(){return this.GetIsVisible()?this.Text:""}InitializeStartingValues(){this.Text=this.GetPreviousDataProperty("Value",this.Options.DefaultText)}GetDynamicFieldNames(){return["FBEmailField"]}SetText(e){this.Text=e,""!=this.Text.trim()&&this.RemoveError("required"),this.FireValueChanged()}async Validate(){return!!super.Validate()&&(""==this.Text.trim()||this.ValidateEmail())}ValidateEmail(){return""==this.Text||this.EmailIsValid()?(this.RemoveError("invalid_email"),!0):(this.AddError("invalid_email",RNTranslate("Invalid Email")),!1)}EmailIsValid(){let e=this.Text;return/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(String(e).toLowerCase())}render(){return r.html`<rn-email-field .model="${this}"></rn-email-field>`}}var m;let p=l.customElement("rn-email-field")(m=class extends a.FieldWithPrice{static get properties(){return s.FieldBase.properties}SubRender(){return r.html` <div class={'rnTextFieldInput '+ additionalClassNames+(this.Model.IsFocused?' RNFocus':'')}> <input .readonly=${this.model.IsReadonly} @focus=${()=>{this.model.IsFocused=!0,this.model.Refresh()}} @blur=${()=>{this.model.IsFocused=!1,this.model.ValidateEmail(),this.model.Refresh()}} class='rnInputPrice' placeholder=${this.model.Options.Placeholder} style="width:100%" type='email' .value=${n.live(this.model.Text)} @input=${e=>this.OnChange(e)}/> </div> `}OnChange(e){this.model.SetText(e.target.value)}})||m;var c,F,E;let T=(c=o.StoreDataType(Object),F=class extends d.FieldWithPriceOptions{constructor(...e){super(...e),babelHelpers.initializerDefineProperty(this,"Icon",E,this)}LoadDefaultValues(){super.LoadDefaultValues(),this.Type=i.FieldTypeEnum.Email,this.Label="Email",this.Icon=(new u.IconOptions).Merge(),this.Placeholder="",this.DefaultText=""}},E=babelHelpers.applyDecoratedDescriptor(F.prototype,"Icon",[c],{configurable:!0,enumerable:!0,writable:!0,initializer:null}),F);exports.EmailFieldModel=h,exports.EmailField=p,exports.EmailFieldOptions=T,e.EventManager.Subscribe("GetFieldOptions",(e=>{if(e==i.FieldTypeEnum.Email)return new T})),e.EventManager.Subscribe("GetFieldModel",(e=>{if(e.Options.Type==i.FieldTypeEnum.Email)return new h(e.Options,e.Parent)}))}));