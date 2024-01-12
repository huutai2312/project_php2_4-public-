<?php

class Controller
{
    public function importHeader()
    {
        include_once "../asm/app/view/inc/header.php";
    }

    public function importFooter()
    {
        include_once "../asm/app/view/inc/footer.php";
    }
    public function indexUser()
    {
        $this->importHeader();
        include "../asm/app/view/tai-khoan.php";
        $this->importFooter();
    }

}
