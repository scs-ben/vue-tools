<template id="vue-select2">
	<div>
		<select>
			
		</select>
		<div class="options hidden">
			<slot></slot>
		</div>
	</div>
</template>

@section('vue_components')
<script>
	vueComponents.select2 = Vue.extend({
		template: '#vue-select2',
		props: {
			value: null,
			disabled: String
		},
		ready: function() {
			var $select = $(this.$el).find('select');
			$select.html($(this.$el).find('.options').html());
			var vm = this;
			setTimeout(function() {
				$select.select2({
		            width: '100%',
		            minimumResultsForSearch: 6
		        });
				
				$select.on('select2:select', function() {
					vm.value = $select.val();
				});
			}, 50);
			
		},
		watch: {
	    	value: function (val, oldVal) {
	    		var $select = $(this.$el).find('select');
	    		$select.val(this.value);
	    		$select.trigger('change');
	      	}
	    }
	});

	Vue.component('select2', vueComponents.select2);

</script>
@append