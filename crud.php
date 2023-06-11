<?php
include 'koneksi.php';

// Create
if (isset($_POST['submit'])) {
    $imagePath = $_FILES['image']['tmp_name'];
    $text = $_POST['text'];
    $link = "";

    // Check if a file is uploaded
    if (isset($_FILES['link']) && $_FILES['link']['size'] > 0) {
        $linkPath = $_FILES['link']['tmp_name'];
        $linkName = $_FILES['link']['name'];
        $link = "uploads/" . $linkName;
        move_uploaded_file($linkPath, $link);
    } else {
        $link = $_POST['link'];
    }

    $date = $_POST['date'];

    // Handle image upload
    $targetDir = 'uploads/';
    $imageName = uniqid() . '_' . $_FILES['image']['name'];
    $targetPath = $targetDir . $imageName;
    move_uploaded_file($imagePath, $targetPath);

    // Insert record into the database
    $insertQuery = "INSERT INTO news (image_path, text, link, date) VALUES ('$targetPath', '$text', '$link', '$date')";
    mysqli_query($koneksi, $insertQuery);

    // Redirect to refresh the page
    header("Location: crud.php");
    exit();
}

// Read
$query = "SELECT id, image_path, text, link, date FROM news";
$result = mysqli_query($koneksi, $query);

// Update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $updatedText = $_POST['updated_text'];
    $updatedLink = $_POST['updated_link'];
    $updatedDate = $_POST['updated_date'];

    // Update the record in the database
    $updateQuery = "UPDATE news SET text='$updatedText', link='$updatedLink', date='$updatedDate' WHERE id=$id";
    mysqli_query($koneksi, $updateQuery);

    // Redirect to refresh the page
    header("Location: crud.php");
    exit();
}

// Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Delete the record from the database
    $deleteQuery = "DELETE FROM news WHERE id=$id";
    mysqli_query($koneksi, $deleteQuery);

    // Redirect to refresh the page
    header("Location: crud.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD Example</title>
    <style>
        .delete-button {
            background-color: red;
            color: white;
        }
        .edit-button {
            background-color: green;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Add record form -->
    <h2>Add New Record</h2>
    <form method="POST" enctype="multipart/form-data">
        <label for="image">Image:</label>
        <input type="file" name="image" required><br>
        <br>
        <label for="text">Text:</label>
        <input type="text" name="text" required><br>
        <br>
        <label for="link">Upload File:</label>
        <input type="file" name="link" accept=".txt,.pdf,.doc,.docx,.mp4">
        <p>Or enter Link
        <input type="text" name="link" placeholder="Enter a link"></p>

        <label for="date">Date:</label>
        <input type="date" name="date" required><br>
        <br>
        <input type="submit" name="submit" value="Add">
    </form>

    <!-- Display records -->
    <h2>Records</h2>
    <table>
        <tr>
            <th>Image</th>
            <th>Text</th>
            <th>Link</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><img src="<?php echo $row['image_path']; ?>" alt="Image" width="100"></td>
                <td><?php echo $row['text']; ?></td>
                <td><?php echo $row['link']; ?></td>
                <td><?php echo $row['date']; ?></td>
                <td>
                    <form method="POST" style="display: inline-block;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button class="edit-button" type="submit" name="edit">Edit</button>
                    </form>
                    <a class="delete-button" href="crud.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>

    <!-- Edit record form -->
    <?php
    if (isset($_POST['edit'])) {
        $id = $_POST['id'];
        $editQuery = "SELECT id, text, link, date FROM news WHERE id=$id";
        $editResult = mysqli_query($koneksi, $editQuery);
        $editRow = mysqli_fetch_assoc($editResult);
    ?>
    <h2>Edit Record</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $editRow['id']; ?>">
        <label for="updated_text">Text:</label>
        <input type="text" id="updated_text" name="updated_text" value="<?php echo $editRow['text']; ?>" required><br>

        <label for="updated_link">Reupload File:</label>
        <input type="file" name="updated_link" accept=".txt,.pdf,.doc,.docx,.mp4">
        <p>Or Edit Link
        <input type="text" name="updated_link" value="<?php echo $editRow['link']; ?>" placeholder="Enter a link"></p>

        <label for="updated_date">Date:</label>
        <input type="date" id="updated_date" name="updated_date" value="<?php echo $editRow['date']; ?>" required><br>
        <br>
        <input type="submit" name="update" value="Update">
    </form>
    <?php } ?>
        <!-- Button to go back to localhost/test -->
        <a href="index.html">Go back to main</a>
</body>
</html>





