<?php if(!empty(session()->getFlashdata('error')) || !empty(session()->getFlashdata('success')))
{
?>
<div class="row page-titles flashsmessages">
    <?= session()->getFlashdata('error') ?>
    <?= session()->getFlashdata('success') ?>
    <!-- <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Form</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Element</a></li>
    </ol> -->
</div>
<?php
unset($_SESSION['error']);
unset($_SESSION['success']);
}
?>