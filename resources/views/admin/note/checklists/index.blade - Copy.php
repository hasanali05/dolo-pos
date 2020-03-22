@extends('adminelite::layouts.master')

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

</style>
@endsection

@section('page-name')
Dashboard
@endsection

@section('content')

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-title" style="margin:0">
                <div class="d-flex no-block align-items-center" style="background: #13CE66">
                    <div>
                        <h5 class="card-title m-b-0 text-center text-light m-l-25">TO DO LIST</h5>
                    </div>
                    <div class="ml-auto">
                        <button class="pull-right btn btn-circle btn-dark" data-toggle="modal" onclick="listAdd(this)"><i class="ti-plus"></i></button>
                    </div>
                </div>

                    <div class="">
                            <ul class="list-task todo-list list-group m-b-0" data-role="tasklist">
                                <li class="list-group-item" data-role="task">
                                    <ul class="assignedto">
                                        <li><img src="{{asset('/')}}/admin-elite/assets/images/users/1.jpg" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Steave"></li>
                                        <li><img src="{{asset('/')}}/admin-elite/assets/images/users/2.jpg" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Jessica"></li>
                                        <li><img src="{{asset('/')}}/admin-elite/assets/images/users/3.jpg" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Priyanka"></li>
                                        <li><img src="{{asset('/')}}/admin-elite/assets/images/users/4.jpg" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Selina"></li>
                                    </ul>
                                </li>
                            </ul>
                    </div>
            </div>
            <div class="card-body" style="padding: 0 1rem; height: 450px; overflow-y: scroll;">

                <!-- ============================================================== -->
                <!-- To do list widgets -->
                <!-- ============================================================== -->
                <ul id="columns">
  <li class="column" draggable="true"><header>A</header></li>
  <li class="column" draggable="true"><header>B</header></li>
  <li class="column" draggable="true"><header>C</header></li>
  <li class="column" draggable="true"><header>D</header></li>
  <li class="column" draggable="true"><header>E</header></li>
</ul>



                    <ul class="list-task todo-list list-group m-b-0" data-role="tasklist" name="list">
                        <li draggable="true" class="list-group-item" data-role="task">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                <label class="custom-control-label" for="customCheck1">
                                    <span>Lorem Ipsum is simply dummy text of the printing</span>
                                </label>
                            </div>
                            <div class="item-date"> 26 jun 2017</div>
                        </li>
                        <li draggable="true" class="list-group-item" data-role="task">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck2">
                                <label class="custom-control-label" for="customCheck2">
                                    <span>Give Purchase report to</span>
                                </label>
                            </div>
                        </li>
                        <li draggable="true" class="list-group-item" data-role="task">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck3">
                                <label class="custom-control-label" for="customCheck3">
                                    <span>Lorem Ipsum is simply dummy text of the printing </span>
                                </label>
                            </div>
                            <div class="item-date"> 26 jun 2017</div>
                        </li>
                        <li draggable="true" class="list-group-item" data-role="task">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck4">
                                <label class="custom-control-label" for="customCheck4">
                                <span>Give Purchase report to</span>
                                </label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
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
    function listAdd(th) {
        console.log($(th).parent().parent().parent().parent());
        $(th).parent().parent().parent().parent().find('ul[name="list"]').prepend(`
                        <li draggable="true" class="list-group-item" data-role="task">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck2">
                                <label class="custom-control-label" for="customCheck2">
                                    <span>Give Purchase report to</span>
                                </label>
                            </div>
                        </li>`);
    }
    var dragSrcEl = null;

function handleDragStart(e) {
  // Target (this) element is the source node.
  dragSrcEl = this;

  e.dataTransfer.effectAllowed = 'move';
  e.dataTransfer.setData('text/html', this.outerHTML);

  this.classList.add('dragElem');
}
function handleDragOver(e) {
  if (e.preventDefault) {
    e.preventDefault(); // Necessary. Allows us to drop.
  }
  this.classList.add('over');

  e.dataTransfer.dropEffect = 'move';  // See the section on the DataTransfer object.

  return false;
}

function handleDragEnter(e) {
  // this / e.target is the current hover target.
}

function handleDragLeave(e) {
  this.classList.remove('over');  // this / e.target is previous target element.
}

function handleDrop(e) {
  // this/e.target is current target element.

  if (e.stopPropagation) {
    e.stopPropagation(); // Stops some browsers from redirecting.
  }

  // Don't do anything if dropping the same column we're dragging.
  if (dragSrcEl != this) {
    // Set the source column's HTML to the HTML of the column we dropped on.
    //alert(this.outerHTML);
    //dragSrcEl.innerHTML = this.innerHTML;
    //this.innerHTML = e.dataTransfer.getData('text/html');
    this.parentNode.removeChild(dragSrcEl);
    var dropHTML = e.dataTransfer.getData('text/html');
    this.insertAdjacentHTML('beforebegin',dropHTML);
    var dropElem = this.previousSibling;
    addDnDHandlers(dropElem);
    
  }
  this.classList.remove('over');
  return false;
}

function handleDragEnd(e) {
  // this/e.target is the source node.
  this.classList.remove('over');

  /*[].forEach.call(cols, function (col) {
    col.classList.remove('over');
  });*/
}

function addDnDHandlers(elem) {
  elem.addEventListener('dragstart', handleDragStart, false);
  elem.addEventListener('dragenter', handleDragEnter, false)
  elem.addEventListener('dragover', handleDragOver, false);
  elem.addEventListener('dragleave', handleDragLeave, false);
  elem.addEventListener('drop', handleDrop, false);
  elem.addEventListener('dragend', handleDragEnd, false);

}

var cols = document.querySelectorAll('#columns .column');
[].forEach.call(cols, addDnDHandlers);


</script>

@endsection