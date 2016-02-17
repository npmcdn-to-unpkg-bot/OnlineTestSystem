<div class="container" ng-element-ready = "createTable()">
	<div class="row">
		<a href="manage-courses" ng-hide="create" ng-click="create = true" class="btn btn-primary btn-lg fx-fade-up fx-dur-0">Create Course</a>
		<a href="manage-courses" ng-show="create" ng-click="create = false" class="btn btn-primary btn-lg fx-fade-up fx-dur-0">Back</a>
	</div>
	<div class="row">
		<div ng-hide="create">
			<table class="table table-bordered table-bordered" id="course_table">
				<thead>
					<tr>
						<th>#</th><th>Name</th><th></th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="course in courses">
		                <td>{{$index+1}}</td>
		                <td>{{course.course_name}}</td>
		                <td>
		                	<a href="#" class="btn btn-primary" data-toggle="tooltip" title="Add questions"><span class="fa fa-plus"></span></a>
		                	<a href="#" class="btn btn-info" data-toggle="tooltip" title="Edit exam info"><span class="fa fa-edit"></span></a>
		                	<a href="manage-courses" class="btn btn-danger delete" data-toggle="tooltip" title="Delete Course" ng-click="delete($event, course.id)"><span class="fa fa-times"></span></a>
		                </td>
	            	</tr>
				</tbody>
			</table>
		</div>
		<div ng-show="create">
			<form action="<?=Comman::getController('courses')?>" method="post" ng-submit="add($event)">
				<div class="panel col-md-6" style="margin-top: 20px;">
					<div class="panel-heading">
						<div class="panel-title">Create Course</div>
					</div>
					<div class="panel-body">
						
							<div class="control-group">
								<label for="name">Name of course</label>
								<input ng-model="name" class="form-control" type="text" required="required" name="name"  id="name" placeholder="Name of Course" />
							</div>
							<div class="control-group">
								<button type="submit" class="btn btn-primary" style="margin-top: 20px;">Create</button>
							</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class = "course-data hidden">
    <?php
    $obj = new Course();
    echo json_encode($obj->getList(array('id','course_name')));
    ?>
</div>
<script>
    $(document).ready(function(){
        $("[data-toggle='tooltip'").tooltip();
    });
</script>