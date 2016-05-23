<template id="vue-delete">
    <button	type="button" 
    	:class='{
    		"btn": true,
    		"btn-danger": true,
    		"vue-delete": true,
    		"btn-xs": (size == "small"),
    		"btn-lg": (size == "large")
    	}'
    	@click="tryDelete"
	>
		<span v-if="confirmed"><slot name="confirm-text">Really?</slot> (@{{ time_remaining }})</span>
		<span v-else><slot>Remove</slot></span>
	</button>
</template>

@section('vue_components')
<script>
    vueComponents.delete = Vue.extend({
        template: '#vue-delete',
        props: {
            size: String
        },
        data: function () {
            return {
                time_remaining: 4,
                timer_object: {},
                confirmed: false
            };
        },
        methods: {
            tryDelete: function() {
                var vm = this;
                if(vm.confirmed) {
                    vm.$emit('deleted');
                    vm.time_remaining = 4;
                    vm.confirmed = false;
                } else {
                    vm.time_remaining = 4;
                    setTimeout(function() {
                        vm.confirmed = false;
                        clearTimeout(vm.timer_object);
                    }, 3000);
                    vm.setLabel();
                    vm.confirmed = true;
                }
            },
            setLabel: function() {
                var vm = this;
                if (vm.time_remaining > 0) {
                    vm.time_remaining--;
                    vm.timer_object = setTimeout(function() {
                        vm.setLabel();
                    }, 1000);
                }
            }
        }
    });

    Vue.component('delete', vueComponents.delete);

</script>
@append
