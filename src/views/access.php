<?php
require_once __DIR__ . "/parts/header.php";
?>
    <div id="access">
        <div id="access__container">
            <h1 id="access__title" class="text-center">jjFileUpload</h1>
            <div class="d-flex justify-content-center align-items-center mt-3">
                <form action="/access" method="POST">
                    <div class="d-flex flex-column">
                        <input class="form-control" type="text" name="input__user" id="input__user" placeholder="Username" />
                        <input class="form-control mt-2" type="password" name="input__password" id="input__password" placeholder="Password" />
                    </div>

                    <div class="mt-2">
                        <input class="btn btn-primary" name="action__login" type="submit" value="Logar" />
                        <input class="btn btn-primary" name="action__register" type="submit" value="Registrar" />
                    </div>
                </form>
            </div>
        </div> 
    </div>
    
<?php
require_once __DIR__ . "/parts/footer.php";
?>
