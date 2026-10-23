<?php
    if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

         if(isset($_POST['usun']))
        {
            $id = $_POST['id'];
            $connect = new PDO("mysql:host=localhost;dbname=czekolandia", "root", "");
            $query = $connect->query("DELETE FROM `users` WHERE `id` = '$id';");
        }
        if(isset($_POST['zapisz']))
        {
            $connect = new PDO("mysql:host=localhost;dbname=czekolandia", "root", "");
            $id = $_POST['id'];
            $login = $_POST['login'];
            $mail = $_POST['mail'];
            $admin = $_POST['admin'];
            $query = $connect->prepare("UPDATE `users` SET `login` = :login, `mail` = :mail, `admin` = :admin WHERE `id` = :id;");
            $query->execute([
                'id' => $id,
                'login' => $login,
                'mail' => $mail,
                'admin' => $admin
            ]);
        }
    }

?>
<script>
    edytujUzytkownika = (id) => {
        console.log(id);
        const guzik = document.getElementById(id + "guzik");
        console.log(id + "guzik");

        if(document.querySelector(".pole-edycji"))
        {
            document.querySelector(".pole-edycji").remove();
            return;
        }

        const poleEdycji = document.createElement("div");
        poleEdycji.classList.add("pole-edycji")
        poleEdycji.style.position = "relative";
        poleEdycji.style.left = "60px";
        poleEdycji.style.bottom = "50px";
        poleEdycji.style.border = "2px solid black";

        const formularz = document.createElement("form");
        formularz.style.display = "flex";
        formularz.style.flexDirection = "column";
        formularz.method = "POST";

        const hiddenId = document.createElement("input");
        hiddenId.setAttribute("type", "hidden");
        hiddenId.setAttribute("name", "id");
        hiddenId.value = id;
        formularz.appendChild(hiddenId);

        const usun = document.createElement("button");
        usun.textContent = "Usuń";
        usun.style.backgroundColor = "red"
        usun.style.color = "white";
        usun.name = "usun"
        usun.type = "submit"

        const edytuj = document.createElement("button");
        edytuj.textContent = "Edytuj";
        edytuj.type = "button";

        edytuj.addEventListener("click", () => {
            const modal = document.createElement("div");
            modal.classList.add("modal");

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.remove();
                }
            }

            const modalContent = document.createElement("dialog");
            modalContent.classList.add("modal-content");
            modalContent.open = true;
            const values = document.querySelector("tr#r" + id);

            const form = document.createElement("form");
            form.method = "POST";
            const idInput = document.createElement("input");
            idInput.type = "hidden";
            idInput.value = values.querySelector(".id").innerText;
            idInput.name = "id";
            const login = document.createElement("input");
            login.name = "login";
            login.type = "text";
            login.value = values.querySelector(".login").innerText;
            const mail = document.createElement("input");
            mail.name = "mail"
            mail.value = values.querySelector(".mail").innerText;
            const admin = document.createElement("select");
            admin.name = "admin"
            admin.type = "text";
                const tak = document.createElement("option");
                tak.value = "1"
                tak.textContent = "Tak"
                const nie = document.createElement("option");
                nie.value = "0"
                nie.textContent = "Nie"
                admin.appendChild(tak);
                admin.appendChild(nie);
            admin.value = values.querySelector(".admin").innerText;

            const submit = document.createElement("button");
            submit.type = "submit";
            submit.textContent = "Zapisz"
            submit.name = "zapisz";

            form.appendChild(login);
            form.appendChild(idInput);
            form.appendChild(mail);
            form.appendChild(admin);
            form.appendChild(submit);
            modalContent.appendChild(form);
            modal.appendChild(modalContent);
            document.body.appendChild(modal);
        });

        formularz.appendChild(usun);
        formularz.appendChild(edytuj);
        poleEdycji.appendChild(formularz);
        guzik.appendChild(poleEdycji);
    };
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
                <th>admin</th>
            </tr>
            <?php
                $connect = new PDO("mysql:host=localhost;dbname=czekolandia", "root", "");
                $query = $connect->query("SELECT * FROM `users`;");
                $rows = $query->fetchAll();

                foreach($rows as $row)
                {
                    echo("<tr id='r{$row['id']}'>
                            <td class='id'>{$row['id']}</td>
                            <td class='login'>{$row['login']}</td>
                            <td class='mail'>{$row['mail']}</td>
                            <td class='admin'>{$row['admin']}</td>
                            <td id='{$row['id']}guzik'><button onClick='edytujUzytkownika({$row['id']})'>Edytuj</button></td>
                        </tr>");
                }
            ?>
        </table>
    </div>
</div>
