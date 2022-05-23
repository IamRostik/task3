<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Users table</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="styles.css" rel="stylesheet">
</head>
<body>

  <div class="container">
    <div class="row flex-lg-nowrap">
      <div class="col">
        <div class="row flex-lg-nowrap">
          <div class="col mb-3">
            <div class="e-panel card">
              <div class="card-body">
                <div class="card-title">
                  <h6 class="mr-2"><span>Users</span></h6>
                </div>
                  <div class="col-sm-4 root-group-change-block">
                    <div class="row">
                          <div class="">
                              <button class="btn add" data-toggle="modal" data-target="#add-edit" data-whatever="Add">Add</button>
                          </div>
                          <div class="col">
                              <select name="status" id="status" class="form-control inline-block">
                                  <option value="3" selected>Please Select</option>
                                  <option value="1">Set active</option>
                                  <option value="0">Set not active</option>
                                  <option value="2">Delete</option>
                              </select>
                          </div>
                          <div class="">
                              <button class="btn ok-button">OK</button>
                          </div>
                      </div>
                  </div>
                <div class="e-table">

                  <div class="table-responsive table-lg mt-3 place-for-alert">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th class="align-top">
                            <div class="custom-control custom-control-inline custom-checkbox custom-control-nameless m-0">
                              <input type="checkbox" class="custom-control-input" id="all-items">
                              <label class="custom-control-label" for="all-items"></label>
                            </div>
                          </th>
                          <th class="max-width">Name</th>
                          <th class="sortable">Role</th>
                          <th>Status</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody class="content-section">


                        <!--      CONTENT      -->


                      </tbody>
                    </table>
                  </div>
                </div>
                  <div class="col-sm-4 root-group-change-block">
                      <div class="row">
                          <div class="">
                              <button class="btn add" data-toggle="modal" data-target="#add-edit" data-whatever="Add">Add</button>
                          </div>
                          <div class="col">
                              <select name="status" id="status" class="form-control inline-block">
                                  <option value="3" selected>Please Select</option>
                                  <option value="1">Set active</option>
                                  <option value="0">Set not active</option>
                                  <option value="2">Delete</option>
                              </select>
                          </div>
                          <div class="">
                              <button class="btn ok-button">OK</button>
                          </div>
                      </div>
                  </div>
              </div>

            </div>
          </div>
        </div>
        <!-- User Form Modal -->
          <div class="modal fade" id="add-edit" tabindex="-1" role="dialog" aria-labelledby="add-editLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="add-editLabel">New user</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                          <div class="alert alert-danger d-none" role="alert"></div>
                          <form class="form">
                              <div class="row">
                                  <div class="col">
                                      <div class="form-group">
                                          <label for="name_first">First Name</label>
                                          <input class="form-control" id="name_first" type="text" name="name_first" value="">
                                      </div>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col">
                                      <div class="form-group">
                                          <label for="name_last">Last name</label>
                                          <input class="form-control" id="name_last" type="text" name="name_last" value="">
                                      </div>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col">
                                      <label for="role">Role</label>
                                      <select name="role" id="role" class="form-control">
                                          <option value="user" id="default-role">User</option>
                                          <option value="admin">Admin</option>
                                      </select>
                                  </div>
                                  <div class="col align-self-end">
                                      <div class="custom-control custom-switch">
                                          <input type="checkbox" class="custom-control-input" id="change-status" name="status">
                                          <label class="custom-control-label" for="change-status">Choose user's status</label>
                                      </div>
                                  </div>
                              </div>
                          </form>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="button" class="btn-submit btn btn-primary">Okay</button>
                      </div>
                  </div>
              </div>
          </div>

          <div class="modal fade" id="alert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-body">

                      </div>
                      <div class="modal-footer py-1">
                          <button type="button" class="btn btn-sm" data-dismiss="modal">Close</button>
                      </div>
                  </div>
              </div>
          </div>
          <div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-body">
                          <div class="alert alert-danger d-none" role="alert"></div>
                          <span class="text"></span>
                      </div>
                      <div class="modal-footer py-1">
                          <button type="button" class="btn btn-default" id="modal-btn-yes">Yes</button>
                          <button type="button" class="btn btn-primary" id="modal-btn-no">No</button>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </div>
  </div>



  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="/main.js"></script>
</body>
</html>