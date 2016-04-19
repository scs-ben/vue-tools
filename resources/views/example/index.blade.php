@extends('layouts.app')

@section('style')
@endsection

@section('content_header')
<div class="content-header">
    <h1>
        Dashboard
    </h1>
    <ol class="breadcrumb">
        <li class="active"><i class="fa fa-dashboard"></i> Home</a></li>
    </ol>
</div>
@endsection

@section('content')
<div class="hide-vue" style="display: none;">
    <div id="vue-app">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center col-md-2">Created At</th>
                            <th class="text-center col-md-3">Project Name</th>
                            <th class="text-left col-md-3">Name</th>
                            <th class="text-left col-md-2">Field 1</th>
                            <th class="text-left col-md-2">Field 2</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="example in examples">
                            <td class="text-center">
                                @{{ example.created_at | date }}
                            </td>
                            <td class="text-center">
                                @{{ example.project.name }}
                            </td>
                            <td class="text-left">
                                @{{ example.name }}
                            </td>
                            <td class="text-left">
                                @{{ example.field1 }}
                            </td>
                            <td class="text-left">
                                @{{ example.field2 }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
                
@endsection

@section('script')
<script>
    new Vue({
        el: '#vue-app',
        data: function() {
            return {
                examples: {
                    model: "App\\Model\\Example",
                    type: "array",
                    data: {!! $examples->toJson() !!}
                },
                blanks: {
                    example: {!! $blankExample->toJson() !!}
                }
            };
        },
        ready: function () {
            $('.hide-vue').show();
        }
    });
</script>
@endsection

