<?php
session_start();
session_destroy();
unset($_COOKIE['KakeSpade']);
unset($_COOKIE['KakeBit']);
setcookie('KakeSpade', null, -1, '/');
setcookie('KakeBit', null, -1, '/');
header("Location: http://www.tryggvisning.no");
?>