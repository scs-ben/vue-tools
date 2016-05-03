@section('vue_mixins')
<script>
    vueMixins.tableSorting = function(defaultField, defaultDir) {
        if(typeof(defaultDir) == 'undefined') {
            defaultDir = 1;
        }
        return {
            data: function() {
                return {
                    orderField: defaultField,
                    orderDir: defaultDir,
                    tableFilters: {
                        orderBy: function(rows, vm, args) {
                            return vm
                                .$options
                                .filters
                                .orderBy(rows, args.orderBy.orderField, args.orderBy.orderDir);
                        }
                    },
                    filterArgs: {
                        orderBy: {
                            orderField: defaultField,
                            orderDir: defaultDir
                        }  
                    }
                }
            },
            watch: {
                orderField: function(val, oldVal) {
                    this.filterArgs.orderBy.orderField = this.orderField;
                },
                orderDir: function(val, oldVal) {
                    this.filterArgs.orderBy.orderDir = this.orderDir;
                }
            },
            methods: {
                sort: function(field) {
                    if(this.orderField == field) {
                        this.orderDir *= -1;
                    } else {
                        this.orderDir = 1;
                        this.orderField = field;    
                    }
                }
            }
        };
    };
</script>
@append