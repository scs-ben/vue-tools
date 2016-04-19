@section('vue_mixins')
<script>
    vueMixins.tablePaging = function(pageSize, page) {
        if(typeof(pageSize) == 'undefined') {
            pageSize = 10;
        }
        if(typeof(page) == 'undefined') {
            page = 0;
        }
        return {
            data: function() {
                return {
                    page: page,
                    pageSize: pageSize,
                    tableFilters: {
                        limitBy: function(rows, vm, args) {
                            return vm
                                .$options
                                .filters
                                .limitBy(rows, args.limitBy.pageSize, args.limitBy.offset);
                        }
                    },
                    filterArgs: {
                        limitBy: {
                            pageSize: pageSize,
                            offset: pageSize * page
                        }  
                    }
                }
            },
            computed: {
                offset: function() {
                    return this.pageSize * this.page;
                }
            },
            watch: {
                pageSize: function(val, oldVal) {
                    this.filterArgs.limitBy.pageSize = this.pageSize;
                },
                offset: function(val, oldVal) {
                    this.filterArgs.limitBy.offset = this.offset;
                }
            }
        };
    };
</script>
@endsection