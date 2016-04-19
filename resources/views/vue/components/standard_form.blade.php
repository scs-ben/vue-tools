<template id="vue-standard-form">
	<div>
		<show-mode>
			<div slot="header"></div>
			<span slot="header-text"></span>
			<div slot="header-buttons"></div>
			<!-- body text goes here -->
			<div slot="footer"></div>
		</show-mode>
		<edit-mode>
			<div slot="header"></div>
			<span slot="header-text"></span>
			<div slot="header-buttons"></div>
			<!-- body text goes here -->
			<div slot="footer"></div>
			<div slot="footer-cancel"></div>
			<div slot="footer-delete"></div>
		</edit-mode>
	</div>
</template>

<template id="vue-standard-form-show-partial">
	<div class="box box-primary">
		<div class="box-header with-border">
			<slot name="header">
				<h3 class="box-title">
					<slot name="header-text"></slot>
				</h3>
				<slot name="header-buttons">
					<button type="button"
						class="btn btn-default pull-right" 
						@click="this.$parent.modify()"
					>Modify</button>
				</slot>
			</slot>
		</div>
		<div class="box-body">
			<slot></slot>
		</div>
		<div class="box-footer">
			<slot name="footer">
			</slot>
		</div>
	</div>
</template>

<template id="vue-standard-form-edit-partial">
	<div class="box box-primary">
		<div class="box-header with-border">
			<slot name="header">
				<h3 class="box-title">
					<slot name="header-text"></slot>
				</h3>
				<slot name="header-buttons">
					<button type="button"
						class="btn btn-warning pull-right"
						@click="this.$parent.save()"
					>Save</button>
					<button type="button"
						class="btn btn-default pull-right margin-right" 
						@click="this.$parent.cancel()"
					>Cancel</button>
				</slot>
			</slot>
		</div>
		<div class="box-body">
			<slot></slot>
		</div>
		<div class="box-footer">
			<slot name="footer"></slot>
				<slot name="footer-cancel"></slot>
				<slot name="footer-delete"></slot>
			</div>
		</div>
	</div>
</template>

@section('vue_components')
<script>
	vueForms.standardForm = Vue.extend({
		props: {
			storedRecords: {
				coerce: function (val) {
					return JSON.parse(val);
		      	}
			},
			mode: {
				type: String,
				default: 'show'
			},
			newUrl: {
				type: String,
				default: ''
			},
			editUrl: {
				type: String,
				default: ''
			}
		},
		data: function() {
			var data = {};
			data.records = this._cloneRecords(this.storedRecords);
			return data;
		},
		ready: function() {
			var vm = this;
			window.addEventListener("beforeunload", function (e) {
				if(vm.mode == "edit") {
					var confirmationMessage = 'It looks like you have been editing something. '
				                            + 'If you leave before saving, your changes will be lost.';

				    (e || window.event).returnValue = confirmationMessage; //Gecko + IE
				    return confirmationMessage; //Gecko + Webkit, Safari, Chrome etc.	
				}
			});
		},
		methods: {
			_cloneRecords: function(records) {
				var recordKeys = Object.keys(records);
				var rtn = new Object;

				for (var i = 0; i < recordKeys.length; i++) {
					rtn[recordKeys[i]] = new Object;
					rtn[recordKeys[i]].model = records[recordKeys[i]].model;
					rtn[recordKeys[i]].type = records[recordKeys[i]].type;
					if(records[recordKeys[i]].type == 'object') {
						rtn[recordKeys[i]].data = clone(records[recordKeys[i]].data)
					} else if(records[recordKeys[i]].type == 'array') {
						rtn[recordKeys[i]].data = new Array;
						for(var k = 0; k < records[recordKeys[i]].data.length; k++) {
							rtn[recordKeys[i]].data[k] = clone(records[recordKeys[i]].data[k]);
						}
					}
				}
				return rtn;
			},
			resetForm: function () {
				this.records = this._cloneRecords(this.storedRecords);
			},
			saveForm: function () {
				Ajax.saveForm(this.records, this, this.editUrl);
				if(typeof($root.formValidation) != 'undefined') {
					$root.formValidation.resetForm();
				}
			},
			saveNewForm: function () {
				Ajax.saveNewForm(this.records, this, this.newUrl);
				if(typeof($root.formValidation) != 'undefined') {
					$root.formValidation.resetForm();
				}
			},
			modify: function() {
				this.mode = 'edit';
			},
			cancel: function() {
				this.resetForm();
				this.mode = 'show';
				if(typeof($root.formValidation) != 'undefined') {
					$root.formValidation.resetForm();
				}
			},
			save: function(recursive) {
				var vm = this;
				if(typeof(recursive) == "undefined") {
					recursive = false;
				}

				if (this.validationIsValid(recursive) == null) {
				    // Stop submission because of validation error.
				    setTimeout(function() {vm.save(true)}, 150);
				    return false;

				} else if (this.validationIsValid(recursive) == false) {
					return false;
					
				}

				this.saveForm();
				this.mode = 'show';
			},
			saveNew: function(recursive) {
				var vm = this;
				if(typeof(recursive) == "undefined") {
					recursive = false;
				}

				if (this.validationIsValid(recursive) == null) {
				    // Stop submission because of validation error.
				    setTimeout(function() {vm.saveNew(true)}, 150);
				    return false;

				} else if (this.validationIsValid(recursive) == false) {
					return false;
					
				}

				this.saveNewForm();
				this.mode = 'show';
			},
			validationIsValid: function (recursive) {
				if(typeof($root.formValidation) == 'undefined') {
					return true;
				}

				if(typeof(recursive) == "undefined") {
					recursive = false;
				}

				// Validate the container
				if(recursive === false) {
					$root.formValidation.resetForm();
					$root.formValidation.validate();
				}
				var isValidContainer = $root.formValidation.isValid();
				
				if (isValidContainer === false || isValidContainer === null) {
				    // if (isValidContainer === false)
				    // 	$.unblockUI();
				    
				    // Stop submission because of validation error.
				    return isValidContainer;

				} else {
					return true;
					
				}
			}
		}
	});

	Vue.component('standard-form', vueForms.standardForm);
</script>
@endsection