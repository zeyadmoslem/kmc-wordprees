rndefine("#RNMainChangeOptionsCondition",["#RNMainFormBuilderCore/ConditionBase.Options","#RNMainCore/StoreBase","#RNMainFormBuilderCore/ItemOptions.Options"],(function(e,i,t){"use strict";var n,o,r;let s=(n=i.StoreDataType(t.ItemOptions),o=class extends e.ConditionBaseOptions{constructor(...e){super(...e),babelHelpers.initializerDefineProperty(this,"Options",r,this)}LoadDefaultValues(){super.LoadDefaultValues(),this.Type="ChangeOptions",this.Options=[(new t.ItemOptions).Merge({Id:1,RegularPrice:"",Label:"Option 1"}),(new t.ItemOptions).Merge({Id:2,RegularPrice:"",Label:"Option 2"}),(new t.ItemOptions).Merge({Id:3,RegularPrice:"",Label:"Option 3"})]}},r=babelHelpers.applyDecoratedDescriptor(o.prototype,"Options",[n],{configurable:!0,enumerable:!0,writable:!0,initializer:null}),o);exports.ChangeOptionsConditionOptions=s}));