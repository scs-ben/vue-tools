<template id="vue-table-searcher">
    <input type="text" 
        v-model="comSearchText" 
        placeholder="Search"
        class="form-control"
    />
</template>

@section('vue_components')
<script>
	vueComponents.tableSearcher = Vue.extend({
		template: '#vue-table-searcher',
		props: {
			searchText: String,
		},
		computed: {
			comSearchText: {
				get: function() {
					if(typeof(this.searchText) == 'undefined') {
						return this.$parent.searchText;
					} else {
						return this.searchText;
					}
				},
				set: function(val) {
					if(typeof(this.searchText) == 'undefined') {
						this.$parent.searchText = val;
					} else {
						this.searchText = val;
					}
				}
			}
		}
	});

	Vue.component('table-searcher', vueComponents.tableSearcher);
</script>
@endsection