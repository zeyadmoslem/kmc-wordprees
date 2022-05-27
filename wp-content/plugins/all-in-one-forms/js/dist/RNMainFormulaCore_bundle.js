rndefine("#RNMainFormulaCore",["#RNMainCore/EventManager","#RNMainFormBuilderCore/FieldBase.Model","#RNMainFormBuilderCore/MultipleOptionsBase.Model","#RNMainFormBuilderCore/FormBuilder.Options","#RNMainFormBuilderCore/CalculatorBase"],(function(e,t,s,r,a){"use strict";class i{constructor(e,t){this.Parent=e,this.Data=t,this.IsParseElement=!0}GetMain(){return null==this.Parent?this:this.Parent.GetMain()}}class n extends i{constructor(e,t){super(e,t)}Parse(){return parseFloat(this.Data.d)}}class l extends i{constructor(e,t){super(e,t)}Parse(){return this.Data.Value}}class h extends i{constructor(e,t){super(e,t)}Parse(){return this.Data.Text}}class c extends i{GetPriceFromField(e){return this.GetMain().Owner==e?e.GetPriceWithoutFormula():e.GetPrice()}}class u extends c{constructor(e,t){super(e,t),this.Left=I.GetParseElement(this,this.Data.Left),this.Right=I.GetParseElement(this,this.Data.Right)}Parse(){switch(this.Data.type){case"MUL":return this.GetScalarOrPrice(this.Left.Parse())*this.GetScalarOrPrice(this.Right.Parse());case"ADD":let e=this.ToScalar(this.Left.Parse()),s=this.ToScalar(this.Right.Parse());return e instanceof t.FieldBaseModel&&(e="string"==typeof s?e.ToText():this.GetScalarOrPrice(e)),s instanceof t.FieldBaseModel&&(s="string"==typeof e?s.ToText():this.GetScalarOrPrice(s)),e+s;case"SUB":return this.GetScalarOrPrice(this.ToScalar(this.Left.Parse()))-this.GetScalarOrPrice(this.ToScalar(this.Right.Parse()));case"DIV":return 0==this.GetScalarOrPrice(this.ToScalar(this.Right.Parse()))?0:this.GetScalarOrPrice(this.ToScalar(this.Left.Parse()))/this.GetScalarOrPrice(this.ToScalar(this.Right.Parse()))}}GetScalarOrPrice(e){return e instanceof t.FieldBaseModel?this.GetPriceFromField(e):e}ToScalar(e){return Array.isArray(e)?e.reduce(((e,t)=>e+t),0):e}}class o extends i{constructor(e,t){super(e,t),null!=this.Data.d&&(this.Child=I.GetParseElement(this,this.Data.d))}Parse(){switch(this.Data.op){case"SIN":return Math.sin(this.Child.Parse());case"COS":return Math.cos(this.Child.Parse());case"TAN":return Math.tan(this.Child.Parse());case"ASIN":return Math.asin(this.Child.Parse());case"ATAN":return Math.atan(this.Child.Parse());case"ACOS":return Math.acos(this.Child.Parse());case"SQRT":return Math.sqrt(this.Child.Parse());case"LN":return Math.log(this.Child.Parse());case"PI":return 3.14159265359;case"E":return 2.718281828459045}}}class d extends i{constructor(e,t){super(e,t),this.Sentence=I.GetParseElement(this,this.Data.Sentence),null!=this.Data.Next&&(this.Next=I.GetParseElement(this,this.Data.Next))}Parse(){return this.Sentence.Parse()}}class P extends i{constructor(e,t){super(e,t),this.Args=[];for(let e of this.Data.Args)this.Args.push(I.GetParseElement(this,e))}Parse(){return 0==this.Args.length?null:this.Args[0].Parse()}}class m extends i{constructor(e,t){super(e,t),this.Condition=I.GetParseElement(this,t.Condition),this.Result=I.GetParseElement(this,t.Result)}Parse(){return!0===this.Condition.Parse()?this.Result.Parse():null}}class f extends i{GetPriceFromField(e){return this.GetMain().Owner==e?e.GetPriceWithoutFormula():e.GetPrice()}}class p extends f{constructor(e,t){super(e,t),this.Left=I.GetParseElement(this,t.Left),this.Right=I.GetParseElement(this,t.Right)}Parse(){let e=this.Data.operator;if(null==this.Right)return 1==this.Left.Parse();let r=this.Left.Parse(),a=this.Right.Parse(),i=this.Left.Parse(),n=this.Right.Parse();switch(i instanceof t.FieldBaseModel&&(i="string"==typeof n?i.ToText():this.GetPriceFromField(i)),n instanceof t.FieldBaseModel&&(n="string"==typeof i?n.ToText():this.GetPriceFromField(n)),e){case"==":return i==n;case"!=":return i!=n;case">":return i>n;case">=":return i>=n;case"<":return i<n;case"<=":return i<=n;case"contains":case"not contains":let l=i,h=n;if(r instanceof s.MultipleOptionsBaseModel&&(l=r.GetSelectedOptions().map((e=>e.Label))),a instanceof s.MultipleOptionsBaseModel&&(h=a.GetSelectedOptions().map((e=>e.Label))),!Array.isArray(l)&&!Array.isArray(h)){r instanceof t.FieldBaseModel&&(l=r.ToText()),a instanceof t.FieldBaseModel&&(h=a.ToText());let s=l.toLowerCase().indexOf(h.toLowerCase())>=0;return"contains"==e?s:!s}Array.isArray(h)||(h=[h]),Array.isArray(l)||(l=[l]);for(let e=0;e<l.length;e++)l[e]instanceof t.FieldBaseModel&&(l[e]=this.GetPriceFromField(l[e]));for(let e=0;e<h.length;e++)h[e]instanceof t.FieldBaseModel&&(h[e]=this.GetPriceFromField(h[e]));if("contains"==e){for(let e of h)if(l.some((t=>t==e)))return!0;return!1}if("not contains"==e){for(let e of h)if(l.some((t=>t==e)))return!1;return!0}}}}class G extends i{constructor(e,t){super(e,t),this.Operation=t.Operation,this.Comparator=I.GetParseElement(this,t.Comparator),this.Next=I.GetParseElement(this,t.Next)}Parse(){let e=1==this.Comparator.Parse();if(null==this.Next)return e;let t=1==this.Next.Parse();return"&&"==this.Operation?e&&t:e||t}}class F extends i{constructor(e,t){super(e,t),this.IsParseField=!0,this.FieldId=this.Data.Id,this.Field=this.GetMain().FieldList.find((e=>e.Options.Id==this.FieldId))}Parse(){return null==this.Field?0:this.Field}}class N extends i{constructor(e,t){super(e,t),this.Elements=[];for(let e of this.Data.Elements)this.Elements.push(I.GetParseElement(this,e).Parse())}Parse(){return this.Elements}}class x extends i{constructor(e,t){super(e,t),this.Child=I.GetParseElement(this,t.Child)}Parse(){return!this.Child.Parse()}}class E extends i{constructor(e,t){super(e,t),this.Sentence=I.GetParseElement(this,t.Sentence)}Parse(){return this.Sentence.Parse()}}class M extends i{constructor(e,t){super(e,t),this.Sentences=[];for(let e of t.Sentences)this.Sentences.push(I.GetParseElement(this,e))}Parse(){let e=null;for(let t of this.Sentences){if(t instanceof E)return t;let s=t.Parse();if(s instanceof E)return s;null!=s&&(e=s)}return e}}class S extends i{constructor(e,t){super(e,t),this.VariableName=this.Data.Name,this.Assignment=I.GetParseElement(this,this.Data.Assignment)}Parse(){let e=this.Assignment.Parse();return this.GetMain().SetVariable(this.VariableName,e),e}}class A extends i{constructor(e,t){super(e,t),this.VariableName=t.d}Parse(){return this.GetMain().GetVariable(this.VariableName)}}class g extends i{constructor(e,t){super(e,t),this.Config=null;let s=I.GetParseElement(this,t.d).Parse();this.Config=JSON.parse(s)}Parse(){return this.GetMain().Owner.GetFixedValue(this.Config)}}class C{static GetNumber(e){if(null==e)return 0;if(e instanceof t.FieldBaseModel)return e.GetPrice();let s=Number(e);return isNaN(s)?0:s}static GetText(e){return null==e?"":e instanceof t.FieldBaseModel?e.ToText():e.toString()}static Round(e,t){return C.GetNumber(e).toFixed(C.GetNumber(t))}static Ceil(e){return Math.ceil(C.GetNumber(e))}}class T extends i{constructor(e,t){super(e,t),this.Args=[],this.Method=this.Data.Method;for(let e of t.Args)this.Args.push(I.GetParseElement(this,e))}Parse(){if(null!=C[this.Method])return C[this.Method].apply(this,this.Args.map((e=>e.Parse())));throw new Error("Invalid function used "+this.Method)}}class O extends i{constructor(e,t){if(super(e,t),this.Args=[],this.Name=t.Name,this.Object=I.GetParseElement(this,t.Object).Parse(),null!=t.Args)for(let e of t.Args)this.Args.push(I.GetParseElement(this,e));if(null==this.Object)throw new Error("Invalid method call "+this.Name);this.GetNameToUse()}GetNameToUse(){let e=this.Name;if(void 0===this.Object[e]&&(e="Get"+e),void 0===this.Object[e])throw new Error("Invalid method "+this.Name);return e}Parse(){if(null==this.Object)throw new Error("Invalid method call "+this.Name);return this.Object[this.GetNameToUse()].apply(this.Object,this.Args.map((e=>e.Parse())))}}class w extends i{constructor(e,t){if(super(e,t),this.Array=I.GetParseElement(this,t.Array),this.Index=Number(t.Index),isNaN(this.Index))throw new Error("Invalid Index")}Parse(){let e=this.Array.Parse();return Array.isArray(e)?null==e[this.Index]?null:e[this.Index]:null}}class I{static GetParseElement(e,t){if(null==t)return null;switch(t.type){case"NUMBER":return new n(e,t);case"BOOLEAN":return new l(e,t);case"STRING":return new h(e,t);case"MATH":return new o(e,t);case"MUL":case"ADD":case"SUB":case"DIV":return new u(e,t);case"SENTENCE":return new d(e,t);case"P":return new P(e,t);case"CONDSENTENCE":return new m(e,t);case"COMPARATOR":return new p(e,t);case"CONDITION":return new G(e,t);case"FIELD":return new F(e,t);case"ARR":return new N(e,t);case"NEGATION":return new x(e,t);case"BLOCK":return new M(e,t);case"DECLARATION":return new S(e,t);case"RETURN":return new E(e,t);case"VARIABLE":return new A(e,t);case"FIXED":return new g(e,t);case"FUNC":return new T(e,t);case"METHOD":return new O(e,t);case"ARRITEM":return new w(e,t);default:throw Error("Invalid token "+t.type)}}}class R extends c{constructor(e,t,s=null,r=null){if(super(null,t),this.FieldList=e,this.Owner=s,this.ExecutionChain=r,this.Sentences=[],this.Variables=[],this.Data.length>0)for(let e of this.Data[0].Sentences)this.Sentences.push(I.GetParseElement(this,e))}InternalParse(){let e=null;for(let t of this.Sentences){if(t instanceof E)return t.Parse();let s=t.Parse();if(s instanceof E)return s.Parse();null!==s&&(e=s)}return e}Parse(){let e=this.InternalParse();return Array.isArray(e)?e.reduce(((e,t)=>e+this.ParseSingleNumber(t)),0):this.ParseSingleNumber(e)}ParseSingleNumber(e){if(null==e)return 0;if(e instanceof t.FieldBaseModel)return this.GetPriceFromField(e);let s=parseFloat(e);return isNaN(s)?0:s}ParseText(){let e=this.InternalParse();return Array.isArray(e)?e.map((e=>this.ParseSingleText(e))).join(", "):this.ParseSingleText(e)}ParseSingleText(e){return null==e?"":e instanceof t.FieldBaseModel?e.ToText():e.toString()}SetVariable(e,t){let s=this.Variables.find((t=>t.Name==e));null==s&&(s={Name:e,Value:null},this.Variables.push(s)),s.Value=t}GetVariable(e){var t;return null===(t=this.Variables.find((t=>t.Name==e)))||void 0===t?void 0:t.Value}}class D extends a.CalculatorBase{ExecuteCalculation(e,t){return{Quantity:0,RegularPrice:0}}async ExecuteAndUpdate(e=!1,t=!1,s=null){return!this.GetIsUsed()&&this.Field.IsPriceField?this.Field.Calculator.UpdatePrice(0):this.Field.FormulaManager.ExecuteFormulaIfExist("Price",null),!0}}exports.ParseField=class extends i{constructor(e,t){super(e,t),this.IsParseField=!0,this.FieldId=this.Data.Id,this.Field=this.GetMain().FieldList.find((e=>e.Options.Id==this.FieldId))}Parse(){return null==this.Field?0:this.Field}},exports.ParseMain=R,exports.ParserElementBase=class{constructor(e,t){this.Parent=e,this.Data=t,this.IsParseElement=!0}GetMain(){return null==this.Parent?this:this.Parent.GetMain()}},e.EventManager.Subscribe("CalculateFormula",(e=>{if(null==e.Formula.Compiled)return;let t=new R(e.FieldList,e.Formula.Compiled,e.Owner,e.Chain);try{return e.Formula.PreferredReturnType==r.PreferredReturnTypeEnum.Price?t.Parse():t.ParseText()}catch(e){return 0}})),e.EventManager.Subscribe("GetCalculator",(e=>{if("formula"==e)return new D}))}));