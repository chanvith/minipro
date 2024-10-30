  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>ฟอร์มเพิ่มข้อมูล Admin</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-outline card-info">
            <!-- /.card-header -->
            <div class="card-body">
              <div class="card card-primary">
                <!-- /.card-header -->
                <!-- form start -->
                <form action="" method="post" enctype="multipart/form-data">
                  <div class="card-body">

                    <div class="form-group">
                      <label for="username">Username</label>
                      <input type="text" class="form-control" id="username" placeholder="Username" required>
                    </div>

                    <div class="form-group">
                      <label for="password">Password</label>
                      <input type="password" class="form-control" id="password" placeholder="Password" required>
                    </div>

                    <div class="form-group">
                      <label for="adminName">Admin Name</label>
                      <input type="text" class="form-control" id="adminName" placeholder="Username">
                    </div>

                    <div class="form-group">
                      <label for="adminName">Profile Photo</label>
                      <input type="file" class="form-control" id="adminName" required accept="image/*">
                    </div>

                    <div class="form-group">
                      <label for="exampleInputFile">File input</label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="exampleInputFile">
                          <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                        <div class="input-group-append">
                          <span class="input-group-text">Upload</span>
                        </div>
                      </div>
                    </div>

                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="" class="btn btn-danger">Cancel</a>
                  </div>
                </form>
              </div>

            </div>

          </div>
        </div>
        <!-- /.col-->
      </div>
      <!-- ./row -->

      <!-- ./row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->