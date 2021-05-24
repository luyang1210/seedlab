<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Domain Registrar Service</title>
  </head>
  <body>
    <h1>Domain Registrar Service</h1>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>



    <div class="card text-center">
      <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
          <li class="nav-item">
            <a class="nav-link active" href="#"><?php echo $_GET['dname']; ?></a>
          </li>
        </ul>
      </div>
      <div class="card-body">
        <form action="domain.php?dname=<?php echo $_GET['dname']; ?>" method="POST">
          <h5 class="card-title">Add resolve record</h5>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">Host Record</th>
                    <th scope="col">Record Type</th>
                    <th scope="col">Record value</th>
                    <th scope="col">TTL</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row"><input type="text" class="form-control" name="dname" value="<?php echo $_GET['dname']; ?>" readonly></th>
                    <td>A</td>
                    <td><input type="text" class="form-control" name="dvalue" placeholder="IP address"></td>
                    <td>10</td>
                  </tr>
                </tbody>
              </table>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </body>
</html>
<?php
if(!empty($_POST['dname']) && !empty($_POST['dvalue']) ){
  $domain_name = $_POST['dname'];
  $ip_address = $_POST['dvalue'];
  $register_command = 'echo "update add '.$domain_name.'.com 60 A '.$ip_address.'\nsend\n" | nsupdate';
  $escaped_command = escapeshellcmd($register_command);
  system($escaped_command);

  echo "<script>alert('success on adding record!');window.history.back();</script>";

}

?>
