<div class="container" ng-element-ready = "createTable()">
	<div class="row">
		<a href="manage-exams" ng-hide="create" ng-click="create = true" class="btn btn-primary btn-lg fx-fade-up fx-dur-0">Create Exam</a>
		<a href="manage-exams" ng-show="create" ng-click="create = false" class="btn btn-primary btn-lg fx-fade-up fx-dur-0">Back</a>
	</div>
	<div class="row">
		<div ng-hide="create">
			<table class="table table-bordered table-bordered" id="exam_table">
				<thead>
					<tr>
						<th>#</th><th>Name</th><th>Status</th><th></th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="exam in exams">
		                <td>{{$index+1}}</td>
		                <td>{{exam.name}}</td>
		                <td>{{exam.start_time}}</td>
		                <td>
		                	<a href="#" class="btn btn-primary" data-toggle="tooltip" title="Add questions"><span class="fa fa-plus"></span></a>
		                	<a href="#" class="btn btn-info" data-toggle="tooltip" title="Edit exam info"><span class="fa fa-edit"></span></a>
		                	<a href="manage-exams" class="btn btn-danger delete" data-toggle="tooltip" title="Delete Exam" ng-click="deleteExam($event, exam.id)"><span class="fa fa-times"></span></a>
		                </td>
	            	</tr>
				</tbody>
			</table>
		</div>
		<div ng-show="create">
			<form action="<?=Comman::getController('exam')?>" method="post" ng-submit="createExam($event)">
				<div class="panel col-md-6" style="margin-top: 20px;">
					<div class="panel-heading">
						<div class="panel-title">Create Exam</div>
					</div>
					<div class="panel-body">
						
							<div class="control-group">
								<label for="name">Name of exam</label>
								<input ng-model="exam_name" class="form-control" type="text" required="required" name="name"  id="name" placeholder="Name of exam" />
							</div>
							<div class="control-group" style="margin-top: 20px;">
								<label for="exam_type">Auto Start</label>
								<input type="checkbox" ng-model="exam_type" class="form-control" id="exam_type" style="display: inline; margin-left: 20px;" />
								<span class="help_block" style="display: block;">If this checkbox will leave checked then exam will be start automatically according to the time selected below.</span>
							</div>
							<div ng-show="exam_type">
								<div class="control-group">
									<label for="start_time">Start Time</label>
									<input ng-model="start_time" class="form-control" type="datetime" name="start_time" id="start_time" placeholder="Start Time" />
								</div>
								<div class="control-group">
									<label for="end_time">End Time</label>
									<input ng-model="end_time" class="form-control" type="datetime" name="end_time" id="end_time" placeholder="End Time" />
								</div>
							</div>
							
							<div class="control-group">
								<label for="duration">Duration (in hours)</label>
								<input ng-model="exam_duration" class="form-control" type="number" required="required" name="duration" id="duration" placeholder="Duration" />
							</div>
							<div class="control-group">
								<button type="submit" class="btn btn-primary" style="margin-top: 20px;">Create</button>
							</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel" style="margin-top: 20px;">
						<div class="panel-heading">
							<div class="panel-title">Other Exam Info</div>
						</div>
						<div class="panel-body">
							<div class="control-group">
								<label for="student_group">Student Group</label>
								<select multiple="multiple" ng-model="exam_student_group" class="form-control" name="student_group" id="student_group">
									<option selected="selected" value="--no--">--No Group--</option>
									<option value="all">All</option>
								</select>
								<span class="help_block">If this option will set to "--No Group--" then exam will be {logically} disabled, and for the case of 'All', exam will be available for all students.</span>
							</div>
							<div class="control-group">
								<label for="show_result">Show Result</label>
								<select ng-model="show_result" class="form-control" name="show_result" id="show_result">
									<option selected="selected" value="yes">Yes</option>
									<option value="no">No</option>
								</select>
								<span class="help_block">if this value will set to 'Yes', student will get their results just after they'll submit their exam.</span>
							</div>
							<div class="control-group">
								<label for="about">About</label>
								<textarea ng-model="exam_about" class="form-control"  name="about" placeholder="About" id="about"></textarea>
							</div>
							<div class="control-group">
								<button type="submit" class="btn btn-primary" style="margin-top: 20px;">Create</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class = "exam-data hidden">
    <?php
    $obj = new Exam();
    echo json_encode($obj->getExams(array('id','name','start_time')));
    ?>
</div>
<script>
    $(document).ready(function(){
        jQuery("[type='datetime']").datetimepicker();
        $("[data-toggle='tooltip'").tooltip();
    });
    //$("#table").bdt();
</script>