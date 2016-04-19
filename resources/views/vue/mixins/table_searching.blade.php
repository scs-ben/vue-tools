@section('vue_mixins')
<script>
    vueMixins.tableSearching = function(searchText) {
        if(typeof(searchText) == 'undefined') {
            searchText = '';
        }
        return {
            data: function() {
                var data = {
                    searchText: searchText,
                    tableFilters: {
                        filterBy: function(rows, vm, args) {
                            return vm
                                .$options
                                .filters
                                .filterBy(rows, args.filterBy.searchText);
                        }
                    },
                    lengthFilters: {
                    },
                    filterArgs: {
                        filterBy: {
                            searchText: searchText
                        }
                    }
                }
                data.lengthFilters.filterBy = data.tableFilters.filterBy;
                return data;
            },
            watch: {
                searchText: function(val, oldVal) {
                    this.filterArgs.filterBy.searchText = this.searchText;
                }
            }
        }
    };
</script>
@endsection