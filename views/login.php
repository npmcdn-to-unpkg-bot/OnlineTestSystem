<div class="container">
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4 col-md-offset-4 col-md-4 col-sm-offset-3 col-sm-6">
            <div class="notice"></div>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">Login</div>
                </div>
                <div class="panel-body">
                    <form action="" ng-submit="validate($event)" method="post">
                        <label for="username"></label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="fa fa-user"></span>
                            </span>
                            <input type="text" ng-model="username" required id="username" class="form-control" placeholder="Username" />
                        </div>
                        <label for="password"></label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="fa fa-key"></span>
                            </span>
                            <input type="password" ng-model="password" required id="password" class="form-control" placeholder="Password" />
                        </div>
                        <button type="submit" class="btn btn-primary login-btn">Login <span class="fa fa-arrow-right"></span></button>
                        <button type="reset" class="btn btn-info">Reset</button>
                    </form>
                </div>
                <div class="panel-footer">
                    <span class="help-block">Login with your college username and password</span>
                </div>
            </div>
        </div>
    </div>
</div>