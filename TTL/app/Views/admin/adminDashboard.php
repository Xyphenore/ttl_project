
<section class='container border border-secondary my-auto rounded-3 p-4 mb-4'>
    <?php // Chargement des icones nécessaire 
    ?>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css'>

    <h2>Administration </h2>
    <hr />

    <?php
    $warning_admin = session()->getFlashdata('error_delete_admin');
    if (!empty($warning_admin)) {
        echo '<div class="bg-warning border border-success rounded-3 pt-2 d-flex mb-2">
                            <p class="text-white mx-auto">Impossible de supprimer un compte admin</p>
                    </div>';
    }
    ?>

    <form action="<?= esc(base_url('actionAdminDashboard')) ?>" method="post" id="dashboard-action">
        <?= csrf_field() ?>
       
    </form>

    <div class="row px-4 py-2 g-3">
        <?php //Bloc Annonces 
        ?>
        <div class="col-lg-4">
            <button class='border border-secondary w-100 h-100 rounded-3  p-3 bg-white' role='button' form='dashboard-action' name='act' type='submit' value='Annonces'>
                <div class='pb-2'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='60' height='60' fill='currentColor' class='bi bi-house' viewBox='0 0 16 16'>
                        <path fill-rule='evenodd' d='M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z' />
                        <path fill-rule='evenodd' d='M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z' />
                    </svg>
                    <h3 class='fs-2 text-black text-decoration-underline'>Annonces:</h3>
                </div>

                <p class='pl-2'>Administration des annonces</p>
            </button>
        </div>


        <?php //Bloc Message 
        ?>
        <div class="col-lg-4">
            <button class='border border-secondary rounded-3 w-100 h-100 p-3 bg-white' role='button' form='dashboard-action' name='act' type='submit' value='Utilisateurs'>
                <div class='pb-2'>
                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
  <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
  <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
</svg>
                    <h3 class='fs-2 text-black text-decoration-underline'>Utilisateurs :</h3>
                   
    

                </div>

                <p>Gérer les utilisateurs</p>
            </button>
        </div>


        <?php //Bloc Paramètres 
        ?>
        <div class="col-lg-4">
            <button class='border border-secondary rounded-3 w-100 h-100 p-3 bg-white' role='button' form='dashboard-action' name='act' type='submit' value='Paramètre'>
                <div class='pb-2'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='60' height='60' fill='currentColor' class='bi bi-gear' viewBox='0 0 16 16'>
                        <path d='M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z' />
                        <path d='M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z' />
                    </svg>
                    <h3 class='fs-2 text-black text-decoration-underline'>Paramètres :</h3>
                </div>

                <p>Editer vos informations. </p>
            </button>
        </div>
    </div>

    <?php
    //Partie admin
    if (session()->isAdmin) {
        echo '<div class=\'row px-4 py-2 g-3\'>
                    <a href="' . esc(base_url('admin/dashboard')) . '" class="btn btn-secondary text-white">Vers la page administration</a>
                </div>';
    }
    ?>
</section>