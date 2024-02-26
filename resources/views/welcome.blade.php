<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Navbar</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    .navbar-custom {
      background-color: #007bff;
    }

    .navbar-custom .navbar-brand,
    .navbar-custom .navbar-nav .nav-link {
      color: white;
    }
  </style>
</head>
<body>
  @include('partial.nav')
      <div class="container text-right mt-2">
          <p class="font-weight-bold">Welcome , <a href="#">Logout</a></p>
          <hr class="mt-2">
      </div>
      <div class="col-md-12">
          <div class="content">
            <div class="col-md-12">
                <h3 class="h3" style="color: red;"> Dashboard User</h3>
            </div>
            <div class="container row">
                <div class="col-md-3">
                    <div class="card card-primary">
                        <div class="card-body">
                            <h3>
                                <span id="ContentPlaceHolder1_lblQuotCount"></span>
                                <span class="fa fa-address-card-o"></span></h3>
                            <div class="card-subtitle">Pending L R</div>
                        </div>

                        <div class="card-footer text-center bg-info p-0">
                            <a href="" class="btn btn-info">View</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-primary">
                        <div class="card-body">
                            <h3>
                                <span id="ContentPlaceHolder1_lblPendingFollowUp">-</span>
                                <span class="fa fa-archive text-info"></span></h3>
                            <div class="card-subtitle">No Of Pakegs</div>
                        </div>

                        <div class="card-footer text-center bg-primary p-0">
                            <a href="" class="btn btn-primary">View</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-primary">
                        <div class="card-body">
                            <h3>
                                <span id="ContentPlaceHolder1_lblCancelledCall">-</span>
                                <span class="fa fa-remove text-danger"></span></h3>
                            <div class="card-subtitle">Today's Call Cancelled</div>
                        </div>

                        <div class="card-footer text-center bg-danger p-0">
                            <a href="CancelledCalls.aspx" class="btn btn-danger">View</a>
                        </div>
                    </div>
                </div>
                <div class="auto-style1">
                    <div class="card card-primary">
                        <div class="card-body">
                            <h3>
                                <span id="ContentPlaceHolder1_lblFinalizedCall">-</span>
                                <span class="fa fa-thumbs-up text-success"></span></h3>
                            <div class="card-subtitle">Today's Gate Pass Receipt</div>
                        </div>

                        <div class="card-footer text-center bg-success p-0">
                            <a href="FinalizedCalls.aspx" class="btn btn-success">View</a>
                        </div>
                    </div>
                </div>
            </div>
          </div>
      </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
