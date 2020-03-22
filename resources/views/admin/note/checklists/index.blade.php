@extends('layouts.admin')

@section('title')
Admin | Dashboard
@endsection

@section('custom-css')
<style type="text/css">
    [draggable] {
  -moz-user-select: none;
  -khtml-user-select: none;
  -webkit-user-select: none;
  user-select: none;
  /* Required to make elements draggable in old WebKit */
  -khtml-user-drag: element;
  -webkit-user-drag: element;
}

#columns {
  list-style-type: none;
}

.column {
  width: 162px;
  padding-bottom: 5px;
  padding-top: 5px;
  text-align: center;
  cursor: move;
}
.column header {
  height: 20px;
  width: 150px;
  color: black;
  background-color: #ccc;
  padding: 5px;
  border-bottom: 1px solid #ddd;
  border-radius: 10px;
  border: 2px solid #666666;
}

.column.dragElem {
  opacity: 0.4;
}
.column.over {
  //border: 2px dashed #000;
  border-top: 2px solid blue;
}


.task-done{
    text-decoration: line-through;
}
.btn-circle {
    border-radius: 100%;
    width: 30px;
    height: 30px;
    padding: 5px;
}
.list-group-item {
    padding: 10px 15px;
}
</style>
@endsection

@section('page-name')
Dashboard
@endsection

@section('content')

<div class="row">
    @foreach($lists as $list)
    <div class="col-md-4">
        <div class="card">
            <div class="card-title" style="margin:0">
                <div class="d-flex no-block align-items-center" style="background: #313131">
                    <div>
                        <h5 class="card-title mb-0 text-center text-light ml-2">{{$list->name}}</h5>
                    </div>
                    <div class="ml-auto">
                        <button class="pull-right btn btn-circle btn-light" data-toggle="modal" onclick="listAdd(this, '{{ $list->id }}')" ><i class="ti-plus"></i></button>
                    </div>
                </div>
            </div>
            <div class="card-body" style="padding: 0; height: 450px; overflow-y: scroll;">

                <!-- ============================================================== -->
                <!-- To do list widgets -->
                <!-- ============================================================== -->

                @php($jobs = $list->jobs)
                @php($counter = 0)
                <ul class="list-task todo-list list-group m-b-0" data-role="tasklist" name="list">
                    @foreach($jobs as $job)
                    <li draggable="true" class="list-group-item" data-role="task">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="list{{$job->id.$counter}}" {{ $job->is_done? "checked":"" }} data-id="{{$job->id}}" >
                            <label class="custom-control-label " for="list{{$job->id.$counter}}"></label>
                            <span onclick="listFunction(this)" class="w-100 safe {{ $job->is_done? 'task-done':'' }}" data-id="{{ $job->id }}" data-list_id="{{ $list->id }}">{{ $job->job }}</span>
                        </div>
                        <div class="item-date">{{ $job->created_at }}</div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div> 
    @endforeach
</div>
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
    @foreach($lists as $list)
    <div class="col-md-2 card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex no-block align-items-center">
                        <div><p class="text-muted">{{$list->name}} </p>
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
                    <form action="{{ route('checklists.store') }}" method="POST" >
                        {{ csrf_field() }}
                        <div class="form-group row">
                        <input type="text" name="name" value="" class=form-control" placeholder="Checklist name">
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
        $('.assignedto').on( 'click', 'i.fa-trash', function () { 
            updateThis = this;
            var checklist_id  = $(this).parent().data('checklist_id');

            var user_id = $(this).parent().data('user-id');

            var action = "{{ route('removeUser.checklist') }}" ;

            var content= `
            <form action="`+action+`" method="POST" id="removeUser">
                        {{ csrf_field() }}
                        <div class="form-group row">
                        <input type="hidden" name="checklist_id" value="`+checklist_id+`">
                        <input type="hidden" name="user_id" value="`+user_id+`">
                        </div>
                    </form>`
                    $('#assignContent').html(content);

                    $('#removeUser').submit();       
                });

        $('input[type="checkbox"]').on( 'click', function () { 
            var job_id  = $(this).data('id');            
            var status = $(this).prop('checked')?1:0;
            var updateThis = this;

            var action = "{{ route('listjobs.index') }}/"+job_id;

            $.ajax({
                type: "GET",
                url: action,
                data: "job_id="+job_id+"&status="+status,
                cache:false,
                contentType: false,
                processData: false,
                success: function(response) {
                    var job = response.job;
                    if(job.is_done == 1) {
                        $(updateThis).prop('checked', true); 
                        $(updateThis).parent().find('span').addClass('task-done');
                    } else{
                        $(updateThis).prop('checked', false); 
                        $(updateThis).parent().find('span').removeClass('task-done');
                    }
                },
                error: function(response) {
                    if(status == 0) {
                        $(updateThis).prop('checked', true); 
                        $(updateThis).parent().find('span').addClass('task-done');
                    } else{
                        $(updateThis).prop('checked', false); 
                        $(updateThis).parent().find('span').removeClass('task-done');
                    }
                    swal({
                        title: "<small class='text-danger'>Error!</small>", 
                        type: "error",
                        text: "Something wrong!",
                        timer: 5000,
                        html: true,
                    });
                }
            });  
        }); 


    });
    function newProject() {
        $('#newProjectModal').modal();
    }
    function listAdd(th, list_id) {
        var length = $(th).parent().parent().parent().parent().find('ul[name="list"] li').length;
        $(th).parent().parent().parent().parent().find('ul[name="list"]').prepend(`
                    <li draggable="true" class="list-group-item" data-role="task">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="list`+list_id+length+`" data-id="0" >
                            <label class="custom-control-label " for="list`+list_id+length+`"></label>
                            <span onclick="listFunction(this)" class="w-100 safe" data-id="0" data-list_id="`+list_id+`">click here</span>
                        </div>
                        <div class="item-date">new</div>
                    </li>`);
    }

    function listFunction(th) {
        if($(th).hasClass('safe')) {
            var content = `<textarea name="job" class="form-control w-100" row="5">`+$(th).html()+`</textarea><a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Update" class="pull-right" onclick="updateList(this)"> <i class="fa fa-check text-success m-r-10"></i> </a>`;
            $(th).html(content);
            $(th).addClass('edit');
            $(th).removeClass('safe');
        }
        
    }
    function updateList(th) {
        var job_id  = $(th).parent().data('id');      
        var checklist_id  = $(th).parent().data('list_id');      
        var job = $(th).parent().find('textarea[name="job"]').val();
        var updateThis = th;
        console.log($(th).parent().data('list_id'));

        var action = "{{ route('listjobs.index') }}/"+job_id;

        $.ajax({
            type: "GET",
            url: action,
            data: "job_id="+job_id+"&job="+job+"&checklist_id="+checklist_id,
            cache:false,
            contentType: false,
            processData: false,
            success: function(response) {
                var job = response.job;
                $(updateThis).parent().addClass('safe');
                $(updateThis).parent().removeClass('edit');
                $(updateThis).parent().html(job.job);
            },
            error: function(response) {
                swal({
                    title: "<small class='text-danger'>Error!</small>", 
                    type: "error",
                    text: "Something wrong!",
                    timer: 5000,
                    html: true,
                });
            }
        });
        
    }
function userAssign(th) {
    id = $(th).data('id');

    var action = "{{ route('assignUser.checklist') }}" ;

    var content= `
    <form action="`+action+`" method="POST" >
        {{ csrf_field() }}
        <div class="form-group row">
        <input type="hidden" name="checklist_id" value="`+id+`">
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
}

</script>

@endsection