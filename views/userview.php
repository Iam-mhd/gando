<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tous Les Utilisateurs</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #ffecd2, #fcb69f);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        h1 {
            color: #333;
        }

        .buttons {
            margin-bottom: 20px;
        }

        button {
            background: linear-gradient(to right, #ff6a6a, #fcb69f);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.3s ease;
            margin: 5px;
        }

        button:hover {
            background: linear-gradient(to right, #fcb69f, #ff6a6a);
        }

        .back-button {
            background: linear-gradient(to right, #007bff, #00c6ff);
        }

        .back-button:hover {
            background: linear-gradient(to right, #0056b3, #0084ff);
        }

        table {
            width: 100%;
            max-width: 1000px;
            background: white;
            border-collapse: collapse;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            margin: 20px 0;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        th {
            background: #fcb69f;
            color: white;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        tr:hover {
            background: #f1f1f1;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.17/jspdf.plugin.autotable.min.js"></script>
</head>
<body>
    <h1>Tous Les Utilisateurs</h1>
    <div class="buttons">
        <button class="back-button" onclick="history.back()">Retour</button>
        <button id="download-csv">Télécharger CSV</button>
        <button id="download-pdf">Télécharger PDF</button>
        <button onclick="window.print()">Imprimer</button>
    </div>

    <?php if (!empty($users)): ?>
        <table id="users-table">
            <thead>
                <tr>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Téléphone</th>
                    <th>Email</th>
                    <th>Mot de Passe</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['prenom']); ?></td>
                        <td><?php echo htmlspecialchars($user['nom']); ?></td>
                        <td><?php echo htmlspecialchars($user['telephone']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['mot_de_passe']); ?></td>
                       
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucun utilisateur trouvé</p>
    <?php endif; ?>

    <script>
        document.getElementById('download-csv').addEventListener('click', function () {
            let table = document.getElementById('users-table');
            let rows = table.querySelectorAll('tr');
            let csvContent = '';

            rows.forEach(function (row) {
                let cols = row.querySelectorAll('td, th');
                let rowData = Array.from(cols).map(col => col.innerText).join(',');
                csvContent += rowData + '\n';
            });

            let blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            let link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'users.csv';
            link.click();
        });

        document.getElementById('download-pdf').addEventListener('click', function () {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            
            const table = document.getElementById('users-table');
            const headers = Array.from(table.querySelectorAll('thead tr th')).map(header => header.innerText);
            const rows = Array.from(table.querySelectorAll('tbody tr')).map(row => 
                Array.from(row.querySelectorAll('td')).map(cell => cell.innerText)
            );

            doc.autoTable({
                head: [headers],
                body: rows
            });

            doc.save('users.pdf');
        });
    </script>
</body>
</html>
