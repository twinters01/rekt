<?php require APPROOT.'/views/inc/header.php';?>

    <?php
      $presentingUser = $data['user'];
      require APPROOT.'/views/snippets/user/basicInfo.php';
    ?>
    <?php
      $decks = isset($data['decks'])?$data['decks']:NULL;
      require APPROOT.'/views/snippets/deckslist.php';
    ?>

<?php require APPROOT.'/views/inc/footer.php';?>
<?php require APPROOT.'/views/snippets/modals/deckImportModal.php';?>
