<?php


function ouvertureBdd(){
    try
    {
        $db = new PDO('mysql:host=127.0.0.1;dbname=hospitalE2N;charset=utf8', 'root', '');
    }
    catch (Exception $e)
    {
            die('Erreur : ' . $e->getMessage());
    }
};

function prettyDump($data){
    highlight_string("<?php\n\$data =\n" . var_export($data, true) . ";\n?>");
};