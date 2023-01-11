<?php
include 'connection.php';
include 'header.php';

if (isset($_GET['del'])) {
    $del_record = "delete from   where id=" . $_GET['del'];
    $mysqli->query($del_record);
    header("Location:index.php?msg=del");
}
if (isset($_POST['submit'])) {
    if (isset($_GET['id'])) {
        $edit_query = "UPDATE emp SET name = '" . $_POST['name'] . "', role = '" . $_POST['role'] . "', level = '" . $_POST['level'] . "', gender = '" . $_POST['gender'] . "' WHERE id = " . $_GET['id'];
        // echo $edit_query; exit;
        $upt_result = $mysqli->query($edit_query);
        header("location:index.php?msg=upt");

    } else {
        $sql = "INSERT into emp (name, role, level, gender) VALUES('" . $_POST['name'] . "', '" . $_POST['role'] . "', '" . $_POST['level'] . "', '" . $_POST['gender'] . "')";
        if (!$mysqli->query($sql)) {
            echo "Can't insert records into database";
            die($mysqli->error);
        } else {
            echo "Record Inserted Successfully";
            header('Location:index.php?msg=save');
        }
    }
}
if (isset($_GET['id'])) {
    $get_record_query = "SELECT * FROM emp WHERE id = " . $_GET['id'];
    $result = $mysqli->query($get_record_query);
    $fetch_row = mysqli_fetch_assoc($result);
} else {
    $dis_record = "SELECT * FROM emp";
    $query = $mysqli->query($dis_record);
}
if (isset($_GET['type'])) {
    if ($_GET['type'] == 'add' || $_GET['type'] == 'edit') {
        ?>
        <!-- Data Form -->
        <div class="container">
            <form action="" method="post">
                <!-- Employee Name -->
                <div class="fields">
                    <label for="name">Employee Name</label>
                    <input type="text" name="name" id="name" value="<?php if (isset($_GET['id'])) {
                        echo $fetch_row['name'];
                    } ?>"/>
                </div>

                <!-- Role -->
                <div class="fields">
                    <label for="role">Role</label>
                    <input type="text" name="role" id="name" value="<?php if (isset($_GET['id'])) {
                        echo $fetch_row['role'];
                    } ?>"/>
                </div>

                <div class="fields">
                    <label for="level">Choose Your Level:</label>
                    <select name="level">
                        <!-- C - Level -->
                        <option value="c-level" <?php if (isset($_GET['id'])) {
                            if ($fetch_row['level'] == 'c-level') {
                                echo "selected";
                            }
                        } ?> >C-Level
                        </option>

                        <!-- Manager -->
                        <option value="manager" <?php if (isset($_GET['id'])) {
                            if ($fetch_row['level'] == 'manager') {
                                echo "selected";
                            }
                        } ?>>Manager
                        </option>

                        <!-- Manager -->
                        <option value="senior" <?php if (isset($_GET['id'])) {
                            if ($fetch_row['level'] == 'senior') {
                                echo "selected";
                            }
                        } ?>>Senior
                        </option>

                        <option value="junior" <?php if (isset($_GET['id'])) {
                            if ($fetch_row['level'] == 'junior') {
                                echo "selected";
                            }
                        } ?>>Junior
                        </option>

                        <option value="trainee" <?php if (isset($_GET['id'])) {
                            if ($fetch_row['level'] == 'trainee') {
                                echo "selected";
                            }
                        } ?>>Trainee
                        </option>

                    </select>

                    <!-- Gender -->
                    <div class="fields">
                        <span>Gender:</span>
                        <!-- Male -->
                        <input type="radio" name="gender" value="male" <?php if (isset($_GET['id'])) {
                            if ($fetch_row['gender'] == 'male') {
                                echo "checked";
                            }
                        } ?> >
                        <label for="male">Male</label> 
                        <!-- Female -->
                        <input type="radio" name="gender" value="female" <?php if (isset($_GET['id'])) {
                            if ($fetch_row['gender'] == 'female') {
                                echo "checked";
                            }
                        } ?>>
                        <label for="male">Female</label><br>
                    </div>
                </div>
                <button type="submit" name="submit">Submit</button>
            </form>
        </div>
        <?php
    }
} else {
    ?>
    <!-- Alert Message -->
    <?php if (isset($_GET['msg'])) {
        if ($_GET['msg'] == 'save') {
            ?>
            <div class="alert-msg">
                <p>Record added successfully.</p>
            </div>
            <?php
        } elseif ($_GET['msg'] == 'upt') {
            ?>
            <div class="alert-msg">
                <p>Record updated successfully.</p>
            </div>
        <?php } else { ?>
            <div class="alert-msg">
                <p>Record deleted successfully.</p>
            </div>
        <?php }
    }
    ?>
    <!-- Display Data in Table -->
    <div class="record-display">
        <a href="index.php?type=add">Add new record</a>
        <table class="mb-3">
            <thead class="table-head">
            <tr>
                <th>ID</th>
                <th>Employee Name</th>
                <th>Role</th>
                <th>Level</th>
                <th>Gender</th>
                <th>Action</th>
            </tr>
            </thead>
            <?php while ($result = $query->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $result['id'] ?></td>
                    <td><?php echo $result['name'] ?></td>
                    <td><?php echo $result['role'] ?></td>
                    <td><?php echo $result['level'] ?></td>
                    <td><?php echo $result['gender'] ?></td>
                    <td>
                        <a href="index.php?type=edit&id=<?php echo $result['id']; ?>">Edit</a>
                        <a onclick="return confirm('Are you sure you want to delete this entry?')"
                           href="index.php?del=<?php echo $result['id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
<?php }
?>
</body>
</html>
