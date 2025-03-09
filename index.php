<?php
$host = 'localhost';
$user = 'root'; // Remplacez par votre utilisateur
$pass = ''; // Remplacez par votre mot de passe
$db = 'emploi_du_temps';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ajouter un emploi du temps
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'ajouter') {
    $jour = $_POST['jour'];
    $matiere = $_POST['matiere'];
    $date = $_POST['date'];
    $heure_debut = $_POST['heure_debut'];
    $heure_fin = $_POST['heure_fin'];

    $sql = "INSERT INTO horaires (jour, matiere, date, heure_debut, heure_fin) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $jour,$matiere, $date, $heure_debut, $heure_fin);
    $stmt->execute();
    echo "Horaire ajouté avec succès.";
}

// Mettre à jour un emploi du temps
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'modifier') {
    $id = $_POST['id'];
    $jour = $_POST['jour'];
    $matiere = $_POST['matiere'];
    $date = $_POST['date'];
    $heure_debut = $_POST['heure_debut'];
    $heure_fin = $_POST['heure_fin'];

    $sql = "UPDATE horaires SET jour = ?, matiere = ?, date = ?, heure_debut = ?, heure_fin = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $jour, $matiere, $date, $heure_debut, $heure_fin, $id);
    $stmt->execute();
    echo "Horaire mis à jour avec succès.";
}

// Supprimer un emploi du temps
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'supprimer') {
    $id = $_POST['id'];

    $sql = "DELETE FROM horaires WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo "Horaire supprimé avec succès.";
}

// Afficher tous les emplois du temps
$sql = "SELECT * FROM horaires";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Emplois du Temps</title>
    <link rel="stylesheet" href="./styles.css">
</head>
<body>
    <h2>Gestion des Emplois du Temps</h2>
    <div>
        <!-- Affichage des emplois du temps -->
        <h3>Liste des Emplois du Temps</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Jour</th>
                <th>Matiere</th>
                <th>Date</th>
                <th>Heure de Début</th>
                <th>Heure de Fin</th>
            </tr>
            <?php while ($horaire = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars ($horaire['id']); ?></td>
                    <td><?php echo htmlspecialchars ($horaire['jour']); ?></td>
                    <td><?php echo htmlspecialchars ($horaire['matiere']); ?></td>
                    <td><?php echo htmlspecialchars ($horaire['date']); ?></td>
                    <td><?php echo htmlspecialchars ($horaire['heure_debut']); ?></td>
                    <td><?php echo htmlspecialchars ($horaire['heure_fin']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- Formulaires d'ajout et de mise à jour en deux colonnes -->
    <div class="form-container">
         <!-- Formulaire d'ajout -->
            <div class="form-section">
                <h3>Ajouter un Emploi du Temps</h3>
                <form method="POST">
                    <input type="hidden" name="action" value="ajouter">
                    <label> Jour:</label>
                    <input type="text" name="jour" required>

                    <label>Matiere:</label>
                    <input type="text" name="matiere" required>
    
                    <label>Date:</label>
                    <input type="date" name="date" required>
        
                    <label>Heure de Début:</label>
                    <input type="time" name="heure_debut" required>
    
                    <label>Heure de Fin:</label>
                    <input type="time" name="heure_fin" required>
                    <input type="submit" value="Ajouter">
                </form>
            </div>

            <div class="form-section">
                <!-- Formulaire de mise à jour -->
                <h3>Mettre à Jour un Emploi du Temps</h3>
                <form method="POST">
                    <input type="hidden" name="action" value="modifier">
                    <label>ID:</label>
                    <input type="text" name="id" required>

                    <label> Jour:</label>
                    <input type="text" name="jour" required>
    
                    <label>Matiere:</label>
                    <input type="text" name="matiere" required>
    
                    <label>Date:</label>
                    <input type="date" name="date" required>
                            
                    <label>Heure de Début:</label>
                    <input type="time" name="heure_debut" required>
                            
                    <label>Heure de Fin:</label>
                    <input type="time" name="heure_fin" required>
                    <input type="submit" value="Modifier">
                </form>
            </div>

            <div class="form-section">
                <!-- Formulaire de suppression -->
                <h3>Supprimer un Emploi du Temps</h3>
                <form method="POST">
                    <input type="hidden" name="action" value="supprimer">
                            
                    <label>ID:</label>
                    <input type="text" name="id" required>
                    <input type="submit" value="Supprimer">
                </form>
            </div>
    </div>  
    <!--script src="script.js"></script-->
</body>
</html>

<?php
$conn->close();
?>
