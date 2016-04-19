<template id="vue-table-pager">
    <div class="btn-group">
        <button type="button"
            class="btn btn-default"
            @click="prevPage"
        >Prev</button>
        <button type="button"
            :class="{'btn': true, 'btn-default': (comCurrentPage != page), 'btn-primary': (comCurrentPage == page)}"
            @click="setPage(page)"
            v-for="page in pages"
        >
            @{{ (page + 1) }}
        </button>
        <button type="button"
            class="btn btn-default"
            @click="nextPage"
        >Next</button>
    </div>
</template>

@section('vue_components')
<script>
    vueComponents.tablePager = Vue.extend({
        template: '#vue-table-pager',
        props: {
            currentPage: Number,
            pageSize: Number,
            length: Number,
        },
        computed: {
            pages: function() {
                var numPages = Math.ceil(this.comLength / this.comPageSize);
                return Array.apply(null, Array(numPages)).map(function (_, i) {return i;});
            },
            comCurrentPage: {
                get: function() {
                    if(typeof(this.currentPage) == 'undefined') {
                        return this.$parent.page;
                    } else {
                        return this.currentPage;
                    }
                },
                set: function(val) {
                    if(typeof(this.currentPage) == 'undefined') {
                        this.$parent.page = val;
                    } else {
                        this.currentPage = val;
                    }
                }
            },
            comLength: function() {
                if(typeof(this.length) == 'undefined') {
                    return this.$parent.lengthFilter(this.$parent.rows, this.$parent.filterArgs);
                } else {
                    return this.length;
                }
            },
            comPageSize: function() {
                if(typeof(this.pageSize) == 'undefined') {
                    return this.$parent.pageSize;
                } else {
                    return this.pageSize;
                }
            },
        },
        methods: {
            nextPage: function() {
                if((this.pages.length - 1) != this.comCurrentPage) {
                    this.comCurrentPage += 1;
                }
            },
            prevPage: function() {
                if(this.comCurrentPage != 0) {
                    this.comCurrentPage -= 1;   
                }
            },
            setPage: function(pageNum) {
                this.comCurrentPage = pageNum;
            },    
        },
        watch: {
            pages: function(val, oldVal) {
                if((this.pages.length) < this.comCurrentPage) {
                    if(this.pages.length > 0) {
                        this.comCurrentPage = this.pages.length - 1;    
                    } else {
                        this.comCurrentPage = 0;
                    }
                    
                }
            }
        }
    });

    Vue.component('table-pager', vueComponents.tablePager);
</script>
@endsection