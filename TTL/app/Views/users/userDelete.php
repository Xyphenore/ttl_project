<section class="container mx-auto my-auto border border-dark rounded-3 p-4 bg-white d-flex flex-column">

    <h1 class='fs-2 mx-auto'>Voulez-vous définitivement supprimer votre compte ?</h1>
    <hr/>

    <form action="<?= esc(base_url('UserDelete')) ?>" method='post' class='mx-auto pt-1'>
        <?= csrf_field() ?>

        <input type="submit" name="delete" value="OUI" class="btn btn-danger btn-lg"/>
        <input type='submit' name='delete' value='Non' class="btn btn-secondary btn-lg"/>
    </form>

</section>
