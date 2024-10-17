<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox ibox-primary">
                    <div class="ibox-head ">
                        <div class="ibox-title">Add Role</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form action="" method="post" class="row">

                            <div class="form-group w-100 col-md-8 ml-4">
                                <label>Role Name <b style="color: red;">*</b></label>

                                <input class="form-control" type="text" name="role_name" placeholder="Role Name" value="" required>
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="form-control-label">Status </label>
                                <select class="form-control select2_demo_1" name='status'>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <div class="form-group col-md-8 ml-5">
                                <button class="btn btn-primary btn-sm" type="submit" name="submitBtn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>