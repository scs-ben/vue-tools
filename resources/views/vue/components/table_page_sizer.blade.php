<template id="vue-table-page-sizer">
	<select2 :value.sync="comPageSize" style="display: inline-block; width: 75px;">
        <option v-for="size in sizes" :value="size">
            @{{ size }}
        </option>
    </select2>
</template>

@section('vue_components')
<script>
	vueComponents.tablePageSizer = Vue.extend({
		template: '#vue-table-page-sizer',
		props: {
			pageSize: Number,
			sizes: {
				type: Array,
	      		default: function () {
	        		return [10, 25, 50, 100];
	      		}
			}
		},
		computed: {
			comPageSize: {
				get: function() {
					if(typeof(this.pageSize) == 'undefined') {
						return this.$parent.pageSize;
					} else {
						return this.pageSize;
					}
				},
				set: function(val) {
					if(typeof(this.pageSize) == 'undefined') {
						this.$parent.pageSize = val;
					} else {
						this.pageSize = val;
					}
				}
			}
		}
	});

	Vue.component('table-page-sizer', vueComponents.tablePageSizer);

</script>
@endsection