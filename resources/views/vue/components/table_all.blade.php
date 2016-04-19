<template id="vue-table-all">
    <div class="row">
        <div class="col-md-2" v-if="sizer == true">
            <table-page-sizer></table-page-sizer>
        </div>
        <div class="col-md-2" v-if="searcher == true">
            <table-searcher></table-searcher>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-bordered">
                <thead class="no-border">
                    <tr is="tableHeader"></tr>
                </thead>
                <tbody class="no-border">
                    <tr :is="currentView" 
                        :row.sync="row" 
                        :mode="mode"
                        v-for="row in rows 
                            | tableFilter filterArgs"
                    ></tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row" v-if="pager == true">
        <div class="col-md-12">
            <table-pager class="pull-right"></table-pager>
        </div>
    </div>
</template>

@section('vue_components')
<script>
    vueForms.vueTable = Vue.extend({
        props: {
            rows: Array,
            mode: String
        },
        computed: {
            currentView: function() {
                return this.mode + 'Row';
            }
        },
        data: function() {
            var data = {};
            data.sizer = false;
            data.pager = false;
            data.searcher = false;
            data.tableFilters = {};
            data.tableFilters.removeDeleted = function(rows, vm, args) {
                return rows.filter(function(row) {
                    return (row.vue_deleted == 0 || row.vue_deleted == "false");
                });
            };
            data.lengthFilters = {};
            data.lengthFilters.removeDeleted = data.tableFilters.removeDeleted;
            data.filterArgs = {};
            data.filterArgs.removeDeleted = {};
            return data;
        },
        methods: {
            tableFilter: function(rows, filterArgs) {
                var vm = this;
                var filteredRows = rows;
                var keys = Object.keys(vm.tableFilters);
                for(var i = 0;i < keys.length; i++) {
                    filteredRows = vm.tableFilters[keys[i]](filteredRows, vm, filterArgs);
                }

                return filteredRows;
            },
            lengthFilter: function(rows, filterArgs) {
                var vm = this;
                var filteredRows = rows;
                var keys = Object.keys(vm.lengthFilters);
                for(var i = 0;i < keys.length; i++) {
                    filteredRows = vm.lengthFilters[keys[i]](filteredRows, vm, filterArgs);
                }

                return filteredRows.length;
            }
        },
        filters: {
            tableFilter: function(rows, filterArgs) {
                return this.tableFilter(rows, filterArgs);
            },
            lengthFilter: function(rows, filterArgs) {
                return this.lengthFilter(rows, filterArgs);
            }
        }
    });

    Vue.component('vue-table', vueForms.vueTable);
</script>
@endsection

