<?php
    class Home extends Controller{
        function Home(){
            $this->view('master',['page' => 'home']);
        }
    }
?>