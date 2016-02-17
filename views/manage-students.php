<div class="container">
    <div class="row">
        <table id="students" class="table table-bordered table-bordered">
            <thead>
            <tr>
                <th><input type="checkbox" ng-change="selectAll()" ng-model="selAll" class="form-control"></th>
                <th>#</th>
                <th>Roll No.</th>
                <th>Name</th>
                <th>Branch</th>
                <th>College</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="student in students">
                <td><input type="checkbox" class="form-control"></td>
                <td>{{$index+1}}</td>
                <td>{{student.id}}</td>
                <td>{{student.name}}</td>
                <td>{{student.branch}}</td>
                <td>{{student.college}}</td>
                <td>Actions</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<div class = "data hidden">
    <?php
    $users = new User();
    echo json_encode($users->getUsers(array('id','name','branch','college')));
    ?>
</div>
<script>
    $(document).ready(function(){
        $("#students").bdt();
    })
</script>