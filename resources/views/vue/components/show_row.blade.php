@section('vue_components')
<script>
vueComponents.showRow = Vue.component('show-row', {
        props: {
            row: Object
        }
    });
</script>
@append