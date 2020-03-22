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


<div class="" style=" white-space: nowrap;overflow-x: auto;height: 80vh" id="project">
    @foreach( $project->steps as $step)
    <div class="card" style="width: 300px;display: inline-block;  padding: 0 10px;">
        <div class="card-title bg-dark text-light" style="padding: 10px;">
            {{ $step->title }}
        </div>
        <div class="card-body" style="margin-top: 5px; padding: 0">
            @foreach($step->operations as $operation )
            <div class="card" style="width: 100%; border:1px solid #cacaca;padding: 0 10px;">
                <div class="">
                    <p class="text-muted" style="margin: 0">{{ $operation->title }} <a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Assign" data-id="{{ $operation->id }}" class="pull-right"> <i class="fa fa-user text-success m-r-10"></i> </a> 
                        <a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Move" data-id="{{ $operation->id }}" class="pull-right"> <i class="fa fa-mail-forward text-info m-r-10"></i> </a></p>
                </div>
                @php($assignedUsers = $operation->users())
                <div class="row p-10">
                    @foreach($assignedUsers as $user)
                    <img src="{{ asset('/').$user->avatar }}" style="height: 25px; width: 25px; border-radius: 50%;margin-left: 5px;" data-toggle="tooltip" data-original-title="{{ $user->name }}">
                        <a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Remove" data-user-id="{{ $user->id }}" data-operation-id="{{ $operation->id }}" class="pull-right"> <i class="fa fa-trash text-danger m-r-10"></i> </a></p>
                    @endforeach
                </div>
            </div>
            @endforeach

            <div class="card" style="width: 100%; border:1px solid #cacaca">
                <div class="d-flex no-block align-items-center">
                    <a href="javascript:void(0)" onclick="moreOperation('{{$step->id}}')"><p class="text-muted">Add More </p></a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <div class="card" style="width: 300px;display: inline-block;padding: 0 10px;">
        <div class="card-title">
            <a href="javascript:void(0)" onclick="moreStep('{{$project->id}}')"><p class="text-muted">Add More </p></a>
        </div>
    </div>
</div>  



<!-- sample modal content for show checkout with detail-->
<div id="moreOperationModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">New Rows</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="container" id="editContent">
                    <form action="{{ route('noteOperations.store') }}" method="POST" >
                        {{ csrf_field() }}
                        <div class="form-group row">
                        <input type="hidden" name="step_id">
                        <input type="text" name="title" value="" class="form-control" placeholder="Project Row title">
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

<!-- sample modal content for show checkout with detail-->
<div id="moreStepModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">New Step</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="container" id="editContent">
                    <form action="{{ route('noteSteps.store') }}" method="POST" >
                        {{ csrf_field() }}
                        <div class="form-group row">
                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                        <input type="text" name="title" value="" class="form-control" placeholder="Project Column title">
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

<!-- sample modal content for show checkout with detail-->
<div id="operationMoveModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Move to</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="container" id="operationContent">
                    
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal-dialog -->
</div><!-- sample modal content for show checkout with detail-->
<div id="userAssignModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Assign to</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="container" id="assignContent">
                    
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal-dialog -->
</div>

@endsection

@section('custom-js')
<script>
    $(document).ready(function() {
        $('#project').on( 'click', 'i.fa-mail-forward', function () { 
            updateThis = this;
            id = $(this).parent().data('id');

        var action = "{{ route('noteOperations.index') }}" + "/" + id ;

            var content= `
            <form action="`+action+`" method="POST" >
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <div class="form-group row">
                        <input type="hidden" name="operation_id" value="`+id+`">
                        <select class="form-control" name="step_id">
                            @foreach($project->steps as $step)
                                <option value="{{ $step->id }}" >{{ $step->title }}</option>
                            @endforeach
                        </select>
                        </div>

                        <div class="col-sm-6"><button type="submit" class="btn btn-info waves-effect" >Move</button> 
                        </div>
                    </form>`
                    $('#operationContent').html(content);

                    $('#operationMoveModal').modal();
        }); 
        $('#project').on( 'click', 'i.fa-user', function () { 
            updateThis = this;
            id = $(this).parent().data('id');

            var action = "{{ route('assignUser.operation') }}" ;

            var content= `
            <form action="`+action+`" method="POST" >
                        {{ csrf_field() }}
                        <div class="form-group row">
                        <input type="hidden" name="operation_id" value="`+id+`">
                        <select class="form-control" name="user_id">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" >{{ $user->name }}</option>
                            @endforeach
                        </select>
                        </div>

                        <div class="col-sm-6"><button type="submit" class="btn btn-info waves-effect" >Assign</button> 
                        </div>
                    </form>`
                    $('#assignContent').html(content);

                    $('#userAssignModal').modal();
        }); 
        $('#project').on( 'click', 'i.fa-trash', function () { 
            updateThis = this;
            var operation_id = $(this).parent().data('operation-id');
            var user_id = $(this).parent().data('user-id');

            var action = "{{ route('removeUser.operation') }}" ;

            var content= `
            <form action="`+action+`" method="POST" id="removeUser">
                        {{ csrf_field() }}
                        <div class="form-group row">
                        <input type="hidden" name="operation_id" value="`+operation_id+`">
                        <input type="hidden" name="user_id" value="`+user_id+`">
                        </div>
                    </form>`
                    $('#assignContent').html(content);

                    $('#removeUser').submit();       
                }); 

    });
    function moreOperation(step_id) {
        $('input[name="step_id"]').val(Number(step_id));
        $('#moreOperationModal').modal();
    }
    function moreStep(project_id) {
        $('#moreStepModal').modal();
    }
</script>
@endsection