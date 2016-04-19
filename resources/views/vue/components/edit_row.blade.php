vueComponents.editRow = Vue.component('edit-row', {
    props: {
        row: Object,
        mode: String
    },
    watch: {
        row: {
            handler: function(newVal, oldVal) {
                this.row.vue_updated = 1;
            },
            deep: true,
        }
    },
    attached: function() {
        if(typeof($root.formValidation) != 'undefined') {
            $(this.$el).find('.validate').each(function (index, element) {
                $root.formValidation.addField($(element));
            });
        }
    },
    detached: function() {
        if(typeof($root.formValidation) != 'undefined') {
            $(this.$el).find('.validate').each(function (index, element) {
                $root.formValidation.resetField($(element));
                $root.formValidation.removeField($(element));
            });
        }
    },
    methods: {
        delete: function () {
            this.row.vue_deleted = 1;
            this.row.vue_updated = 1;
        }
    }
});