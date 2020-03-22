@extends('adminelite::layouts.master')

@section('title')
Admin | Dashboard
@endsection

@section('custom-css')
@endsection

@section('page-name')
Dashboard
@endsection

@section('content')


<div class="row" >
    <div class="col-md-2 card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex no-block align-items-center">
                        <div>
                            <a href="javascript:void(0)" onclick="newProject()"><p class="text-muted">Add New </p></a>
                        </div>
                        <div class="ml-auto">
                            <h2 class="counter text-primary"></h2>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="progress">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @foreach($projects as $project)
    <div class="col-md-2 card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex no-block align-items-center">
                        <div>
                            <a href="{{ route('noteProjects.show',$project) }}"><p class="text-muted">{{$project->title}} </p></a>
                        </div>
                        <div class="ml-auto">
                            <h2 class="counter text-primary"></h2>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="progress">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>  



<!-- sample modal content for show checkout with detail-->
<div id="newProjectModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">New Project</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="container" id="editContent">
                    <form action="{{ route('noteProjects.store') }}" method="POST" >
                        {{ csrf_field() }}
                        <div class="form-group row">
                        <input type="text" name="title" value="" class="form-control" placeholder="Project title">
                        </div>

                            <div class="col-sm-6"><button type="submit" class="btn btn-info waves-effect" >Add New</button> 
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal-dialog -->
</div>

@endsection

@section('custom-js')
<script>
    function newProject() {
        $('#newProjectModal').modal();
    }
</script>

@endsection