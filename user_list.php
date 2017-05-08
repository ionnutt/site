<?php

session_start();



/**
 * verificam daca sesiunea este inceputa
 */
if (empty($_SESSION['logged_in'])) {

  header('Location: ./login.php');
  exit;
} // (empty($_SESSION['logged_in']))



require_once('./function.php');



?><?php include_once('./header.php') ?>

<br>
<br>

<?php include_once ('./errors.php') ?>


<div class="row column">
  <h1>Lista Users</h1>
</div>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Nume</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Password</th>
    </tr>
  </thead>
  <tbody><?php

  /**
   * facem un query pentru a gasi utilizatorul in baza de date
   */
  $sql = 'SELECT * FROM users ORDER BY username ASC';
  $result = mysqli_query($db, $sql);


  if ($result) {

     // trecem prin toate rezultatele gasite si creem un obiect pe care il folosim la validare
    while ($row = mysqli_fetch_array($result)) {

    ?>

    <tr>
      <td><?php echo $row['id'] ?></td>
      <td><?php echo $row['username'] ?></td>
      <td><?php echo $row['first_name'] ?></td>
      <td><?php echo $row['last_name'] ?></td>
      <td><?php echo $row['password'] ?></td>
      <th width="150">
        <a href="./users_edit.php?id=<?php echo $row['id'] ?>">Editeaza</a>
        <a href="./index.php?action=delete&id=<?php echo $row['id'] ?>&source=users">Sterge</a>
      </th>
    </tr>

    <?php

    }

    // Free result set
    mysqli_free_result($result);

  }

  ?></tbody>
</table>

