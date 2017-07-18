webpackJsonp([3],{115:function(t,e,s){var r=s(44)(s(332),s(342),null,null,null);t.exports=r.exports},332:function(t,e,s){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r=s(333),a=function(t){return t&&t.__esModule?t:{default:t}}(r);e.default={components:{MasterPassword:a.default},created:function(){this.$store.dispatch("getUser")},computed:{is_unlocked:function(){return this.$store.state.is_unlocked}}}},333:function(t,e,s){var r=s(44)(s(334),s(341),null,null,null);t.exports=r.exports},334:function(t,e,s){"use strict";function r(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"__esModule",{value:!0});var a=s(335),o=r(a),n=s(338),i=r(n);e.default={components:{"unlock-screen":o.default,"create-master-password":i.default},computed:{userHasBeenLoaded:function(){return this.$store.state.user},masterPasswordHasBeenSet:function(){return this.$store.state.hasMasterPassword}}}},335:function(t,e,s){var r=s(44)(s(336),s(337),null,null,null);t.exports=r.exports},336:function(t,e,s){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={data:function(){return{password:""}},methods:{unlock:function(){this.$store.dispatch("unlock",{password:this.password,redirect:this.$route.query.redirect})}}}},337:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",[s("div",{staticClass:"alert alert-info"},[t._v("\n        Welcome back! Enter your Master Password to access your Journal.\n    ")]),t._v(" "),s("form",{on:{submit:function(e){e.preventDefault(),t.unlock(e)}}},[s("div",{staticClass:"form-group"},[s("div",{staticClass:"input-group"},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.password,expression:"password"}],staticClass:"form-control input-lg",attrs:{type:"password",placeholder:"Enter Master Password"},domProps:{value:t.password},on:{input:function(e){e.target.composing||(t.password=e.target.value)}}}),t._v(" "),t._m(0)])])])])},staticRenderFns:[function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("span",{staticClass:"input-group-btn"},[s("button",{staticClass:"btn btn-success btn-lg",attrs:{type:"submit"}},[s("i",{staticClass:"fa fa-unlock-alt"}),t._v(" Unlock\n                    ")])])}]}},338:function(t,e,s){var r=s(44)(s(339),s(340),null,null,null);t.exports=r.exports},339:function(t,e,s){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={data:function(){return{password:"",password_confirmation:""}},computed:{password_match:function(){return this.password==this.password_confirmation}},methods:{create:function(){this.$store.dispatch("createMasterPassword",{password:this.password,password_confirmation:this.password_confirmation})}}}},340:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",[s("div",{staticClass:"alert alert-warning"},[t._v("\n        You haven't setup a Master Password yet. Creat Master Password now!\n    ")]),t._v(" "),s("form",{on:{submit:function(e){e.preventDefault(),t.create(e)}}},[s("div",{staticClass:"form-group"},[s("label",[t._v("Master Password")]),t._v(" "),s("input",{directives:[{name:"model",rawName:"v-model",value:t.password,expression:"password"}],staticClass:"form-control",attrs:{type:"password",placeholder:"Password"},domProps:{value:t.password},on:{input:function(e){e.target.composing||(t.password=e.target.value)}}})]),t._v(" "),s("div",{staticClass:"form-group"},[s("label",[t._v("Confirm your password")]),t._v(" "),s("input",{directives:[{name:"model",rawName:"v-model",value:t.password_confirmation,expression:"password_confirmation"}],staticClass:"form-control",attrs:{type:"password",placeholder:"Password Confirmation"},domProps:{value:t.password_confirmation},on:{input:function(e){e.target.composing||(t.password_confirmation=e.target.value)}}})]),t._v(" "),s("button",{staticClass:"btn btn-success",attrs:{disabled:!t.password_match},on:{click:t.create}},[t._v("Create Master Password")])])])},staticRenderFns:[]}},341:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,s=t._self._c||e;return t.userHasBeenLoaded?s("div",[t.masterPasswordHasBeenSet?s("unlock-screen"):t._e(),t._v(" "),t.masterPasswordHasBeenSet?t._e():s("create-master-password")],1):t._e()},staticRenderFns:[]}},342:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"d-flex justify-content-center align-items-center"},[t.is_unlocked?t._e():s("master-password")],1)},staticRenderFns:[]}}});