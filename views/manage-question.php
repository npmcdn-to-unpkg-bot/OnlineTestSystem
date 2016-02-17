<?php 
$obj = new QuestionBank();
$course = new Course();
$course_list = $course->getList(array('id','course_name'));
?>
<div class="container" ng-element-ready = "createTable()">
	<div class="row">
		<a href="manage-question" ng-hide="create" ng-click="create = true" class="btn btn-primary btn-lg fx-fade-up fx-dur-0">Create Question Bank</a>
		<a href="manage-question" ng-show="create" ng-click="create = false" class="btn btn-primary btn-lg fx-fade-up fx-dur-0">Back</a>
	</div>
	<div class="row">
		<div ng-hide="create">
			<table class="table table-bordered table-bordered" id="qb_table">
				<thead>
					<tr>
						<th>#</th><th>Name</th><th>Course</th><th></th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="qb in qbs">
		                <td>{{$index+1}}</td>
		                <td>{{qb.name}}</td>
		                <td>{{qb.course_name}}</td>
		                <td>
		                	<a href="add-question/{{qb.id}}" class="btn btn-primary" data-toggle="tooltip" title="Add questions"><span class="fa fa-plus"></span></a>
		                	<a href="#" class="btn btn-info" data-toggle="tooltip" title="Edit exam info"><span class="fa fa-edit"></span></a>
		                	<a href="manage-question" class="btn btn-danger delete" data-toggle="tooltip" title="Delete Question Bank" ng-click="delete($event, qb.id)"><span class="fa fa-times"></span></a>
		                </td>
	            	</tr>
				</tbody>
			</table>
		</div>
		<div ng-show="create">
			<form action="<?=Comman::getController('question_bank')?>" method="post" ng-submit="add($event)">
				<div class="panel col-md-6" style="margin-top: 20px;">
					<div class="panel-heading">
						<div class="panel-title">Create Question Bank</div>
					</div>
					<div class="panel-body">
						
							<div class="control-group">
								<label for="name">Name of exam</label>
								<input ng-model="name" class="form-control" type="text" required="required" name="name"  id="name" placeholder="Name of exam" />
							</div>
							<div class="control-group">
								<label for="course">Course</label>
								<select ng-model="course" class="form-control"  required="required" name="course"  id="course">
								<?php foreach ($course_list as $item){?>
									<option value="<?=$item['id']?>"><?=$item['course_name']?></option>
								<?php }?>
								</select>
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
<div class = "qb-data hidden">
    <?php
    $list = $obj->getList(array('id','name','course'));
    $result = array();
    $i = 0;
    foreach ($list as $item){
		$result[$i]['id'] = $item['id'];
		$result[$i]['name'] = $item['name'];
		$result[$i]['course'] = $item['course'];
		$result[$i++]['course_name'] = $course->getInfo($item['course'], 'course_name');
	}
	echo json_encode($result);
    ?>
</div>
<script>
    $(document).ready(function(){
        $("[data-toggle='tooltip'").tooltip();
    });
    //$("#table").bdt();
</script>