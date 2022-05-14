<?php
require_once 'php/main_func.php';
?>

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
                  <div class="col-sm-4">
                    <div class="row">
                          <div class="">
                              <button class="btn add" data-toggle="modal" data-target="#add-edit" data-whatever="Add">Add</button>
                          </div>
                          <div class="col">
                              <select name="status" id="status" class="form-control inline-block">
                                  <option value="default" selected>Please Select</option>
                                  <option value="1">Set active</option>
                                  <option value="0">Set not active</option>
                                  <option value="del">Delete</option>
                              </select>
                          </div>
                          <div class="">
                              <button class="btn ok-button">OK</button>
                          </div>
                      </div>
                  </div>
                <div class="e-table">
                  <div class="table-responsive table-lg mt-3">
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
                      <tbody>
                      <?php foreach ($users as $user): ?>
                          <tr id="tr-<?=$user['id']?>">
                              <td class="align-middle">
                                  <div
                                          class="custom-control custom-control-inline custom-checkbox custom-control-nameless m-0 align-top">
                                      <input type="checkbox" class="custom-control-input" id="item-<?=$user['id']?>" value="<?=$user['id']?>">
                                      <label class="custom-control-label" for="item-<?=$user['id']?>"></label>
                                  </div>
                              </td>
                              <td class="text-nowrap align-middle name"><?=htmlspecialchars($user['name_first']) . PHP_EOL . htmlspecialchars($user['name_last'])?></td>
                              <td class="text-nowrap align-middle"><span class="role"><?=htmlspecialchars($user['role'])?></span></td>
                              <td class="text-center align-middle"><i class="status fa fa-circle <?= $user['status'] ? 'active-circle' :  'not-active-circle'?>"></i></td>
                              <td class="text-center align-middle">
                                  <div class="btn-group align-top">
                                      <button class="btn btn-sm btn-outline-secondary badge edit" type="button" data-toggle="modal" data-target="#add-edit" data-whatever="Edit" data-id="<?=$user['id']?>" data-namefirst="<?=htmlspecialchars($user['name_first'])?>" data-namelast="<?=htmlspecialchars($user['name_last'])?>">Edit</button>
                                      <button class="btn btn-sm btn-outline-secondary badge delete" type="button" data-id="<?=$user['id']?>"><i
                                                  class="fa fa-trash"></i></button>
                                  </div>
                              </td>
                          </tr>
                      <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                  <div class="col-sm-4">
                      <div class="row">
                          <div class="">
                              <button class="btn add" data-toggle="modal" data-target="#add-edit" data-whatever="Add">Add</button>
                          </div>
                          <div class="col">
                              <select name="status" id="status" class="form-control inline-block">
                                  <option value="default" selected>Please Select</option>
                                  <option value="1">Set active</option>
                                  <option value="0">Set not active</option>
                                  <option value="del">Delete</option>
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
                              <div class="row mt-2">
                                  <div class="col">
                                      <div class="custom-control custom-switch">
                                          <input type="checkbox" class="custom-control-input" id="customSwitch1" name="status">
                                          <label class="custom-control-label" for="customSwitch1">Choose user's status</label>
                                      </div>
                                  </div>
                                  <div class="col">
                                      <select name="role" id="role" class="form-control">
                                          <option value="user">User</option>
                                          <option value="admin">Admin</option>
                                      </select>
                                  </div>
                              </div>
                          </form>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="submit" class="submit btn btn-primary">Okay</button>
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
      </div>
    </div>
  </div>



  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="main.js"></script>
</body>
</html>