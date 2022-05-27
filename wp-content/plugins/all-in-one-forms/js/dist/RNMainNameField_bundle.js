rndefine("#RNMainNameField",["#RNMainCore/EventManager","#RNMainFormBuilderCore/FieldBase.Options","#RNMainFormBuilderCore/FieldWithPrice.Model","#RNMainCore/StoreBase","#RNMainFormBuilderCore/FieldWithPrice.Options","#RNMainFormBuilderCore/FormBuilder.Options","lit","lit/decorators","#RNMainFormBuilderCore/FieldBase","#RNMainFormBuilderCore/IconDirective","#RNMainFormBuilderCore/FieldWithPrice","lit-html/directives/live.js"],(function(e,t,i,s,a,r,l,n,o,m,d,h){"use strict";var u,F,N;let c;!function(e){e.Single="single",e.FirstAndLast="first_and_last"}(c||(c={}));let p=(u=s.StoreDataType(r.IconOptions),F=class extends a.FieldWithPriceOptions{constructor(...e){super(...e),babelHelpers.initializerDefineProperty(this,"Icon",N,this)}LoadDefaultValues(){super.LoadDefaultValues(),this.Label="Name",this.Type=t.FieldTypeEnum.Name,this.Format=c.FirstAndLast,this.FirstNameLabel="First Name",this.LastNameLabel="Last Name",this.FirstNameDefaultText="",this.LastNameDefaultText="",this.FirstNamePlaceholder="",this.LastNamePlaceholder="",this.Icon=(new r.IconOptions).Merge()}},N=babelHelpers.applyDecoratedDescriptor(F.prototype,"Icon",[u],{configurable:!0,enumerable:!0,writable:!0,initializer:null}),F);class I{}class L extends I{GetValue(){return{Name:this.Name,Format:c.Single}}SetFirstName(e){this.Name=e}SetLastName(e){}IsUsed(){return""!=this.Name.trim()}ToText(){return this.Name}GetFirstName(){return this.Name}GetLastName(){return""}InitializeStartingValues(e){this.Name=e.GetPreviousDataProperty("Value,Name",e.Options.FirstNameDefaultText)}}class v extends I{GetValue(){return{FirstName:this.FirstName,LastName:this.LastName,Format:c.FirstAndLast}}SetFirstName(e){this.FirstName=e}SetLastName(e){this.LastName=e}IsUsed(){return""!=this.FirstName.trim()&&""!=this.LastName.trim()}ToText(){let e=this.FirstName.trim();return""!=e&&(e+=" "),e+this.LastName}GetFirstName(){return this.FirstName}GetLastName(){return this.LastName}InitializeStartingValues(e){this.FirstName=e.GetPreviousDataProperty("Value,FirstName",e.Options.FirstNameDefaultText),this.LastName=e.GetPreviousDataProperty("Value,LastName",e.Options.LastNameDefaultText)}}class O extends i.FieldWithPriceModel{constructor(e,t){super(e,t),this.IsFocused=!1,this.Options.Format==c.Single?this.Formatter=new L:this.Formatter=new v}InternalSerialize(e){super.InternalSerialize(e),e.Value=this.GetValue()}GetStoresInformation(){return!0}GetIsUsed(){return!!super.GetIsUsed()&&this.Formatter.IsUsed()}InternalToText(){return this.Formatter.ToText()}GetValue(){return this.GetIsVisible()?this.Formatter.GetValue():null}GetFirstName(){return this.Formatter.GetFirstName()}GetLastName(){return this.Formatter.GetLastName()}InitializeStartingValues(){this.Formatter.InitializeStartingValues(this)}GetDynamicFieldNames(){return["FBName"]}SetFirstName(e){this.Formatter.SetFirstName(e),this.Formatter.IsUsed()&&this.RemoveError("required"),this.FireValueChanged()}SetLastName(e){this.Formatter.SetLastName(e),this.Formatter.IsUsed()&&this.RemoveError("required"),this.FireValueChanged()}render(){return l.html`<rn-name-field .model="${this}"></rn-name-field>`}}var f;let y=n.customElement("rn-name-field")(f=class extends d.FieldWithPrice{static get properties(){return o.FieldBase.properties}SubRender(){return this.model.Options.Format==c.FirstAndLast?l.html` <div class='rnTextFieldInput' style="white-space: nowrap"> <div class='rncolsm2'> ${this.GetLabel(this.model.Options.FirstNameLabel,!0)} <div style="position: relative"> <input ${m.IconDirective(this.model.Options.Icon)} ?readOnly=${this.model.IsReadonly} @focus=${()=>{this.model.IsFocused=!0,this.model.Refresh()}} @blur=${()=>{this.model.IsFocused=!1,this.model.Refresh()}} class='rnInputPrice' placeholder=${this.model.Options.FirstNamePlaceholder} style="width: 100%" type='text' .value=${h.live(this.model.GetFirstName())} @change=${e=>this.OnChangeFirstName(e)}/> </div> </div> <div class='rncolsm2'> ${this.GetLabel(this.model.Options.LastNameLabel,!0)} <input ?readOnly=${this.model.IsReadonly} @focus=${()=>{this.model.IsFocused=!0,this.model.Refresh()}} @blur=${()=>{this.model.IsFocused=!1,this.model.Refresh()}} class='rnInputPrice' placeholder=${this.model.Options.LastNamePlaceholder} style="width: 100%" type='text' .value=${h.live(this.model.GetLastName())} @change=${e=>this.OnChangeLastName(e)}/> </div> </div> `:l.html` <div class='rnTextFieldInput'> <div style="position: relative"> <input ${m.IconDirective(this.model.Options.Icon)} ?readOnly=${this.model.IsReadonly} @focus=${()=>{this.model.IsFocused=!0,this.model.Refresh()}} @blur=${()=>{this.model.IsFocused=!1,this.model.Refresh()}} class='rnInputPrice' .placeholder=${this.model.Options.FirstNamePlaceholder} style="width: 100%;" type='text' .value=${this.model.GetFirstName()} @change=${e=>this.OnChangeFirstName(e)}/> </div> </div> `}OnChangeFirstName(e){this.model.SetFirstName(e.target.value)}OnChangeLastName(e){this.model.SetLastName(e.target.value)}})||f;exports.NameFieldModel=O,exports.NameField=y,exports.NameFieldOptions=p,exports.NameFormatEnum=c,e.EventManager.Subscribe("GetFieldOptions",(e=>{if(e==t.FieldTypeEnum.Name)return new p})),e.EventManager.Subscribe("GetFieldModel",(e=>{if(e.Options.Type==t.FieldTypeEnum.Name)return new O(e.Options,e.Parent)}))}));
