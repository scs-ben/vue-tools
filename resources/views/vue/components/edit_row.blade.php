@section('vue_components')
<script>
vueComponents.editRow = Vue.component('edit-row', {
    props: {
        row: Object,
        mode: String
    },
    watch: {
        row: {
            handler: function(newVal, oldVal) {
                this.row.vue_updated = true;
            },
            deep: true,
        }
    },
    attached: function() {
        if(typeof(this.$root.formValidation) != 'undefined') {
            $(this.$el).find('.validate').each(function (index, element) {
                this.$root.formValidation.addField($(element));
            });
        }
    },
    detached: function() {
        if(typeof(this.$root.formValidation) != 'undefined') {
            $(this.$el).find('.validate').each(function (index, element) {
                this.$root.formValidation.resetField($(element));
                this.$root.formValidation.removeField($(element));
            });
        }
    },
    methods: {
        save: function() {
            if(this.row.vue_updated == true) {
                
            }
        }
        delete: function () {
            this.row.vue_deleted = true;
            this.row.vue_updated = true;
        }
    }
});
</script>
@append