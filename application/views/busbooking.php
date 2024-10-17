<?php
include 'includes/header.php';
include 'includes/sidebar.php';
?>
<div class="content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox ibox-primary">
                    <div class="ibox-head">
                        <div class="ibox-title">Bus Booking</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form action="" method="post">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-control-label">From <b style="color: red;">*</b></label>
                                    <select class="form-control select2_demo_1" name='from_place' required>
                                        <option value="source">--Enter Source--</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-control-label">To <b style="color: red;">*</b></label>
                                    <select class="form-control select2_demo_1" name='to_place' required>
                                        <option value="dest">--Enter Destination--</option>
                                    </select>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label class="form-control-label">Journey Date<b style="color: red;">*</b></label>
                                    <div class="input-group date" data-provide="datepicker">
                                        <input type="date" class="form-control" name="journey_date">
                                        <!-- <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div> -->
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">

                                </div>
                                <div class="col-md-12 form-group">
                                    <input type="submit" value="Search Buses" class="btn btn-danger" name="searchboxbtn">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <hr>
                <div class="ibox ibox-warning">
                    <div class="ibox-head">
                        <div class="ibox-title">Show Bus</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-1-1" aria-expanded="true">
                                <table class="table table-striped table-bordered table-hover" id="bus_booking-1" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Bus & Operator Type</th>
                                            <th>Departure</th>
                                            <th>Arrival</th>
                                            <th>Ratings</th>
                                            <th>Seats</th>
                                            <th>Commission</th>
                                            <th>Starting Fare</th>
                                            <th>104 Results</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><img src="bus_booking_images/sbstc.png" width="50px" height="50px" alt=""><strong> SBSTC BUSES</strong></td>
                                            <td style="color:red;"><strong>01:30 AM</strong></td>
                                            <td style="color:green;"><strong>05:30 AM</strong></td>
                                            <td></td>
                                            <td>40 Seats <br> Available</td>
                                            <td>6%</td>
                                            <td>Starts at Rs. 157.5</td>
                                            <td><a href="#" class="btn btn-success" data-toggle="modal" data-target="#largeModal">Book Seats</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--------------------- Book Seats modal --------------------->
    <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Large Modal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3>Modal Body</h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>




    <!-- END PAGE CONTENT-->

    <?php include 'includes/footer.php'; ?>