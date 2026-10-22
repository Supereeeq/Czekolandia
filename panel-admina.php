<script>
    edytujUzytkownika = (id) => {
        console.log(id);
        const guzik = document.getElementById(id + "guzik");
        console.log(id + "guzik");
        const poleEdycji = document.createElement("div");
        
    }
</script>

<div id="panel-admina">
    <button onClick="document.getElementById('uzytkownicy').classList.toggle('niewidoczne')">Edytuj Użytkowników</button>
    <div class="niewidoczne" id="uzytkownicy">
        <p>Użytkownicy</p>
        <table>
            <tr>
                <th>ID</th>
                <th>login</th>
                <th>mail</th>
            </tr>
            <?php
                $connect = new PDO("mysql:host=localhost;dbname=czekolandia", "root", "");
                $query = $connect->query("SELECT * FROM `users`;");
                $rows = $query->fetchAll();

                foreach($rows as $row)
                {
                    echo("<tr id='{$row['id']}'>
                            <td>{$row['id']}</td>
                            <td>{$row['login']}</td>
                            <td>{$row['mail']}</td>
                            <td id='{$row['id']}guzik'><button onClick='edytujUzytkownika({$row['id']})'>Edytuj</button></td>
                        </tr>");
                }
            ?>
        </table>
    </div>
</div>
