<?php
$url = new URL ();
$id = $url->getRequestedItem ();
$qb = new QuestionBank ();
?>
<div class="container">
	<div class="row">
		<form action="<?=Comman::getController('question')?>" method="post"
			ng-submit="add($event)">
			<div class="col-md-6" style="margin-top: 20px;">
				<div class="panel">
					<div class="panel-heading">
						<div class="panel-title">Add question to <?=$qb->getInfo($id, 'name')?></div>
					</div>
					<div class="panel-body">
	
						<div class="control-group">
							<label for="ques">Question</label> <input ng-model="name"
								class="form-control" type="text" required="required" name="ques"
								id="ques" placeholder="Question" />
						</div>
						<div class="control-group">
							<label for="course">Type</label> <select ng-model="type"
								class="form-control" required="required" name="type" id="type">
								<option value="mcq" selected="selected">MCQ</option>
								<option value="code">Code</option>
							</select>
						</div>
						<div class="control-group">
							<button type="submit" class="btn btn-primary"
								style="margin-top: 20px;">Create</button>
						</div>
					</div>
				</div>
			</div>
			<div class="panel col-md-6" style="margin-top: 20px;">
				<div class="panel-heading">
					<div class="panel-title">Options</div>
				</div>
				<div class="panel-body">
					<div ng-show="type=='code'">Not Required</div>
					<div ng-show="type=='mcq'">
						<table class="table table-responsive table-striped">
							<tr ng-repeat="option in options">
								<td><input type="radio" class="form-control" name="ans" value="{{$index}}" ng-model="option.isAns"></td>
								<td>
									<div class="input-group">
										<input type="text" placeholder="Option {{$index+1}}" class="form-control" name="option" value="" ng-model="option.option">
										<span class="input-group-btn">
											<button class="btn btn-danger" type="button" ng-click="removeOption($index)"><span class="fa fa-times"></span></button>
										</span>
									</div>
								</td>
							</tr>
						</table>
						<button class="btn btn-info" type="button" ng-click="addOption()"><span class="fa fa-plus"></span>&nbsp;&nbsp; Add option</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<div class = "q-<?=$id?>-data hidden">
    <?php
    $obj = new QuestionBank();
    echo json_encode($obj->getQList(array('question','type','id'), $id));
    ?>
</div>