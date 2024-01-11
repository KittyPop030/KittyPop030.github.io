<?php
$sql = "SELECT User.username, User.firstName, User.lastName, User.roleID, Role.roleName,User.userID                  
        FROM User
        INNER JOIN Role ON User.roleID = Role.roleID
        ORDER BY roleName";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $username = $row["username"];
        $firstname = $row["firstName"];
        $lastname = $row["lastName"];
        $role = $row["roleName"];
        $userID = $row["userID"];

        echo '                       
                        <tr>
                            <td>' . $username . '</td>
                            <td>' . $firstname . '</td>
                            <td>' . $lastname . '</td>
                            <td>' . $role . '</td>                                                       
                            <td><form method="POST" action="processphp/processrolechange.php">
                            <input type="hidden" name="userID" value="' . $userID . '">
                            <input type="hidden" name="username" value="' . $username . '">
                            <label for="role">Select a role:&nbsp</label>
                            <select name="role">
                            <option value="3"' . ($role == 'Author' ? ' selected' : '') . '>Author</option>
                            <option value="2"' . ($role == 'Member' ? ' selected' : '') . '>Member</option>
                            <option value="1"' . ($role == 'Visitor' ? ' selected' : '') . '>Visitor</option>                           
                            </select>&nbsp&nbsp                            
                            <button type="submit" class = "rolebutton">Update</button></form></td>
                        </tr>';
    }
}
